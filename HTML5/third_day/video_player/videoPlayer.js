window.addEventListener("load", function(e){
const listWrapper=this.document.getElementById("videosList")
video=this.document.getElementById("displayed")
let videosCount=15
for(let  i=1;i<videosCount+1;i++){
    newButton=this.document.createElement("button")
    newButton.name=i;
    newButton.textContent=`video ${i}`
    newButton.className="videoButton"
    newButton.addEventListener("click",function(e){
       video.src=`lol/${i}.mkv`
       console.log(e.target.name)
    })//end button click event
    listWrapper.appendChild(newButton)
}//end loop
video.addEventListener("click",function(e){
video.paused?video.play():video.pause()
})//end click video event
video.addEventListener("dblclick",function(e){
video.parentNode.requestFullscreen()
})//end double click video event

})//end of load