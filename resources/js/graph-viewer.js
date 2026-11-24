const graphRoot = document.querySelector("#node-graph");

if (graphRoot) {
    const viewport = document.querySelector("#graph-viewport");
    const canvas = document.querySelector("#graph-canvas");
    const edges = document.querySelector("#graph-edges");
    const nodesElement = document.querySelector("#graph-nodes");
    const search = document.querySelector("#graph-search");
    const status = document.querySelector("#graph-status");
    const fitButton = document.querySelector("#graph-fit");
    const resetButton = document.querySelector("#graph-reset");
    const nodeName = document.querySelector("#graph-node-name");
    const nodeMeta = document.querySelector("#graph-node-meta");
    const nodeImage = document.querySelector("#graph-node-image");
    const forward = document.querySelector("#graph-forward");
    const back = document.querySelector("#graph-back");
    const sides = document.querySelector("#graph-sides");
    const layoutKey = "htl-os-node-graph-layout";
    const nodeWidth = 228;
    const nodeHeight = 72;

    let graphNodes = [];
    let nodesById = new Map();
    let positions = new Map();
    let selectedNodeId = null;
    let transform = { x: 80, y: 80, scale: 0.7 };
    let panState = null;
    let dragState = null;

    function setStatus(message) {
        status.textContent = message;
    }

    function targetFor(node, direction) {
        return nodesById.get(Number(node[`${direction}_id`]));
    }

    function defaultLayout() {
        const levels = [];
        const assignedIds = new Set();
        const roots = [graphNodes.find((node) => node.start), ...graphNodes].filter(Boolean);

        roots.forEach((root) => {
            if (assignedIds.has(root.id)) {
                return;
            }

            const queue = [{ node: root, level: 0 }];
            assignedIds.add(root.id);

            while (queue.length) {
                const { node, level } = queue.shift();
                levels[level] ??= [];
                levels[level].push(node.id);

                ["forward", "left", "right"].forEach((direction) => {
                    const target = targetFor(node, direction);

                    if (target && !assignedIds.has(target.id)) {
                        assignedIds.add(target.id);
                        queue.push({ node: target, level: level + 1 });
                    }
                });
            }
        });

        const calculatedPositions = new Map();
        let xOffset = 140;

        levels.forEach((level) => {
            const rows = Math.ceil(Math.sqrt(level.length));
            const columns = Math.ceil(level.length / rows);

            level.forEach((nodeId, index) => {
                calculatedPositions.set(Number(nodeId), {
                    x: xOffset + Math.floor(index / rows) * 310,
                    y: 150 + (index % rows) * 135,
                });
            });

            xOffset += columns * 310 + 130;
        });

        return calculatedPositions;
    }

    function restoreLayout() {
        try {
            const savedLayout = JSON.parse(window.localStorage.getItem(layoutKey));

            if (!savedLayout || savedLayout.nodeCount !== graphNodes.length) {
                return null;
            }

            const savedPositions = new Map(
                Object.entries(savedLayout.positions).map(([id, position]) => [
                    Number(id),
                    position,
                ]),
            );

            return graphNodes.every((node) => savedPositions.has(node.id))
                ? savedPositions
                : null;
        } catch {
            return null;
        }
    }

    function saveLayout() {
        const serializedPositions = Object.fromEntries(positions);

        window.localStorage.setItem(layoutKey, JSON.stringify({
            nodeCount: graphNodes.length,
            positions: serializedPositions,
        }));
    }

    function applyTransform() {
        canvas.style.transform = `translate(${transform.x}px, ${transform.y}px) scale(${transform.scale})`;
    }

    function updateInspector(node) {
        if (!node) {
            nodeName.textContent = "Kein Node ausgewählt";
            nodeMeta.textContent = "Klicke einen Node an, um seine Verbindungen zu sehen.";
            nodeImage.classList.add("hidden");
            forward.textContent = "—";
            back.textContent = "—";
            sides.textContent = "—";

            return;
        }

        const forwardNode = targetFor(node, "forward");
        const backNode = targetFor(node, "back");
        const leftNode = targetFor(node, "left");
        const rightNode = targetFor(node, "right");

        nodeName.textContent = node.name;
        nodeMeta.textContent = node.start ? "Startbild" : node.node_type || "Flur";
        forward.textContent = forwardNode?.name || "—";
        back.textContent = backNode?.name || "—";
        sides.textContent = `${leftNode?.name || "—"} / ${rightNode?.name || "—"}`;

        if (node.pic_url) {
            nodeImage.src = node.pic_url;
            nodeImage.alt = `Vorschau von ${node.name}`;
            nodeImage.classList.remove("hidden");
        } else {
            nodeImage.classList.add("hidden");
        }
    }

    function selectNode(nodeId) {
        selectedNodeId = nodeId;
        const selectedNode = nodesById.get(nodeId);

        nodesElement.querySelectorAll(".graph-node").forEach((element) => {
            element.classList.toggle("is-selected", Number(element.dataset.nodeId) === nodeId);
        });

        updateInspector(selectedNode);
    }

    function createGraphNode(node) {
        const nodeElement = document.createElement("button");
        const position = positions.get(node.id);
        nodeElement.type = "button";
        nodeElement.className = "graph-node";
        nodeElement.dataset.nodeId = node.id;
        nodeElement.style.left = `${position.x}px`;
        nodeElement.style.top = `${position.y}px`;

        if (node.pic_url) {
            const image = document.createElement("img");
            image.src = node.pic_url;
            image.alt = "";
            nodeElement.append(image);
        } else {
            const placeholder = document.createElement("span");
            placeholder.className = "graph-node__placeholder";
            placeholder.textContent = "□";
            nodeElement.append(placeholder);
        }

        const content = document.createElement("span");
        const name = document.createElement("span");
        const type = document.createElement("span");
        name.className = "block truncate text-sm font-semibold";
        type.className = "mt-1 block truncate text-xs text-stone-400";
        name.textContent = node.name;
        type.textContent = node.start ? "Startbild" : node.node_type || "Flur";
        content.append(name, type);
        nodeElement.append(content);

        nodeElement.addEventListener("click", () => {
            if (!dragState?.moved) {
                selectNode(node.id);
            }
        });

        nodeElement.addEventListener("pointerdown", (event) => {
            event.stopPropagation();
            nodeElement.setPointerCapture(event.pointerId);
            selectNode(node.id);
            dragState = {
                nodeId: node.id,
                pointerId: event.pointerId,
                startX: event.clientX,
                startY: event.clientY,
                position: { ...positions.get(node.id) },
                moved: false,
            };
            viewport.classList.add("is-dragging");
        });

        nodeElement.addEventListener("pointermove", (event) => {
            if (dragState?.nodeId !== node.id || dragState.pointerId !== event.pointerId) {
                return;
            }

            const deltaX = (event.clientX - dragState.startX) / transform.scale;
            const deltaY = (event.clientY - dragState.startY) / transform.scale;

            if (Math.abs(deltaX) > 2 || Math.abs(deltaY) > 2) {
                dragState.moved = true;
            }

            const nextPosition = {
                x: Math.max(0, dragState.position.x + deltaX),
                y: Math.max(0, dragState.position.y + deltaY),
            };
            positions.set(node.id, nextPosition);
            nodeElement.style.left = `${nextPosition.x}px`;
            nodeElement.style.top = `${nextPosition.y}px`;
            renderEdges();
        });

        nodeElement.addEventListener("pointerup", (event) => {
            if (dragState?.nodeId === node.id && dragState.pointerId === event.pointerId) {
                saveLayout();
                dragState = null;
                viewport.classList.remove("is-dragging");
            }
        });

        return nodeElement;
    }

    function renderEdges() {
        edges.replaceChildren(edges.querySelector("defs"));

        graphNodes.forEach((node) => {
            const source = positions.get(node.id);

            ["forward", "back", "left", "right"].forEach((direction) => {
                const targetNode = targetFor(node, direction);
                const target = targetNode && positions.get(targetNode.id);

                if (!source || !target) {
                    return;
                }

                const line = document.createElementNS("http://www.w3.org/2000/svg", "line");
                line.setAttribute("x1", String(source.x + nodeWidth / 2));
                line.setAttribute("y1", String(source.y + nodeHeight / 2));
                line.setAttribute("x2", String(target.x + nodeWidth / 2));
                line.setAttribute("y2", String(target.y + nodeHeight / 2));
                line.setAttribute("class", `graph-edge graph-edge--${direction}`);
                edges.append(line);
            });
        });
    }

    function renderNodes() {
        nodesElement.replaceChildren(...graphNodes.map(createGraphNode));
        renderEdges();
    }

    function fitGraph() {
        if (!positions.size) {
            return;
        }

        const allPositions = [...positions.values()];
        const minX = Math.min(...allPositions.map((position) => position.x));
        const maxX = Math.max(...allPositions.map((position) => position.x)) + nodeWidth;
        const minY = Math.min(...allPositions.map((position) => position.y));
        const maxY = Math.max(...allPositions.map((position) => position.y)) + nodeHeight;
        const viewportBounds = viewport.getBoundingClientRect();
        const availableWidth = Math.max(viewportBounds.width - 96, 1);
        const availableHeight = Math.max(viewportBounds.height - 96, 1);
        const scale = Math.min(1, Math.max(0.08, availableWidth / (maxX - minX), availableHeight / (maxY - minY)));

        transform = {
            scale,
            x: (viewportBounds.width - (maxX - minX) * scale) / 2 - minX * scale,
            y: (viewportBounds.height - (maxY - minY) * scale) / 2 - minY * scale,
        };
        applyTransform();
    }

    function filterNodes(term) {
        const normalizedTerm = term.trim().toLocaleLowerCase("de-AT");

        nodesElement.querySelectorAll(".graph-node").forEach((element) => {
            const node = nodesById.get(Number(element.dataset.nodeId));
            const matches = !normalizedTerm || node.name.toLocaleLowerCase("de-AT").includes(normalizedTerm);
            element.classList.toggle("is-filtered", !matches);
        });
    }

    viewport.addEventListener("pointerdown", (event) => {
        if (event.target.closest(".graph-node")) {
            return;
        }

        viewport.setPointerCapture(event.pointerId);
        panState = {
            pointerId: event.pointerId,
            startX: event.clientX,
            startY: event.clientY,
            transform: { ...transform },
        };
        viewport.classList.add("is-panning");
    });

    viewport.addEventListener("pointermove", (event) => {
        if (!panState || panState.pointerId !== event.pointerId) {
            return;
        }

        transform.x = panState.transform.x + event.clientX - panState.startX;
        transform.y = panState.transform.y + event.clientY - panState.startY;
        applyTransform();
    });

    viewport.addEventListener("pointerup", (event) => {
        if (panState?.pointerId === event.pointerId) {
            panState = null;
            viewport.classList.remove("is-panning");
        }
    });

    viewport.addEventListener("wheel", (event) => {
        event.preventDefault();
        const bounds = viewport.getBoundingClientRect();
        const cursorX = event.clientX - bounds.left;
        const cursorY = event.clientY - bounds.top;
        const nextScale = Math.min(1.6, Math.max(0.08, transform.scale * (event.deltaY > 0 ? 0.9 : 1.1)));
        const scaleRatio = nextScale / transform.scale;

        transform.x = cursorX - (cursorX - transform.x) * scaleRatio;
        transform.y = cursorY - (cursorY - transform.y) * scaleRatio;
        transform.scale = nextScale;
        applyTransform();
    }, { passive: false });

    search.addEventListener("input", () => filterNodes(search.value));
    fitButton.addEventListener("click", fitGraph);
    resetButton.addEventListener("click", () => {
        window.localStorage.removeItem(layoutKey);
        positions = defaultLayout();
        renderNodes();
        fitGraph();
        setStatus("Automatisches Layout wiederhergestellt.");
    });

    fetch(graphRoot.dataset.apiUrl)
        .then((response) => {
            if (!response.ok) {
                throw new Error("Die Nodes konnten nicht geladen werden.");
            }

            return response.json();
        })
        .then((payload) => {
            graphNodes = payload.data;
            nodesById = new Map(graphNodes.map((node) => [Number(node.id), node]));
            positions = restoreLayout() || defaultLayout();
            renderNodes();
            requestAnimationFrame(fitGraph);
            setStatus(`${graphNodes.length} Nodes geladen.`);
        })
        .catch((error) => {
            console.error(error);
            setStatus(error.message);
        });
}
