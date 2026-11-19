const tourImage = document.querySelector("#tour-image");
const tourCacheKey = "htl-os-tour-nodes";

function setBootState({ progress, text, canStart }) {
    const bootProgress = document.querySelector("#boot-progress");
    const bootText = document.querySelector("#boot-text");
    const startTour = document.querySelector("#start-tour");

    if (bootProgress?.style) {
        bootProgress.style.width = `${progress}%`;
    }

    if (bootText) {
        bootText.textContent = text;
    }

    if (startTour) {
        startTour.disabled = !canStart;
        startTour.setAttribute("aria-disabled", String(!canStart));
    }
}

async function fetchTourNodes() {
    const response = await fetch("/api/nodes");

    if (!response.ok) {
        throw new Error("Die Nodes konnten nicht geladen werden.");
    }

    const payload = await response.json();

    return payload.data;
}

function loadBootScreen() {
    const startTour = document.querySelector("#start-tour");

    if (!startTour?.addEventListener) {
        return;
    }

    setBootState({
        progress: 15,
        text: "Rundgang wird vorbereitet …",
        canStart: false,
    });

    fetchTourNodes()
        .then((nodes) => {
            const startNode = nodes.find((node) => node.start);

            if (!startNode?.pic_url) {
                throw new Error("Im Admin ist noch kein Startbild festgelegt.");
            }

            window.sessionStorage?.setItem(tourCacheKey, JSON.stringify(nodes));
            setBootState({
                progress: 100,
                text: `${nodes.length} Bilder bereit.`,
                canStart: true,
            });
        })
        .catch((error) => {
            setBootState({ progress: 0, text: error.message, canStart: false });
        });

    startTour.addEventListener("click", () => {
        if (!startTour.disabled) {
            window.location.assign(startTour.dataset.tourUrl);
        }
    });
}

