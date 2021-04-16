(function(){ //START IIFE (Immediately Invoked Function Expression)
$(document).ready(function(){
   
    //to make this script works only on SiteController/ViewOne
	if (typeof usersX2 === 'undefined') { 
	    //alert ('false');
		return false;
	}
	
	//array which will contain all products for autocomplete
	var arrayAutocomplete = [];
	
	//Loop through passed php object, object is echoed in JSON in Controller Product/action Shop
	for (var key in usersX2) {
		arrayAutocomplete.push(  { label: usersX2[key]['email'] + " => " +  usersX2[key]['username'], value: usersX2[key]['id'] }  ); //gets name of every user and form in this format to get and lable and value(Name & ID)

	}
	
   console.log(arrayAutocomplete);
	
    //Autocomplete itself
    $( function() {		
		
		//Autocomplete wrap hints in URL <a href>
		$("#searchProduct").autocomplete({
            minLength: 1,
            source: arrayAutocomplete, //array for autocomplete
		    select: function (event, ui) {
                //displaySelectedCategoryLabel(event, ui);
            },
        }).data("ui-autocomplete")._renderItem = function (a, b) {
            return $("<li class='clear'></li>")
            .data("item.autocomplete", b)
            .append('<a href="' + url + '/admin/view-all-users/single-user-view?user_id=' + b.value + '"> ' + b.label + '</a>  ')
            .appendTo(a);
        };
		
	 });

    //clear the Search field
    $(document).on("click", '.clear', function() { 
        $("#searchProduct").val('');   
    });  
			   
});
}()); //END IIFE (Immediately Invoked Function Expression)