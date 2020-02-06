<?php
/**
 * 
 */

namespace app\assets\admin;

use yii\web\AssetBundle;

/**
 * 
 */
class AdminLoadOutAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
    ];
	
    public $js = [
        'js/admin/invoice_load_out.js', //ajax to loadOut
		'js/admin/datepicker_actions.js', //my datepicker ajax	
    ];
	
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
