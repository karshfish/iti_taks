let products;
let Qs= window.location.search;
const pagination= document.getElementById("pagination")
if(Qs){
Qs=Qs.split("?")[1].split("=")
console.log(Qs)
}
async function productsJson(){
const fetchedProducts=await fetch("https://openlibrary.org/people/mekBot/books/already-read.json",{cache: 'force-cache'})
// console.log(fetchedProducts)
json= await fetchedProducts.json()
// console.log(json.results)
return json.reading_log_entries;
};

(async function getProducts(){
        let products=await productsJson();
        addPages(products)
        console.log(products)
        let page;

        if(Qs && Qs[0]==="page"){
            page=+Qs[1]
            page--;

        }
        else{
            page=0
        }
        pagination.children[page].className+=" active";
        for(let i=0;i<10;i++){
            itemNum=i+((page)*9);
            if(products[itemNum]){
                let coverSrc=getCover(products[itemNum])
                addCard(products[itemNum],coverSrc);
        }

        }

})()

// console.log(products)
//create a card to a product 
function addCard(_product, _src){
    const mainWrapper=document.getElementById("mainWrapper")
    let card=document.createElement("div")
    card.className="card my-1 mx-1 w-25 mh-25 overflow-auto"
    let cardHeader=document.createElement("div")
    cardHeader.className="card-header"
    cardHeader.innerHTML=`<img src="${_src}" alt = "Book">`
    let cardBody=document.createElement("div")
    cardBody.className="card-body"
    cardBody.innerHTML=`<p>Author: ${_product.work.author_names[0]}</p>
    <p>title: ${_product.work.title}</p>
    <p>Price: 10$`;
    link=document.createElement("a")
    link.setAttribute("href",`productDetails?id=${_product.work.cover_id}`)
    link.className="stretched-link"
    card.appendChild(cardHeader);
    card.appendChild(cardBody)
    card.appendChild(link)
    mainWrapper.appendChild(card);

}
function addPages(_product){
    let pages=Math.ceil(_product.length/10)
    for(let i=1;i<=pages;i++){
    let newPage=document.createElement("li")
        newPage.className="page-item"
        pageAnchor=document.createElement("a")
        pageAnchor.className="page-link"
        pageAnchor.setAttribute("href",`productCatalog.html?page=${i}`)
        pageAnchor.textContent=i;
        newPage.appendChild(pageAnchor)
        pagination.appendChild(newPage)
    }
}
 function getCover(_product){
    const key="id"
    let value=_product.work.cover_id;
    let size = "L";
    let src=`https://covers.openlibrary.org/b/${key}/${value}-${size}.jpg`;
return src
}
