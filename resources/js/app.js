const tourImage = document.querySelector("#tour-image");

if (tourImage) {
    let currentNode;
    let isTransitioning = false;
    let nodesById;

    const wait = (milliseconds) =>
        new Promise((resolve) => window.setTimeout(resolve, milliseconds));

    const preloadImage = (url) =>
        new Promise((resolve, reject) => {
            const image = new Image();

            image.onload = resolve;
            image.onerror = reject;
            image.src = url;
        });

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
            await preloadImage(nextNode.pic_url);

            tourImage.classList.add("opacity-0");
            await wait(150);

            tourImage.src = nextNode.pic_url;
            tourImage.alt = `Rundgang: ${nextNode.name}`;

            currentNode = nextNode;

            requestAnimationFrame(() => {
                tourImage.classList.remove("opacity-0");
            });

            await wait(300);
        } catch (error) {
            console.error("Das nächste Bild konnte nicht geladen werden.", error);
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

            nodesById = new Map(
                nodes.map((node) => [Number(node.id), node]),
            );

            currentNode = nodes.find((node) => node.start);

            if (!currentNode?.pic_url) {
                throw new Error("Im Admin ist kein Startbild festgelegt.");
            }

            tourImage.src = currentNode.pic_url;
            tourImage.alt = `Rundgang: ${currentNode.name}`;

            window.addEventListener("wheel", moveWithScroll, {
                passive: false,
            });
        } catch (error) {
            console.error(error);
        }
    }

    loadTour();
}
