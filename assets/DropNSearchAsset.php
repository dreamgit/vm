<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class DropNSearchAsset extends AssetBundle
{
	
	public $basePath = '@webroot';
	public $baseUrl = '@web';
	public $css = [
		'https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.default.css',
	];
	public $js = [
		'https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.js',
	];
	public $depends = [
		'yii\web\YiiAsset',
		'yii\bootstrap\BootstrapAsset',
	];
}
