$(document).ready(function(){
    $("#slideUp").mouseenter(function(){
        $("header").slideUp(3000)
    })
    $("#slideDown").mouseenter(function(){
        $("header").slideDown(5000)
    })
})