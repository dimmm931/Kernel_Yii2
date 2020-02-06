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
class AdminFrontPageAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
    ];
    public $js = [
	    'js/admin/ajax_count_reg_request.js',     //count registration requests (badge) in main admin panel
		'js/admin/ajax_count_load_out_request.js',//count load-out requests (badge) in main admin panel
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
