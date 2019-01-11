$(document).ready(function(){
    $(window).scroll(function(){
        var scroll = $(window).scrollTop();
        if (scroll > 80) {
          $("#header").css("background" , "white");
          $("#header").css("box-shadow", "0px 0px 10px 0px rgba(0,0,0,0.6)");
        }
  
        else{
            $("#header").css("background" , "transparent");  
            $("#header").css("box-shadow", "0px 0px 0px 0px");	
        }
    })
  })