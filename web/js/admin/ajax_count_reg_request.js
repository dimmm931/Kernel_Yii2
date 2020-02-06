(function(){ //START IIFE (Immediately Invoked Function Expression)
$(document).ready(function(){
	
   
   countUserRegisterRequests();
   myVar = setInterval(countUserRegisterRequests, 1000*60*10 ); //repeat every 10 min
   
   
   //send ajax request to admin/admin-x/count-register-requests to count requests and displays to badge
   // **************************************************************************************
   // **************************************************************************************
   //                                                                                     ** 
	function countUserRegisterRequests(){ 
		
		   var urlX = url + '/admin/admin-x/count-register-requests'; //url from view/admin-panel
		
		   // send  data  to  PHP handler  ************ 
           $.ajax({
              url: urlX,
              type: 'POST',
			  dataType: 'JSON', 
              success: function(data) {
				  displayBadgeValue(data);
              },  //end success
			  error: function (error) {
				  alert('fail');
				  //$(".all-6-month").stop().fadeOut("slow",function(){ $(this).html("Failed")}).fadeIn(2000);
              }	
          });
                                       
	}
	// **                                                                                  **
    // **************************************************************************************
    // **************************************************************************************
	
	
	//html the count badge
   // **************************************************************************************
   // **************************************************************************************
   //                                                                                     ** 
	function displayBadgeValue(data)
	{
		 if(data.count > 0){
			 if(!$('.bb:eq(0)').hasClass('badge1')) {
				 $('.bb:eq(0)').addClass('badge1');
			 }

			 $('.bb:eq(0)').attr('data-badge', data.count); //$('.badge1:eq(0)').stop().fadeOut("slow",function(){ $(this).attr('data-badge', data.count) }).fadeIn(2000);   
		 } else {
		     $('.bb:eq(0)').removeClass('badge1');
		 }
		
	}
	   
	   
	   
	   
});
// end ready	
	
	
}()); //END IIFE (Immediately Invoked Function Expression)