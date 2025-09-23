$(document).ready(function(){
$("#get").click(function(){
    console.log($("#Task1 header").text())
    console.log($("#Task1>header").html())
})
$("#setText").click(function(){
    $("#Task1 header").text($("#set").val());
  
    })
$("#setHTML").click(function(){
    $("#Task1 header").html("<h1>New Header</h1>")
})

$("#newPhoto").click(function(){
    $("#Task2").append("<img src=https://cdn.twocontinents.com/hfpqy_V7_B_IMG_Dubai_UAE_1200x800_e1936b3330.jpg alt=img width=400px height=400px>")
})
$("#remove").click(function(){
    $("img[alt=testRemove]").remove()
})
$("#addCss").click(function(){
    $('header').addClass("headerClass")
})
$("#togCss").click(function(){
    $('section').toggleClass("sectionClass")
})
$("#ancenstors").click(function(){
    console.log($("#Task5").parents())
})
$("#children").click(function(){
    console.log($("#Task6").children())
})
})