<?php

namespace app\modules\models;
use app\models\User;
use Yii;

/**
 * This is the model class for table "messages".
 *
 * @property int $m_id
 * @property string $m_time
 * @property int $m_unix
 * @property int $m_sender_id
 * @property int $m_receiver_id
 * @property string $m_text
 * @property string $m_status_read
 */
class Messages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'messages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['m_time'], 'safe'],
            [['m_unix', 'm_sender_id', 'm_receiver_id', 'm_text'], 'required'],
            [['m_unix', 'm_sender_id', 'm_receiver_id'], 'integer'],
            [['m_text', 'm_status_read'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'm_id' => Yii::t('app', 'M ID'),
            'm_time' => Yii::t('app', 'M Time'),
            'm_unix' => Yii::t('app', 'M Unix'),
            'm_sender_id' => Yii::t('app', 'M Sender ID'),
            'm_receiver_id' => Yii::t('app', 'M Receiver ID'),
            'm_text' => Yii::t('app', 'M Text'),
            'm_status_read' => Yii::t('app', 'M Status Read'),
        ];
    }
	
	
	
	 //hasOne relation
	  public function getUsers()
	  {
          return $this->hasOne(User::className(), ['id' => 'm_sender_id']); 
      }
	  
	  
	  //method to crop extra text
	  public function crop($text, $tLenght=33)
	  {
	      $length = $tLenght; //? $tLenght : 15; 
	      $text1 = $text; 
	      if(strlen($text1) > $length){
		      $text1 = substr($text1, 0, $length) . "...";
		  } 
	      return $text1;
     }
	  
}
