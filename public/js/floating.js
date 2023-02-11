$(document).ready(function () {

    $("#collegeBtn").hide();
    $("#shsBtn").hide();
    $("#elemJhsBtn").hide();
  $("#messageInquire").on("click",function(){
    $("#collegeBtn").show();
    $("#shsBtn").show();
    $("#elemJhsBtn").show();
  });

  $("#body-con").on("mouseleave",function(){
    $("#collegeBtn").hide();
    $("#shsBtn").hide();
    $("#elemJhsBtn").hide();
  })
});