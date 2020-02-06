//used in /admin/admin-x/users-registration-requests
(function(){ //START IIFE (Immediately Invoked Function Expression)
$(document).ready(function(){
	
   //add class to clicked
   $(document).on("click", '.btnX', function() { 
       $(this).parent().parent().siblings().removeClass("clicked-x");
       $(this).parent().parent().addClass("clicked-x");
   });
   
   
	   
	   
	   
});
// end ready	
	
	
}()); //END IIFE (Immediately Invoked Function Expression)