const tourImage = document.querySelector("#tour-image");

if (tourImage) {
    let directionButtons = Array.from(
        document.querySelectorAll("[data-tour-direction]"),
    );

    if (directionButtons.length === 0) {
        directionButtons = ["left", "right"].map((direction) => {
            const button = document.createElement("button");
            button.type = "button";
            button.dataset.tourDirection = direction;
            button.setAttribute(
                "aria-label",
                direction === "left"
                    ? "Nach links abbiegen"
                    : "Nach rechts abbiegen",
            );
            button.hidden = true;
            button.textContent = direction === "left" ? "← Links" : "Rechts →";
            Object.assign(button.style, {
                position: "fixed",
                top: "50%",
                transform: "translateY(-50%)",
                zIndex: "10",
                [direction === "left" ? "left" : "right"]: "16px",
                padding: "12px 16px",
                border: "1px solid rgba(255, 255, 255, 0.25)",
                borderRadius: "9999px",
                background: "rgba(0, 0, 0, 0.55)",
                color: "white",
                font: "inherit",
                cursor: "pointer",
            });
            document.body.append(button);

            return button;
        });
    }

    let currentNode;
    let isTransitioning = false;
    let nodesById;
    const prefetchedImages = new Set();
    let nextForwardImage;

    function prefetchImagesAhead(startNode, count = 5) {
        let node = startNode;
        const visitedNodeIds = new Set([Number(startNode.id)]);

        for (let index = 0; index < count; index++) {
            const nextNode = nodesById.get(Number(node.forward_id));

            if (!nextNode || visitedNodeIds.has(Number(nextNode.id))) {
                break;
            }

            const imageUrl = new URL(nextNode.pic_url, window.location.href)
                .href;

            if (!prefetchedImages.has(imageUrl)) {
                const link = document.createElement("link");
                link.rel = "prefetch";
                link.as = "image";
                link.href = imageUrl;
                document.head.append(link);
                prefetchedImages.add(imageUrl);
            }

            visitedNodeIds.add(Number(nextNode.id));
            node = nextNode;
        }
    }

    const wait = (milliseconds) =>
        new Promise((resolve) => window.setTimeout(resolve, milliseconds));

    const preloadImage = async (url) => {
        const image = new Image();
        image.src = url;
        await image.decode();

        return image;
    };

    function prepareNextForwardImage(node) {
        const nextNode = nodesById.get(Number(node.forward_id));

        if (!nextNode?.pic_url) {
            nextForwardImage = null;

            return;
        }

        const imageUrl = new URL(nextNode.pic_url, window.location.href).href;
        const promise = preloadImage(imageUrl);

        nextForwardImage = { url: imageUrl, promise };

        promise.catch((error) => {
            console.error(
                "Das nächste Bild konnte nicht vorbereitet werden.",
                error,
            );
        });
    }

    function updateDirectionButtons() {
        directionButtons.forEach((button) => {
            const direction = button.dataset.tourDirection;
            const nextNode = nodesById.get(
                Number(currentNode[`${direction}_id`]),
            );

            button.hidden = !nextNode?.pic_url;

            if (direction === "forward") {
                button.textContent = "↑ Geradeaus";

                return;
            }

            const label =
                nextNode?.department ||
                (direction === "left" ? "Links" : "Rechts");

            button.textContent =
                direction === "left" ? `← ${label}` : `${label} →`;
        });
    }

    async function moveToDirection(direction) {
        if (isTransitioning) {
            return;
        }

        const nextNodeId = currentNode[`${direction}_id`];
        const nextNode = nodesById.get(Number(nextNodeId));

        if (!nextNode?.pic_url) {
            return;
        }

        isTransitioning = true;

        try {
            const imageUrl = new URL(nextNode.pic_url, window.location.href)
                .href;
            const image =
                nextForwardImage?.url === imageUrl
                    ? await nextForwardImage.promise
                    : await preloadImage(imageUrl);

            tourImage.src = image.src;
            tourImage.alt = `Rundgang: ${nextNode.name}`;

            currentNode = nextNode;
            prefetchImagesAhead(currentNode);
            prepareNextForwardImage(currentNode);
            updateDirectionButtons();
        } catch (error) {
            console.error(
                "Das nächste Bild konnte nicht geladen werden.",
                error,
            );
        } finally {
            isTransitioning = false;
        }
    }

    function moveWithScroll(event) {
        event.preventDefault();

        if (Math.abs(event.deltaY) < 20) {
            return;
        }

        moveToDirection(event.deltaY > 0 ? "forward" : "back");
    }

    directionButtons.forEach((button) => {
        button.addEventListener("click", () => {
            moveToDirection(button.dataset.tourDirection);
        });
    });

    async function loadTour() {
        try {
            const response = await fetch("/api/nodes");

            if (!response.ok) {
                throw new Error("Die Nodes konnten nicht geladen werden.");
            }

            const payload = await response.json();
            const nodes = payload.data;

            nodesById = new Map(nodes.map((node) => [Number(node.id), node]));

            currentNode = nodes.find((node) => node.start);

            if (!currentNode?.pic_url) {
                throw new Error("Im Admin ist kein Startbild festgelegt.");
            }

            tourImage.src = currentNode.pic_url;
            tourImage.alt = `Rundgang: ${currentNode.name}`;
            updateDirectionButtons();
            prefetchImagesAhead(currentNode);
            prepareNextForwardImage(currentNode);

            window.addEventListener("wheel", moveWithScroll, {
                passive: false,
            });
        } catch (error) {
            console.error(error);
        }
    }

    loadTour();
}
