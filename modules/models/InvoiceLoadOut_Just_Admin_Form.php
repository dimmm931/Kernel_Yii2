<?php

namespace app\modules\models;

use Yii;
use yii\base\Model;

/**
 * This is just model for form the admin has to finish. 
 * Admin adds  $confirmed_by_admin, $confirmed_date_unix, $date_to_load_out, $b_intervals, $b_quarters 
 * Not connected with DB".
 *
 *
 */
 
class InvoiceLoadOut_Just_Admin_Form extends Model
{
	public $id;
    public $confirmed_date_unix;
    public $date_to_load_out;
    public $b_intervals;
    public $b_quarters;
	public $elevator_id;
	
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'confirmed_date_unix', 'date_to_load_out', 'b_intervals', 'b_quarters', 'elevator_id' ], 'required'], 
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'confirmed_date_unix' => Yii::t('app', 'Схвалено адміністратором'),

        ];
    }
	
	
	  
}
