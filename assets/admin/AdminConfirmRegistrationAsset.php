<?php
/**
 * 
 */

namespace app\assets\admin;

use yii\web\AssetBundle;

/**
 * 
 */
class AdminConfirmRegistrationAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
    ];
	
    public $js = [
        'js/admin/admin_js.js',
    ];
	
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
