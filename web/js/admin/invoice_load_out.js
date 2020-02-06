//contains 1st ajax request
window.invoiceIDX;

(function(){ //START IIFE (Immediately Invoked Function Expression)
$(document).ready(function(){
	
 //uses ajax from js/admin/datepicker.js

    //====================
    //click on invoice in admin/views/load-out-index.php
    $(document).on("click", '.invoice-one', function() {      //for newly generated 
	
	   window.invoiceIDX = this.getAttribute("data-invoic-id"); 
	   runAjaxToGetInvoice(this);
	   
	});
   
	   
    //=================
    function runAjaxToGetInvoice(context){
		//alert(context.getAttribute("data-invoic-id"));
		var ajax_url = urlX + "/admin/invoice-load-out/ajax_get_invoice";
		//alert(ajax_url);
		$(".loader").show(80); //hide the loader
		
		// send  data  to  PHP handler  ************ 
        $.ajax({
            url: ajax_url,
            type: 'POST',
			dataType: 'JSON', // without this it returned string(that can be alerted), now it returns object
			//passing the ID of invoice load out
            data: { 
			    serveInvoiceLoadOutID: context.getAttribute("data-invoic-id")
			},
            success: function(data) {
                // do something;
				
				console.log(data);
				//getAjaxAnswer_andBuild_6_month(data, idX); //data => return from php script //idX => id of clicked room
				$(".loader").fadeOut(3000); //hide the loader
				buildAnswer(data);
				scrollResults("#invoiceSelected");
				
				
            },  //end success
			error: function (error) {
				$("#invoiceSelected").stop().fadeOut("slow",function(){ $(this).html("Failed")}).fadeIn(2000);
				scrollResults("#invoiceSelected");
				//console.log(data);
            }	
        });
		
		
	}

	
	//======================  
	//Build ajax success
    function buildAnswer(data){
		
		  //build dropdown with elevators, var elevators is set in admin/views/load-out-index.php
		  var dropdownElevators = "<select id='selElevator'><option selected value='false'>Оберіть елеватор</option>";
		  for(i = 0; i < elevators.length; i++){
			 dropdownElevators+= "<option value='" + elevators[i].e_id + "'>" + "Елеватор " + elevators[i].e_id + "</option>";
		  }
		  dropdownElevators+= "</select>";
		
		  //build datepicker calendar + var dropdownElevators
		  var calendar = '<div class="col-sm-12 col-xs-12 calendar">' +
	            '<br><i class="fa fa-calendar" style="font-size:74px"></i><br><br>' +
		        '<input type="button"  value="<<" id="prevDay" class="btn btn-info"/>' +
                ' <input type="button"  value=" Calendar" id="datepicker2" class="btn btn-danger"/>' +    
                ' <input type="button"  value=">>" id="nextDay" class="btn btn-success"/><br><br>' +
				'<p>Оберіть дату: <input type="date" id="datePickerManual"/></p>' + //datePicker calendar -> TRUE here
				'<p>Елеватор: ' + dropdownElevators + '</p>' + //elevator  
				'<p><button type="button" id="getIntListBtn" class="btn btn-primary">Ok</button></p>' //button to send ajax
	            '</div><br>';
				
		  //build selected invoice info + var calendar
		  var textX = '<div class="col-sm-12 col-xs-12"><h3><center>Запит <i class="fa fa-briefcase" style="font-size:31px"></i></center></h3> </div>' + 
		              '<div class="col-sm-12 col-xs-12  list-group-item header-color invoice-selected">' + 
		                 '<div class="col-sm-6 col-xs-6 word-breakX list-group-item"> Номер накладної</div>' + '<div class="col-sm-6 col-xs-6 word-breakX list-group-item ">' + data.invoiceLoadOut.invoice_unique_id + '</div>' +
						 '<div class="col-sm-6 col-xs-6 word-breakX list-group-item"> Користувач </div>'     + '<div class="col-sm-6 col-xs-6 word-breakX list-group-item">' + data.invoiceLoadOut.user_id + '</div>' +
						 '<div class="col-sm-6 col-xs-6 word-breakX list-group-item"> Продукт </div>'        + '<div class="col-sm-6 col-xs-6 word-breakX list-group-item">' + data.invoiceLoadOut.product_id + ' ' + data.invoiceLoadOut.product_wieght + ' кг </div>' +
						 '<div class="col-sm-6 col-xs-6 word-breakX list-group-item"> Дата </div>'           + '<div class="col-sm-6 col-xs-6 word-breakX list-group-item">' + data.invoiceLoadOut.user_date_unix + '</div>' +
					  '</div>' + 
					  calendar; 
					  
					  
		  $("#invoiceSelected").stop().fadeOut("slow",function(){ $(this).html(textX)}).fadeIn(2000);	

	}


	






	
	   
});
// end ready		
	
}()); //END IIFE (Immediately Invoked Function Expression)





   //Moved outside  IIFE to be visible in other scripts, i.e js/datepicker.js -----------------------------------------

    // Advanced Scroll the page to results  #resultFinal
	// **************************************************************************************
    // **************************************************************************************
    //                                                                                     ** 
	function scrollResults(divName, parent)  //arg(DivID, levels to go up from DivID)  //scrollResults("#roomNumber", ".parent().");
	{   //if 2nd arg is not provided while calling the function with one arg
		if (typeof(parent)==='undefined') {
		
            $('html, body').animate({
                scrollTop: $(divName).offset().top
                //scrollTop: $('.your-class').offset().top
             }, 'slow'); 
		     // END Scroll the page to results
		} else {
			//if 2nd argument is provided
			var stringX = "$(divName)" + parent + "offset().top";  //i.e constructs -> $("#divID").parent().parent().offset().top
			$('html, body').animate({
                scrollTop: eval(stringX)         //eval is must-have, crashes without it
                }, 'slow'); 
		}
	}
	
	// **                                                                                  **
    // **************************************************************************************
    // **************************************************************************************
	
	
	
	
	
	
	// **************************************************************************************
    // **************************************************************************************
    //                                                                                     ** 
	
	
	function scroll_toTop() 
	{
	    $("html, body").animate({ scrollTop: 0 }, "slow");	
	}
	// **                                                                                  **
    // **************************************************************************************
    // **************************************************************************************

