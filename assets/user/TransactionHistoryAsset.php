<?php

namespace app\assets\user;

use yii\web\AssetBundle;

/**
 * 
 *
 */
class TransactionHistoryAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
    
    ];
    public $js = [
		'js/transactions.js', //transactions js	
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
