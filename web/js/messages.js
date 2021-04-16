(function(){ //START IIFE (Immediately Invoked Function Expression)
$(document).ready(function(){
	
    //on email click remove class of UNREAD message
    $(document).on("click", '.mail', function() { 
        $(this).removeClass("boldX");
	   
	    //if find this class .changeonclick
	    if ($(this).find('.changeonclick').length != 0){
	        sendAjaxToMarkAsRead(this.id); 
	    } else {}
	 
	    $(this).find('.changeonclick').addClass('fa-envelope-open-o').removeClass('fa-envelope changeonclick');; //change closed envelope to open 
    });	
	   
	  
    function sendAjaxToMarkAsRead(clickedID){
	    var urlX = url  + '/messages/ajax-update-read-status'; //url from view
		// send  data  to  PHP handler  ************ 
        $.ajax({
            url: urlX,
            type: 'POST',
			dataType: 'JSON', 
			data: { 
			    serverClickedID: clickedID
			},
			  
            success: function(data) { 
            },  //end success
			error: function (error) {
				alert('fail'); alert(JSON.stringify(error, null, 4));
            }	
        });
    } 
});
}()); //END IIFE (Immediately Invoked Function Expression)