function loadTour() {
    if (!tourImage) {
        return;
    }

    const directionButtons = Array.from(
        document.querySelectorAll("[data-arrow], [data-tour-direction]"),
    );
    const status = document.querySelector("#tour-status");
    const loading = document.querySelector("#tour-loading");
    const location = document.querySelector("#hud-location");
    const hint = document.querySelector("#hud-hint");
    const enterPrompt = document.querySelector("#enter-prompt");
    const roomView = document.querySelector("#room-view");
    const roomClose = document.querySelector("#room-close");
    const roomName = document.querySelector("#room-name");
    const roomTeacherName = document.querySelector("#room-teacher-name");
    const roomTeacherImage = document.querySelector("#room-teacher-image");
    const roomDialogue = document.querySelector("#room-dialogue");
    const roomGallery = document.querySelector("#room-gallery");

    let currentNode;
    let isTransitioning = false;
    let nodesById;
    let nextForwardImage;
    let touchStart;
    const prefetchedImages = new Set();

    function showStatus(message) {
        if (status) {
            status.textContent = message;
        }
    }

    function setLoading(isLoading) {
        if (loading) {
            loading.hidden = !isLoading;
        }

        tourImage.setAttribute?.("aria-busy", String(isLoading));
    }

    function nodeForDirection(node, direction) {
        return nodesById.get(Number(node[`${direction}_id`]));
    }

    function prefetchImage(url) {
        const imageUrl = new URL(url, window.location.href).href;

        if (prefetchedImages.has(imageUrl)) {
            return;
        }

        const link = document.createElement("link");
        link.rel = "prefetch";
        link.as = "image";
        link.href = imageUrl;
        document.head?.append(link);
        prefetchedImages.add(imageUrl);
    }

    function prefetchImagesAhead(startNode, count = 5) {
        let node = startNode;
        const visitedNodeIds = new Set([Number(startNode.id)]);

        for (let index = 0; index < count; index++) {
            const nextNode = nodeForDirection(node, "forward");

            if (!nextNode?.pic_url || visitedNodeIds.has(Number(nextNode.id))) {
                break;
            }

            prefetchImage(nextNode.pic_url);
            visitedNodeIds.add(Number(nextNode.id));
            node = nextNode;
        }

        ["back", "left", "right"].forEach((direction) => {
            const nextNode = nodeForDirection(startNode, direction);

            if (nextNode?.pic_url) {
                prefetchImage(nextNode.pic_url);
            }
        });
    }

    async function preloadImage(url) {
        const image = new Image();
        image.src = url;
        await image.decode();

        return image;
    }

    function prepareNextForwardImage(node) {
        const nextNode = nodeForDirection(node, "forward");

        if (!nextNode?.pic_url) {
            nextForwardImage = null;

            return;
        }

        const imageUrl = new URL(nextNode.pic_url, window.location.href).href;
        const promise = preloadImage(imageUrl);

        nextForwardImage = { url: imageUrl, promise };
        promise.catch(() => {
            nextForwardImage = null;
        });
    }

    function updateTourUi() {
        directionButtons.forEach((button) => {
            const direction = button.dataset.arrow || button.dataset.tourDirection;
            const nextNode = nodeForDirection(currentNode, direction);
            const isAvailable = Boolean(nextNode?.pic_url);

            button.hidden = !isAvailable;
            button.disabled = !isAvailable;
            button.setAttribute?.("aria-disabled", String(!isAvailable));

            if (direction === "forward") {
                button.textContent = "↑ Geradeaus";
            }

            if (direction === "back") {
                button.textContent = "↓ Zurück";
            }
        });

        if (location) {
            location.textContent = currentNode.department || currentNode.name;
        }

        if (hint) {
            hint.textContent = currentNode.node_type === "room"
                ? "E drücken, um den Raum zu öffnen"
                : "Mausrad, Pfeiltasten oder W/A/S/D verwenden";
        }

        if (enterPrompt) {
            enterPrompt.hidden = currentNode.node_type !== "room";
        }
    }

    function updateCurrentNode(node, imageUrl) {
        tourImage.src = imageUrl;
        tourImage.alt = `Rundgang: ${node.name}`;
        currentNode = node;
        prefetchImagesAhead(currentNode);
        prepareNextForwardImage(currentNode);
        updateTourUi();
    }

    async function moveToDirection(direction) {
        if (isTransitioning || roomView?.open) {
            return;
        }

        const nextNode = nodeForDirection(currentNode, direction);

        if (!nextNode?.pic_url) {
            return;
        }

        isTransitioning = true;
        setLoading(true);
        showStatus("Nächstes Bild wird geladen …");

        try {
            const imageUrl = new URL(nextNode.pic_url, window.location.href).href;
            const image = nextForwardImage?.url === imageUrl
                ? await nextForwardImage.promise
                : await preloadImage(imageUrl);

            updateCurrentNode(nextNode, image.src);
            showStatus("");
        } catch (error) {
            console.error("Das nächste Bild konnte nicht geladen werden.", error);
            showStatus("Dieses Bild konnte nicht geladen werden.");
        } finally {
            setLoading(false);
            isTransitioning = false;
        }
    }

    function openRoom() {
        if (currentNode.node_type !== "room" || !roomView?.showModal) {
            return;
        }

        roomName.textContent = currentNode.room_name || currentNode.name;
        roomTeacherName.textContent = currentNode.teacher_name || "Information folgt";
        roomDialogue.textContent = currentNode.dialogue_text || "Zu diesem Raum sind noch keine Informationen hinterlegt.";

        if (roomTeacherImage) {
            roomTeacherImage.hidden = !currentNode.teacher_image;
            roomTeacherImage.src = currentNode.teacher_image || "";
        }

        if (roomGallery) {
            roomGallery.replaceChildren();

            currentNode.project_images?.forEach((imageUrl, index) => {
                const image = document.createElement("img");
                image.src = imageUrl;
                image.alt = `Projektbild ${index + 1}`;
                image.className = "aspect-video w-full rounded-xl object-cover";
                roomGallery.append(image);
            });
        }

        roomView.showModal();
    }

    function closeRoom() {
        if (roomView?.open) {
            roomView.close();
        }
    }

    function moveWithScroll(event) {
        event.preventDefault();

        if (Math.abs(event.deltaY) >= 20) {
            moveToDirection(event.deltaY > 0 ? "forward" : "back");
        }
    }

    function moveWithKeyboard(event) {
        const key = event.key.toLowerCase();
        const directionByKey = {
            arrowdown: "forward",
            arrowup: "back",
            arrowleft: "left",
            arrowright: "right",
            w: "forward",
            s: "back",
            a: "left",
            d: "right",
        };
        const direction = directionByKey[key];

        if (direction) {
            event.preventDefault();
            moveToDirection(direction);
        }

        if (key === "e") {
            openRoom();
        }

        if (event.key === "Escape") {
            closeRoom();
        }
    }

    directionButtons.forEach((button) => {
        button.addEventListener("click", () => {
            moveToDirection(button.dataset.arrow || button.dataset.tourDirection);
        });
    });

    enterPrompt?.addEventListener?.("click", openRoom);
    roomClose?.addEventListener?.("click", closeRoom);
    window.addEventListener("wheel", moveWithScroll, { passive: false });
    window.addEventListener("keydown", moveWithKeyboard);
    document.addEventListener?.("touchstart", (event) => {
        touchStart = event.touches[0];
    }, { passive: true });
    document.addEventListener?.("touchend", (event) => {
        if (!touchStart) {
            return;
        }

        const touchEnd = event.changedTouches[0];
        const deltaX = touchEnd.clientX - touchStart.clientX;
        const deltaY = touchEnd.clientY - touchStart.clientY;
        touchStart = null;

        if (Math.max(Math.abs(deltaX), Math.abs(deltaY)) < 50) {
            return;
        }

        if (Math.abs(deltaX) > Math.abs(deltaY)) {
            moveToDirection(deltaX > 0 ? "left" : "right");

            return;
        }

        moveToDirection(deltaY < 0 ? "forward" : "back");
    }, { passive: true });

    async function getTourNodes() {
        const cachedNodes = window.sessionStorage?.getItem(tourCacheKey);

        if (cachedNodes) {
            try {
                return JSON.parse(cachedNodes);
            } catch {
                window.sessionStorage?.removeItem(tourCacheKey);
            }
        }

        return fetchTourNodes();
    }

    getTourNodes()
        .then((nodes) => {
            nodesById = new Map(nodes.map((node) => [Number(node.id), node]));
            const startNode = nodes.find((node) => node.start);

            if (!startNode?.pic_url) {
                throw new Error("Im Admin ist kein Startbild festgelegt.");
            }

            updateCurrentNode(startNode, startNode.pic_url);
            setLoading(false);
        })
        .catch((error) => {
            console.error(error);
            setLoading(false);
            showStatus(error.message);
        });
}

loadBootScreen();
loadTour();
