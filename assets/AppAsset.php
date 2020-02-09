<?php


namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
		'css/myCss.css',
		'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css', //awesome fonts
		'//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css', //autocomplete CSS
    ];
	
    public $js = [
	    'js/loader.js',
		'https://code.jquery.com/ui/1.12.1/jquery-ui.js', //autocomplete JS
		'js/dropAdvertise_zzz.js', //drop hosting ads
		
    ];
	
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
