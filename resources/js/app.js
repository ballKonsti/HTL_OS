const tourImage = document.querySelector("#tour-image");
const tourStatus = document.querySelector("#tour-status");

if (tourImage) {
    fetch("/api/nodes")
        .then((response) => {
            if (!response.ok) {
                throw new Error("Die Nodes konnten nicht geladen werden.");
            }

            return response.json();
        })
        .then((payload) => {
            const startNode = payload.data.find((node) => node.start);

            if (!startNode) {
                throw new Error("Im Admin ist noch kein Startbild festgelegt.");
            }

            tourImage.src = startNode.pic_url;
        })
        .catch((error) => {
            tourStatus.textContent = error.message;
        });
}
