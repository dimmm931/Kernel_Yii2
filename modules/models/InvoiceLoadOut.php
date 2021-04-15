<?php

namespace app\modules\models;
use app\models\Balance;
use app\models\User;
use app\models\ProductName;
use app\modules\models\Messages;
use app\modules\models\InvoiceLoadIn;

use Yii;

/**
 * This is the model class for table "invoice_load_out".
 *
 * @property int $id
 * @property int $user_id
 * @property int $invoice_unique_id
 * @property int $product_id
 * @property int $product_wieght
 * @property int $user_date_unix
 * @property string $confirmed_by_admin
 * @property int $confirmed_date_unix
 * @property int $date_to_load_out
 * @property int $b_intervals
 * @property int $b_quarters
 * @property int $elevator_id
 * @property string $completed
 * @property int $completed_date_unix
 * @property int $final_balance
 */
class InvoiceLoadOut extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'invoice_load_out';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'invoice_unique_id', 'product_id', 'product_wieght', 'user_date_unix'], 'required'], // 'confirmed_date_unix', 'elevator_id', 'completed_date_unix'
            [['user_id', 'product_id', 'product_wieght', 'user_date_unix', 'confirmed_date_unix', 'date_to_load_out', 'b_intervals', 'b_quarters', 'elevator_id', 'completed_date_unix'], 'integer'], //'invoice_unique_id',
            [['confirmed_by_admin', 'completed', 'invoice_unique_id'], 'string'],
			['invoice_unique_id', 'unique', 'targetClass' => '\app\modules\models\InvoiceLoadOut', 'message' => 'This Invoice ID has already been taken.'],
			['product_wieght','validateWeight'], //my validation function validateWeight
			['product_wieght', 'compare', 'compareValue' => 1, 'operator' => '>='],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'invoice_unique_id' => Yii::t('app', 'Invoice ID'),
            'product_id' => Yii::t('app', 'Product ID'),
            'product_wieghinvoice_unique_idt' => Yii::t('app', 'Product Wieght'),
            'user_date_unix' => Yii::t('app', 'User Date Unix'),
            'confirmed_by_admin' => Yii::t('app', 'Confirmed By Admin'),
            'confirmed_date_unix' => Yii::t('app', 'Confirmed Date Unix'),
			'date_to_load_out' => Yii::t('app', 'Date To Load Out'),
            'b_intervals' => Yii::t('app', 'B Intervals'),
            'b_quarters' => Yii::t('app', 'B Quarters'),
            'elevator_id' => Yii::t('app', 'Elevator ID'),
            'completed' => Yii::t('app', 'Completed'),
            'completed_date_unix' => Yii::t('app', 'Completed Date Unix'),
        ];
    }
	
	
	/**
     * hasOne relation
     * @return \yii\db\ActiveQuery
     *
     */
	public function getUsers()
	{
        return $this->hasOne(User::className(), ['id' => 'user_id']); 
    }
	  
	/**
     * hasOne relation
     * @return \yii\db\ActiveQuery
     *
     */
	public function getProducts()
	{
        return $this->hasOne(ProductName::className(), ['pr_name_id' => 'product_id']); 
    }
	  
	/**
     * hasOne relation
     * @return \yii\db\ActiveQuery
     *
     */
	public function getTabless()
	{
        return $this->hasOne(InvoiceLoadIn::className(),['user_kontagent_id' => 'user_id']);
    }

	
	
    /**
     * my validation, checks if user is not taking more than he has
     * @return null
     *
     */
	public function validateWeight()
	{
		$b = Balance::find()->where(['balance_user_id' => Yii::$app->user->identity->id])->andWhere(['balance_productName_id' => $this->product_id]) -> one();
		if ($b->balance_amount_kg < $this->product_wieght){
			$this->addError('product_wieght','Недостатньо на Вашому балансi. Доступно лише ' . $b->balance_amount_kg . ' кг.');
		}
    }
	 
	 
	 
    /**
     * to minus -- product from user's balance
     * @return null
     *
     */
	public function deductProduct()
	{
		$b = Balance::find()->where(['balance_user_id' => Yii::$app->user->identity->id])->andWhere(['balance_productName_id' => $this->product_id]) -> one();
		 
		if($b->balance_amount_kg == $this->product_wieght){
			$b->delete();
			$newAmount = 0;
		} else {
			$newAmount = $b->balance_amount_kg - $this->product_wieght;
			$b->balance_amount_kg = $newAmount ;
            $b->save();			 
		}
		 
		//saves new balance to new column in InvoiceLoadOut (for History transactions)
		$inv = self::find()->where(['invoice_unique_id' => $this->invoice_unique_id])->one();
		$inv->final_balance = $newAmount;
		$inv->save(false);
	}
	 
    /**
     * Aditional final check if DATE/TIME is still free (if someone has not taken this time while we were booking)
     * @return boolean
     *
     */
	public function checkIfFree_date($model)
	{
		$checkIfFree_date = InvoiceLoadOut::find()
	         ->where(['elevator_id' => $model->elevator_id])
             ->andWhere(['date_to_load_out' => $model->date_to_load_out])
             ->andWhere(['b_intervals' => $model->b_intervals])	
             ->andWhere(['b_quarters' => $model->b_quarters])						   
			 ->one(); 
			 
		if($checkIfFree_date){
			return true;
		}
	}
	 
	 
	 
    /**
     * Aditional final check if someone has not edited/proceeded this invouce while we were booking)
     * @return boolean
     *
     */
	public function checkIfFreeInvoice($model)
	{
	    $checkIfFreeInvoice = InvoiceLoadOut::find()->where(['id' => $model->id ])->one(); 
		if(isset($checkIfFreeInvoice->confirmed_by_admin) && $checkIfFreeInvoice->confirmed_by_admin == '1'){
		    return true;
	    }
	}
	 
	
	 
	 
	 
    /**
     * notify the user-> send the message, when a user successfuly submitted request to LoadOut
     * @return null
     *
     */
	public function  sendMessage()
	{
		$model = new Messages();
		$model->m_sender_id = 1; //admin
		$model->m_receiver_id = Yii::$app->user->identity->id; 
		$model->m_text = "<p>Dear user <b>". $this->users->first_name . "</b></p>" .//hasOne relation (gets username by ID)
		                 "<p>Ви надiслали запит на вiдвантаження " . $this->products->pr_name_name . //hasOne relation(gets product name by ID)
						 " у кількості  " .$this->product_wieght . "кг.</p>" .   //weight
						 "<p> Номер накладної  " . $this->invoice_unique_id . ".</p>" .
						 "<p> Очікуйте на повідомлення з підтвердженням адміністратора та датою і часом</p>" .
						 "<p>Best regards, Admin team. </p>";  
		$model->m_unix = time();
		$model->save();
	}
	
	
    /**
     * notify the user-> send the message, when Admin confirmed the request
     * @return null
     *
     */
	public function  sendMessage_LoadOut_Confirmed($i, $y)
	{
		$model = new Messages();
		$model->m_sender_id = 1; //admin
		$model->m_receiver_id = $i->user_id; 
		//Yii::$app->formatter->locale = 'ru-RU';
		$model->m_text = "<p>Dear user <b>". $i->users->first_name . "</b></p>" .//hasOne relation (gets username by ID)
		                "<p>Ми отримали Ваш запит на вiдвантаження <b>" . $i->products->pr_name_name . "</b>" . //hasOne relation(gets product name by ID)
						" у кількості  <b>" .$i->product_wieght . "</b> кг.</p>" .   //weight
						"<p> Номер накладної <b> " . $i->invoice_unique_id . "</b>.</p>". 
						"<p>Вашу заявку було схвалено адміністратором. Ваша дата та час для відвантаження продукції <b>" . Yii::$app->formatter->asDate($i->date_to_load_out, 'dd-MM-yyyy H:s') . 
						" " . $i->b_intervals . "." . $i->b_quarters . "0 </b>" . // 7.00, 9.30, etc
						". Елеватор номер <b>" . $i->elevator_id . //elevator
						"</b>.</p>" .
						"<p>Best regards, Admin team. </p>";  
		$model->m_unix = time();
		$model->save();
	}
		
	
	
    /**
     * for json to return hasOne relations
     * @return 
     *
     */
	public function fields()
    {
        return [
            'user_id' => function ($model) {
                return $model->users->email; // Return related model property, correct according to your structure
            },
			'product_id' => function ($model) {
                return $model->products->pr_name_name; // Return related model property, correct according to your structure
            },
		    'invoice_unique_id',
		    'product_wieght',
		    'user_date_unix'  => function ($model) {
                return Yii::$app->formatter->format($model->user_date_unix, 'date'); 
            },
        ];
    }
		
	 
}
