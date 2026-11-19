import assert from "node:assert/strict";
import { readFile } from "node:fs/promises";
import { setImmediate as yieldToEventLoop } from "node:timers/promises";
import { runInNewContext } from "node:vm";
import test from "node:test";

class MockButton {
    dataset = {};
    handlers = {};
    hidden = true;
    textContent = "";

    addEventListener(type, handler) {
        this.handlers[type] = handler;
    }

    click() {
        this.handlers.click?.();
    }
}

class MockImage {
    set src(value) {
        this.url = new URL(value, "http://localhost/Rundgang").href;
    }

    get src() {
        return this.url;
    }

    decode() {
        return Promise.resolve();
    }
}

test("Geradeaus button loads the linked forward hallway photo", async () => {
    const source = await readFile(
        new URL("../../resources/js/app.js", import.meta.url),
        "utf8",
    );
    const nodes = [
        {
            id: 1,
            name: "Start",
            start: true,
            forward_id: 2,
            left_id: null,
            right_id: null,
            pic_url: "/start.jpg",
        },
        {
            id: 2,
            name: "Flur weiter",
            back_id: 1,
            forward_id: null,
            pic_url: "/hallway.jpg",
        },
    ];
    const buttons = ["left", "forward", "right"].map((direction) => {
        const button = new MockButton();
        button.dataset.tourDirection = direction;

        return button;
    });
    const tourImage = { src: "", alt: "" };
    const context = {
        document: {
            querySelector: () => tourImage,
            querySelectorAll: () => buttons,
            createElement: () => ({}),
            head: { append() {} },
        },
        window: {
            location: { href: "http://localhost/Rundgang" },
            addEventListener() {},
        },
        fetch: async () => ({
            ok: true,
            json: async () => ({ data: nodes }),
        }),
        Image: MockImage,
        URL,
        console,
    };

    runInNewContext(source, context);
    await yieldToEventLoop();
    await yieldToEventLoop();

    const forwardButton = buttons.find(
        (button) => button.dataset.tourDirection === "forward",
    );

    assert.equal(forwardButton.hidden, false);
    assert.equal(forwardButton.textContent.trim(), "↑ Geradeaus");

    forwardButton.click();
    await yieldToEventLoop();
    await yieldToEventLoop();

    assert.equal(tourImage.src, "http://localhost/hallway.jpg");
    assert.equal(tourImage.alt, "Rundgang: Flur weiter");
});
