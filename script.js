$('body').on('click','.team',function(){
	
     var find = $(this).find("span").text();
     var info = find.split(",")
     var game = info[0]
     var team = info[1]
     
  /***************************************/
     
     
     var Match = $(this).parents(".GAME"); 
      var one = Match.find(".team").eq(0)
      var two = Match.find(".team").eq(1)
     
     
      if(one.hasClass("unpicked") && two.hasClass("unpicked"))
      {
      	$(this).addClass("picked")
	$(this).removeClass("unpicked")
     }
     
     else {
     		if($(this).hasClass("unpicked"))
    		 {
     			 var Match = $(this).parents(".GAME"); 
    			 Match.find(".team").toggleClass("unpicked");
     		 }
     }

 
     
     PickGame(team)
}); 






function PickGame(teamPicked) {
   var weekSelected = document.getElementById("week_Selector").value;
   var Username = document.getElementById("username").innerHTML;
   var xhttp;
  if (window.XMLHttpRequest) {
    xhttp = new XMLHttpRequest();
    } else {
    xhttp = new ActiveXObject("Microsoft.XMLHTTP");
  }
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("Picked").innerHTML = this.responseText;
       setTimeout(function(){ loadGames(); }, 1000);
    }
  };				
  xhttp.open("POST", "Php_Scripts/pickGame.php?week=" + weekSelected + "&team=" + teamPicked + "&user=" + Username, true);
  xhttp.send();
  
    
}
