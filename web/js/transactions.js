(function(){ //START IIFE (Immediately Invoked Function Expression)
$(document).ready(function(){
   
     //on change in dropdown list, onchange redirects to the same page but with diffrent $_GET['category'] 
	// **************************************************************************************
    // **************************************************************************************
    //                                                                                     ** 
	if(document.getElementById("dropdownnn") !== null){ 
	    document.getElementById("dropdownnn").onchange = function() {
        //if (this.selectedIndex!==0) {
              window.location.href = this.value;
        //}        
        };
	}
	// **                                                                                  **
    // **************************************************************************************
    // **************************************************************************************
	   
});
}()); //END IIFE (Immediately Invoked Function Expression)