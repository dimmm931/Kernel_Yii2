<?php

namespace app\models;
use app\models\Balance;
use app\modules\models\Messages;
use Yii;

/**
 * This is the model class for table "transfer_rights".
 *
 * @property int $id
 * @property int $product_id
 * @property string $invoice_id
 * @property int $from_user_id
 * @property int $to_user_id
 * @property int $unix_time
 * @property string $date
 * @property int product_weight
 * @property int $final_balance_sender
 * @property int $final_balance_receiver
 */
class TransferRights extends \yii\db\ActiveRecord
{
	
	public $user2; //autocomplete field
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'transfer_rights';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'user2',  'product_id', 'invoice_id', 'from_user_id', 'to_user_id', 'unix_time', 'product_weight'], 'required'],
            [['product_id', 'from_user_id', 'to_user_id', 'unix_time'], 'integer'],
            [['date'], 'safe'],
            [['invoice_id'], 'string', 'max' => 77],
			['product_weight','validateWeight'], //my validation function validateWeight
			['to_user_id','validateNotSelfId'], //my validation function if user selects not himself
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'product_id' => Yii::t('app', 'Прoдукт'),
            'invoice_id' => Yii::t('app', 'Invoice ID'),
            'from_user_id' => Yii::t('app', 'From User ID'),
            'to_user_id' => Yii::t('app', 'To User ID'),
            'unix_time' => Yii::t('app', 'Unix Time'),
            'date' => Yii::t('app', 'Date'),
			'user2' => Yii::t('app', 'Переоформити на '),
        ];
    }
	
	
	  //hasOne relation
	  public function getProducts()
	  {
          return $this->hasOne(ProductName::className(), ['pr_name_id' => 'product_id']); 
      }
	  
	  
	  //hasOne relation -> gets User2 (receiver))username by ID)
	  public function getUsers()
	  {
          return $this->hasOne(User::className(), ['id' => 'to_user_id']); 
      }
	  
	   //hasOne relation2-> gets this User(sender))username by ID)
	  public function getUsers2()
	  {
          return $this->hasOne(User::className(), ['id' => 'from_user_id']); 
      }
	
	//my validation, checks if user is not taking more than he has
	 public function validateWeight()
	 {
		  $b = Balance::find()->where(['balance_user_id' => Yii::$app->user->identity->id])->andWhere(['balance_productName_id' => $this->product_id]) -> one();
		  if ($b->balance_amount_kg < $this->product_weight){
			  $this->user2 = '';
			  $this->addError('product_weight','Недостатньо на Вашому балансi. Доступно лише ' . $b->balance_amount_kg . ' кг.');
		  }
     }
	 
	 //my validation, checks if user selects not himself to transfer product rights
	 public function  validateNotSelfId()
	 {
		  if ($this->to_user_id == Yii::$app->user->identity->id){
			  $this->addError('user2','Ви не можете обрати сам себе');
		  }
     }
	 
	 
	  //Check User balance (if user has relvant product balance in DB Balance, i.e product !=0)
	  public function checkBalance($id)
	  {
		  $userBalance = Balance::find()->where(['balance_user_id' => $id])->andWhere(['balance_productName_id' => $this->product_id])->one();
		  return $userBalance;	  
	  }
	  
	  
	 //update Reciever column
	 public function updateColumnHistoryReciever($numb)
	 {
		 //saves new Recievers's balance to new column in TransferRights (for History transactions)
		 $inv = self::find()->where(['invoice_id' => $this->invoice_id])->one();
		 $inv->final_balance_receiver = (int)$numb;
		 $inv->save(false);
	 }
	 
	  
	  //
	  //adds and updates with new weight	 
	  public function balanceAdd($user2)
	  {
		$prev = $user2->balance_amount_kg;
		$new = $prev + $this->product_weight;
		$user2->balance_amount_kg = $new;
		$user2->balance_last_edit = date('Y-m-d H:i:s'); //update time
		$user2->save();
		
		$this->updateColumnHistoryReciever($new);
	}		

	//saves new row with product and weigth	  
	public function addNewProduct($user2)
	{
		$m = new Balance();
		$m->balance_productName_id = $this->product_id; //product id
		$m->balance_user_id = $this->to_user_id; //user id 
		$m->balance_amount_kg = $this->product_weight; //product weight
		$m->save();
		
		$this->updateColumnHistoryReciever($this->product_weight);
	}
	 
	 
	 //saves final balance to db TransferRight
	 public function updateColumnHistorySender($numb)
	 {
		 //saves new Sender's balance to new column in TransferRights (for History transactions)
		 $inv = self::find()->where(['invoice_id' => $this->invoice_id])->one();
		 $inv->final_balance_sender = (int)$numb;
		 $inv->save(false);
	 }
	 
	
	// to minus -- product from user's balance 
	 public function deductProduct($user1)
	 {
		 //$b = Balance::find()->where(['balance_user_id' => Yii::$app->user->identity->id])->andWhere(['balance_productName_id' => $this->product_id]) -> one();
		 
		 if($user1->balance_amount_kg == $this->product_weight){
			 $user1->delete();
			 $newAmount = 0;
		 } else {
			 $newAmount = $user1->balance_amount_kg - $this->product_weight;
			 $user1->balance_amount_kg = $newAmount ;
             $user1->save();			 
		 }
		 $this->updateColumnHistorySender($newAmount);
	 }
	 
	 
	 
	 
	 
	 
	 
	 
	//notify the user-> send the message to current user(sender)
	public function  sendMessageUser1()
	{
		$model = new Messages();
		$model->m_sender_id = 2; // Yii::$app->user->identity->id;
		$model->m_receiver_id = Yii::$app->user->identity->id;;
		$model->m_text = "<p> Шановний <b>". $this->users2->first_name . "</b></p>" . //hasOne relation (gets this User(sender))username by ID)
		                "<p>Ви переоформили  на користувача " . $this->users->first_name . //hasOne relation (gets User2(reciever) username by ID)
						" " . $this->products->pr_name_name . //hasOne relation(gets product name by ID)
						" " . $this->product_weight . "кг.</p>" .   //weight
						"<p> Номер накладної " . $this->invoice_id . ".</p>" .
						"<p>Best regards, Admin team. </p>";  
		$model->m_unix = time();
		$model->save();
	}
	
	//notify the user-> send the message to User who obtained new product(reciever)
	public function  sendMessageUser2()
	{
		$model = new Messages();
		$model->m_sender_id = 2; // Yii::$app->user->identity->id;
		$model->m_receiver_id = $this->to_user_id;
		$model->m_text = "<p>Шановний <b>". $this->users->first_name . "</b></p>" .//hasOne relation (gets User2(reciever) username by ID)  
		                "<p>Користувач <b>" . $this->users2->first_name  . "</b>" .//hasOne relation (gets User(sender)username by ID)
						" переоформив на Вас " . $this->products->pr_name_name . //hasOne relation(gets product name by ID)
						" " . $this->product_weight . "кг.</p>" .   //weight
						"<p> Номер накладної  " . $this->invoice_id . ".</p>" .
						"<p>Best regards, Admin team. </p>";  
		$model->m_unix = time();
		$model->save();
	}
	  //
	  
	
	 
}
