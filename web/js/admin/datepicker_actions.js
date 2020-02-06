//contains 2nd of two ajax requests
(function(){ //START IIFE (Immediately Invoked Function Expression)
$(document).ready(function(){
	
	//on clicking the OK button after the datepicker
	$(document).on('click', '#getIntListBtn',  function() {
		var date = $("#datePickerManual").val(); 
		if(check_user_date_input()){ 
            //alert(date);   
            sendAjaxToGetIntervalsView();	
		}		
    });
	
	
	//click on Free Interval
	$(document).on('click', '.free',  function() {
		//swal("!", "Дата вільна!", "success"); //sweet alert
		$(this).siblings().removeClass("clicked-interv"); //removed clicked CSS
        $(this).addClass("clicked-interv");
		
		//show selected date, hour and time 
		var monthNames = ["", "Січня", "Лютого", "Березня", "Квітня", "Травня", "Липня", "Червня", "Серпня", "Вересня", "Жовтня", "Листопада", "Грудня"];
		var selectedDate = $("#datePickerManual").val().split("-")[2] + " " + monthNames[parseInt($("#datePickerManual").val().split("-")[1])];
		var textSel = "<p class='border'>Ви обрали " + selectedDate + ". Час  " + this.getAttribute('data-inter') + "." + this.getAttribute("data-quarter") + "0</p><p><i class='fa fa-calendar-check-o' style='font-size:34px'></i></p>";
		$("#selDate").stop().fadeOut("slow",function(){ $(this).html( textSel )}).fadeIn(2000);
		
	    //assign clicke value to formFinish
		$("#invoiceID").val(parseInt(window.invoiceIDX)); //selected invoice ID
		$("#dateToLoad").val(new Date($("#datePickerManual").val()).getTime()/1000 );  //selected date in Unix
		$("#intervalHour").val( this.getAttribute("data-inter"));
		$("#quarterMinute").val( this.getAttribute("data-quarter"));
		$("#elevator").val( $('#selElevator').val() );  
		
		$("#formFinish").show(800);
		scrollResults(".pull-right"); //#formFinish
		
    });
   
   
   
   
   //click on Taken Interval
	$(document).on('click', '.taken',  function() {
	   swal("!", "Дата зайнята!", "error"); //sweet alert		
    });
   
   
   
	
	//sends ajax to InvoiceLoadOutController to get built list with free/taken intervals
	function sendAjaxToGetIntervalsView(){
	
		
		var unixSelected = new Date($("#datePickerManual").val()).getTime()/1000; //selected date in Unix, must have /1000
		
		var ajax_url = urlX + "/admin/invoice-load-out/ajax_get_interval_list";
		//alert(ajax_url);
		$(".loader").show(80); //hide the loader
		
		// send  data  to  PHP handler  ************ 
        $.ajax({
            url: ajax_url,
            type: 'POST',
			dataType: 'text', // without this it returned string(that can be alerted), now it returns object
			//passing Unix time of selected date and selected Elevator
            data: { 
			    serverSelectedDateUnix: unixSelected,
				serverSelectedElevator: $('#selElevator').val()
				
			},
            success: function(data) {
                // do something;
				console.log(data);
				//getAjaxAnswer_andBuild_6_month(data, idX); //data => return from php script //idX => id of clicked room
				$(".loader").fadeOut(2000); //hide the loader
				//buildAnswer(data);
				$("#intervalList").stop().fadeOut("slow",function(){ $(this).html(data)}).fadeIn(2000);
				scrollResults("#intervalList");
				
				
            },  //end success
			error: function (error) {
				$("#intervalList").stop().fadeOut("slow",function(){ $(this).html("Failed" + JSON.stringify(error, null, 4))}).fadeIn(2000);
				scrollResults("#intervalList");
				//console.log(data);
            }	
        });
	}
	
	
	
	
	
	
	
	
	
	
	
	//on click runs validation of a user's date
	// **************************************************************************************
    // **************************************************************************************
    //                                                                                     ** 
	function check_user_date_input() {
        //checks if not empty date input
		if ($("#datePickerManual").val() == ""){
			swal("Помилка!", "Ви не обрали дату!", "error"); //sweet alert
			return false;
		}
		

		//check if not OLD date is selected
		if ( new Date($("#datePickerManual").val() + " 23:59:59").getTime() < new Date().getTime()){  //if UnixTime of datepicker < NOW TimeStamp in Unix mlsec
			swal("Помилка!", "Ви обрали минулу дату! Оберіть нову дату ", "error"); //sweet alert
			return false;
		}
		
		//check if not Sunday
		 var d = new Date($("#datePickerManual").val());
         var n = d.getDay();
		 if(n == 0){
		    swal("Помилка!", "Ви обрали неділю. Неділя вихідний ", "error"); //sweet alert
			return false;
		}
		
		//checks if not empty elevator input
		if ($('#selElevator').val() == "false"){
			swal("Помилка!", "Елеватор не обрано!", "error"); //sweet alert
			return false;
		}
		
		
	    return true;
	}
	
// **                                                                                  **
// **************************************************************************************
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	//NOR WORKING!!!!!!!!!!!!!!!
	
	//======================================================
	//JQ UI -> does not work
    $("#datepicker").datepicker({
                changeMonth: true,
                changeYear: true,
                yearRange: '1800:2100'
    });
	
	
	
	
 /*

//Start PickDate cal-----------------------------------------------------------------------------------------------------------------------------------
var selectedDate = "";
	
 $('#calendarPick').datepicker( {
    onSelect: function(date) {
       alert(date);
	   selectedDate = date; // datePicker returns date in format ->  14.10.2017
	  // alert(selectedDate);
    dateArray=selectedDate.split('.');// set to array 
//inj
//var Monthh = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];//dublicate
                               //adding void zero element as picker returns month number from 1 to 12, not 0-11
//week-0>below is dublicate

//inj
//alert(dateArray[1] );
//creates a new Date obj with date-> get Mon,Tues
 // we -1 because  month returned by DatePicker are from 1-12, not 0-11 as in arrat Monthh
 var monthAdopted=dateArray[1]-1; //alert(monthAdopted); // we use dateArray[1]-1 because month value range (1-12) and my Month array range (0-11)
 var oldDate=dateArray[2]+ "," + dateArray[1]  + "," +dateArray[0];  // Y-M-D   //  the wrong Week days' Error was here-> by using adopted month {var monthAdopted} u calling not actual date, but with -1 monyth; thus u create object for prev month not current;
 // use dateArray[1] instead monthAdopted to fix wrong week days;
 //alert(oldDate);
 var date = new Date(oldDate);// Y-M-D
 var r = weekdays[date.getDay()]; //get Mon,Tues
 //alert("->"+ date.getDay());// alerts nmumeric
    //final assigning
    selectedDateX=dateArray[0]+  '-'    +  Monthh[monthAdopted] + "-"+ r +  "-" + dateArray[2]  ; // date-month(Oct,Nov)-weekDay-Year
	$("#myDateInputDayBook").val(selectedDateX); //sets the date to input
	$("#calendarPick").val("Calendar"); //rename the buttion to calendar agian
		
		
		
//Do JS Redirect with $_GET['myUnix']=selected date
	  var currentURL = window.location.href.split('?')[0]; //get the URL address without any $_GET['parmas']
	  finalURL=currentURL+ "?r=day-book&myUnix=" + selectedDateX;
	  window.location = finalURL;
	
		
		
		
		
  

	
  },// end onSelect action!!!!!!!!!!!!!!!!
  }); //end DatePicker click
//End PickDate cal---------------------------
	   
*/


	
});
// end ready	
	
	
}()); //END IIFE (Immediately Invoked Function Expression)