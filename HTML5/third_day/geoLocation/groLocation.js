window.addEventListener("load",()=>{
const displayMap=document.getElementById("map");
const showDetails=document.getElementById("details");
const content=document.getElementById("content");
displayMap.addEventListener("click",function(e){
if (navigator.geolocation){
navigator.geolocation.getCurrentPosition(getPosition, errorHandler)
}
else{
    content.innerText="Maps are not supported update and check again"
}
})//end display event
showDetails.addEventListener("click", function(e){

})
})//end load
function getPosition(position){
    let long =position.coords.longitude
    let lat= position.coords.latitude
    console.log(long)
           var location = new google.maps.LatLng(lat, long);
            //2- specify specs of map : zoom : , center
            var specs = { zoom: 17, center: location };
            // 3 retrive map and display map
            new google.maps.Map(content, specs);
        
}
 function errorHandler(){
            alert("Error");
        }