let snapshotElements = document.querySelectorAll("[wire\\:snapshot]");
snapshotElements.forEach((el) => {
    let snapshot = JSON.parse(el.getAttribute("wire:snapshot"));
    el.__livewire = snapshot;
    initWireClick(el);
});

function initWireClick(el) {
    el.addEventListener("click", (clickEl) => {
        if (!clickEl.target.hasAttribute("wire:click")) return;
        //this is the wire:click button handler
        let callMethod = clickEl.target.getAttribute("wire:click");
        sendRequest(el, { callMethod });
    });
}

async function sendRequest(el, payload) {
    let snapshot = el.__livewire;

    let res = await fetch("/livewire", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({ snapshot, ...payload }),
    });
    let response = await res.json();
    let { html, snapshot: newSnapshot } = response;
    el.__livewire = newSnapshot;
    Alpine.morph(el.firstElementChild,html)
}
