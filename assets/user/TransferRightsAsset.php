<?php

namespace app\assets\user;

use yii\web\AssetBundle;

/**
*
 */
class TransferRightsAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
    
    ];
    public $js = [
		'js/transfer_rights.js',  //transfer rights to third user (autocomplete)
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
