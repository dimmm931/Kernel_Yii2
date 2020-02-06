<?php

namespace app\modules;

/**
 * admin module definition class
 */
class admin extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        //layout for admin
        $this->layout = 'main-admin';

        // custom initialization code goes here
    }
}
