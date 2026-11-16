const tourImage = document.querySelector("#tour-image");

if (tourImage) {
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

            const imageUrl = new URL(nextNode.pic_url, window.location.href).href;

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
            console.error("Das nächste Bild konnte nicht vorbereitet werden.", error);
        });
    }

    async function moveWithScroll(event) {
        event.preventDefault();

        if (isTransitioning || Math.abs(event.deltaY) < 20) {
            return;
        }

        const nextNodeId =
            event.deltaY > 0 ? currentNode.forward_id : currentNode.back_id;
        const nextNode = nodesById.get(Number(nextNodeId));

        if (!nextNode?.pic_url) {
            return;
        }

        isTransitioning = true;

        try {
            const imageUrl = new URL(nextNode.pic_url, window.location.href).href;
            const image =
                nextForwardImage?.url === imageUrl
                    ? await nextForwardImage.promise
                    : await preloadImage(imageUrl);

            tourImage.src = image.src;
            tourImage.alt = `Rundgang: ${nextNode.name}`;

            currentNode = nextNode;
            prefetchImagesAhead(currentNode);
            prepareNextForwardImage(currentNode);
        } catch (error) {
            console.error(
                "Das nächste Bild konnte nicht geladen werden.",
                error,
            );
        } finally {
            isTransitioning = false;
        }
    }

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
