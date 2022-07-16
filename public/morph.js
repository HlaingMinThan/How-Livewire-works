function morph(el1,el2){

    //create element
    if(typeof el2==='string'){
        let el=document.createElement('div');
        el.innerHTML=el2;
        el2=el.firstElementChild;
    }

  
    if(el1.tagName !== el2.tagName){
        //copy el2 node and replace with el1
        el1.replaceWith(el2.cloneNode(true));
        return;
    }
    patchText(el1,el2)
    patchAttributes(el1,el2)
    patchChildren(el1,el2)
}

function patchChildren(el1,el2){
    let from = el1.firstElementChild;
    let to = el2.firstElementChild;
    while(to){
        if(!from){
           from= el1.appendChild(to.cloneNode(true))
        }else{
            morph(from,to);
        }
        to=to.nextElementSibling;
        from=from.nextElementSibling;
    }

    while(from){
        let toRemove=from;
        from = from.nextElementSibling;
        toRemove.remove();
    }
}


function patchAttributes(el1,el2){
    
     //if el2 attributes are exists in el1 leave it, if not,remove it from el1
    for(let {name,value} of el1.attributes){            
        if(!el2.hasAttribute(name,value)){
            el1.removeAttribute(name)
        }
    }
    
    // copy el2 attributes and replace in el1
    for(let {name,value} of el2.attributes){               
        el1.setAttribute(name,value);
    }
}

function patchText(el1,el2){
    if(el2.children.length) return //if update element have children ,return and exit out (edge case)
    el1.textContent=el2.textContent;
}