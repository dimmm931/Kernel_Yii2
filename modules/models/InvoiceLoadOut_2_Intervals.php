<?php

namespace app\modules\models;
use app\models\Balance;
use app\models\User;
use app\models\ProductName;
use app\modules\models\Messages;
use app\modules\models\InvoiceLoadOut;
use Yii;

/**
 * This is the model class to build free/taken Intervals. Data for intervals is from table "invoice_load_out".
 */

class InvoiceLoadOut_2_Intervals extends InvoiceLoadOut
{
    
    /** 
     * Builds reserved dates, used in foreach
     * @param int $iterator (==$i, calculated in for(){} loop)
     * @param int $nextIterator (hour+1)==$t==$i+1 (for those who has duplicate), if does not use NULL
     * @param int $indexOf (==position) 
     * @param array of objects $result (==Act record array result from Controller)
     * @param string $minutesStart (=='30' OR '00')  
     * @param string $minutesEnd (== '30' OR '00')
     * @return string $text
     * DisplayReserved($i, null, $indexOf, $result, '00', '30');
     * DisplayReserved($i, $t, $indexOf+1, $result, '30', '00');
     */
    public function DisplayReserved($iterator, $nextIterator, $indexOf, $result, $minutesStart, $minutesEnd)
	{ 
	    global $text;
 
        //if $nextIterator/$t called as Null (we DON"T need $nextIterator/$t   for 1st Row calling(i.e 9.00-9.30)), we Do NEED it for the second row(9.30-10.00)
        if (is_null($nextIterator) ) {
		    $nextIterator = $iterator;
	    } else {
		    $nextIterator = $nextIterator;
	    }
	    $idX = $result[$indexOf]->id;
        $text = $text . 
               "<div class='col-sm-2 col-xs-3 taken shadowX'> Taken " . 
                   $iterator.  "."   .$minutesStart.  "-" .$nextIterator. "."   .$minutesEnd.   
                "</div>";
   
   }




   /** 
    * Builds free dates. Function which forms free cells and <a href> with data to book it, used in foreach
    * @param int $iterator (==$i, calculated in for(){} loop)
    * @param int $nextIterator
    * @param string $minutesStart (=='30' OR '00')  
    * @param string $minutesEnd (== '30' OR '00')
    * @return string $text
    */                                                                       
    public function DisplayFree($iterator, $nextIterator, $minutesStart, $minutesEnd)
	{ 
	    global $text;
        if (is_null($nextIterator)){
	        $nextIterator = $iterator;
        } else {
	        $nextIterator = $nextIterator;
        }
 
        $hour = $iterator; // used for <a href> link
        //$dateNorm = $GLOBALS['timeX'];// we get $timeX from Controller render; This is {9-Feb-Fri-2018}, we add this to id, to make possible to redict to the same date after insert
        //findin quarters (0||3)
        if ($minutesStart == "00") {
            $quarter = 0;
        } else {
            $quarter = 3;
        }
 
        $text = $text .
                "<div class='col-sm-2 col-xs-3 free shadowX' data-inter='" .
                    $iterator . "' data-quarter='" . $quarter . "' > Free =>  ".$iterator.  "."   .$minutesStart . "-" . $nextIterator . "." . $minutesEnd . 
                "</div>";
    }
    
    
    /**
     * @inheritdoc
     */
	public function test()
	{
		echo "" . parent::tableName();
	}
		 
}
