let snapshotElements = document.querySelectorAll("[wire\\:snapshot]");
snapshotElements.forEach((el) => {
    let snapshot = JSON.parse(el.getAttribute("wire:snapshot"));
    el.__livewire = snapshot;
    initWireClick(el);
    initWireModel(el);
});

function initWireModel(el) {
    //set input data
    setServerInputsValues(el)
    //update input data on server side and 
    //if u use event change === wire:model.lazy
    el.addEventListener("input", (inputEl) => {
        if (!inputEl.target.hasAttribute("wire:model")) return;
        //this is the wire:model handler
        sendRequest(el, { propertyUpdate:[inputEl.target.getAttribute('wire:model'),inputEl.target.value]});
    });
}

function setServerInputsValues(el){
    let inputs=el.querySelectorAll('[wire\\:model]');
    inputs.forEach(input=>{
        let propertyName=input.getAttribute('wire:model');
        input.value=el.__livewire.data[propertyName]
    })
}

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

    //set the input values at the end (because we can't know what input value can change on server)
    setServerInputsValues(el)
}
