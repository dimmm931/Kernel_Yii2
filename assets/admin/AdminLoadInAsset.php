<?php
/**
 * asset for main Admin Panel page only, contains Js for ajax request to count users' registration requests
 */

namespace app\assets\admin;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * 
 */
class AdminLoadInAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
	    '//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css', //autocomplete CSS
    ];
	
    public $js = [
	    'https://code.jquery.com/ui/1.12.1/jquery-ui.js', //autocomplete JS
	    'js/admin/autocomplete.js', //autocomplete JS  
    ];
	
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
