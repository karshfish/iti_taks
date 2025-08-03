

window.addEventListener("load", function(e){
const top=this.document.getElementById("top")
const bottom=this.document.getElementById("bottom")
let price = document.getElementById("price")
price.value=0
price.readOnly=true
if(top.childElementCount===1){
    top.children[0].style.display="block"
}
const allImg=this.document.images
for(let i=0;i<allImg.length;i++){
    allImg[i].addEventListener("dragstart",dragStart)
    allImg[i].addEventListener("dragend",dragEnd)
}
bottom.addEventListener("drop",dropped)
bottom.addEventListener("dragenter",dragEnter)
bottom.addEventListener("dragover",dragOver)
bottom.addEventListener("dragleave",dragLeave)
top.addEventListener("dragleave",dragLeave)
top.addEventListener("drop",dropped)
top.addEventListener("dragenter",dragEnter)
top.addEventListener("dragover",dragOver)
})//end load
let quantity=0;
let  targetPhoto;

function dragStart(e){
    let img=e.target.outerHTML
    e.dataTransfer.setData("my_img",img)
    targetPhoto=e.target;
    quantity = e.target.getAttribute("data-quantity")
    console.log(quantity)
}
function dragEnd(e){
    // console.log(bottom.getBoundingClientRect())
    
    //  quantity--;
    //  e.target.setAttribute("data-quantity",quantity)
    if(quantity==0){
         e.target.remove()
    }
   

   
}
function dropped(e){
    e.preventDefault();
    quantityChange(this)
        let photosExist=bottom.children
        let clacprice=0;
        for(i=0;i<photosExist.length;i++){
            itemPrice= +photosExist[i].getAttribute("data-price")
            itemsQuantit= +photosExist[i].getAttribute("data-quantity")
            clacprice+=(itemPrice*itemsQuantit)
            
        
            }
            price.value=clacprice;

}
function dragOver(e) {
            e.preventDefault();
        }
function dragEnter(e) {
            e.preventDefault();
        }
function dragLeave(e) {
            e.preventDefault();
        }
function quantityChange(_dropped){
    photosExist=_dropped.children;
    for(let i=0;i<photosExist.length;i++){
        if(photosExist[i].name===targetPhoto.name){
            existQuan=+(photosExist[i].getAttribute('data-quantity'))
            existQuan++
            photosExist[i].setAttribute("data-quantity",existQuan)
            quantity--;
            targetPhoto.setAttribute("data-quantity",quantity)
            return;
        }
        
    }
    newdrop=document.createElement("img")
    newdrop.src=targetPhoto.src
    newdrop.name=targetPhoto.name
    newdrop.setAttribute("data-price",targetPhoto.getAttribute("data-price"))
    newdrop.setAttribute("data-quantity",1)
    newdrop.addEventListener("dragstart",dragStart)
    newdrop.addEventListener("dragend",dragEnd)
    _dropped.appendChild(newdrop)
    quantity--;
    targetPhoto.setAttribute("data-quantity",quantity)

}