//autocomplete for admin/create new invoice (InvoiceLoadIn)
//JQ autocomplete UI,(+ must include JQ_UI.js + JQ_UI.css in index.php)
$(document).ready(function(){
	
	//to make this script works only on SiteController/ViewOne
	if (typeof usersX === 'undefined') { 
	    //alert ('false');
		return false;
	}
	
	
	
	//array which will contain all products for autocomplete
	var arrayAutocomplete = [];
	
	
	//Loop through passed php object, object is echoed in JSON in Controller Product/action Shop
	for (var key in usersX) {
		arrayAutocomplete.push(  { label: usersX[key]['email'] + "  => " +  usersX[key]['company_name'], value: usersX[key]['id'] }  ); //gets name of every user and form in this format to get and lable and value(Name & ID)

	}
	

	
    //Autocomplete itself
    $( function() {	
	
	     //fix function for autocomplete (u type email in <input id="userName">, get autocomplete hints and onSelect puts email value (i.e user ID to) to hidden <input id="userID">)
	     function displaySelectedCategoryLabel(event, ui) {
            $("#userName").val(ui.item.label);
            $("#userID").val(ui.item.value); //hidden <input id="userID"> to contain user (get from autocomplete array)
            event.preventDefault();
        };
		
		
	
		//Autocomplete 
		$("#userName").autocomplete({
           minLength: 1,
           source: arrayAutocomplete, //array for autocomplete
		   
		   select: function (event, ui) {
                displaySelectedCategoryLabel(event, ui);
            },
        });
	
		
   } );
   
   
   
   


});