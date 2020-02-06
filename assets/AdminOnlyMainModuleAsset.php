<?php
/**
 * 
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 */
class AdminOnlyMainModuleAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
	   'css/admin/admin-css.css', //move to admin asset
	   'https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css', //Sweet Alert CSS
	   'css/datepicker_ui/datepicker.min.css', //datepicker UI Lib CSS
	   '//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css',	   
    ];
	
    public $js = [
		'https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js', //Sweet Alert JS	
    ];
	
    public $depends = [
        'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
    ];
}
