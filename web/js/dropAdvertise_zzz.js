$(document).ready(function(){
	
	
	//drop zzz.com.ua Adss
	// **************************************************************************************
    // **************************************************************************************
    //                                                                                     ** 
	
	//drop div with money donut
	$('div:contains("Ця сторінка розміщена безкоштовно ")').css('display', 'none');  //css('background-color', 'red')   //drop russ version
	$('div:contains("is hosted for free by zzz.com.ua, if you are owner of this page")').css('display', 'none');  //drop engl version
	$('div:contains("Эта страница размещена бесплатно на")').css('display', 'none');  //drop ru version
	//$('div:contains("Join WEB Revolution")').css('background-color', 'red'); 
	
	//droping Mint.me banner
	setTimeout(function(){ 
	    $('div').each(function() {
            if ($(this).find('img').length) { //https://a5.cba.pl/mintme.png
		        var a_href = $(this).find('div a').attr('href');
			    //alert(a_href);  //show  https://www.mintme.com/
			 
		        if( a_href == "https://www.mintme.com/"){  //https://www.mintme.com/   https://a5.cba.pl/mintme.png
				    //alert("f y");
				    $(this).find('div').css('display', 'none');
			    }
		     
                // there is an image in this div, do something...
            }
        });
    }, 2000);
	// **                                                                                  **
    // **************************************************************************************
    // **************************************************************************************

});
// end ready	
	