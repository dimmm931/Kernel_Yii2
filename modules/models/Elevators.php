<?php

namespace app\modules\models;

use Yii;

/**
 * This is the model class for table "elevators".
 *
 * @property int $e_id
 * @property string $e_elevator
 * @property string $e_discription
 * @property string $e_operated_by
 */
class Elevators extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'elevators';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['e_elevator', 'e_discription', 'e_operated_by'], 'required'],
            [['e_discription'], 'string'],
            [['e_elevator', 'e_operated_by'], 'string', 'max' => 77],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'e_id' => Yii::t('app', 'E ID'),
            'e_elevator' => Yii::t('app', 'E Elevator'),
            'e_discription' => Yii::t('app', 'E Discription'),
            'e_operated_by' => Yii::t('app', 'E Operated By'),
        ];
    }
}
