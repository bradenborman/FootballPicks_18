jQuery(document).ready(function($) {
  $(document).ready(function() {
    $('.lab-slide-up').find('a').attr('data-toggle', 'modal');
    $('.lab-slide-up').find('a').attr('data-target', '#lab-slide-bottom-popup');
  });
});



function searchForFamily(x) {
	y = x.toUpperCase();
	if(y == "BORMAN" || y == "ENGLISH" || y == "CUNNINGHAM")
		document.getElementById("group_Selector").value = 2

}