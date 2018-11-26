<?php

namespace app\controllers;

use yii\web\Controller;

/**
 * Class IndexController
 *
 * @package app\controllers
 */
class IndexController extends Controller
{
	
	/**
	 * Displays homepage.
	 *
	 * @return string
	 */
	public function actionIndex()
	{
		return $this->render('index');
	}
	
}
