<?php

namespace App\Controllers;

use App\Model\ArticleModel;
use Core\Base\Controller;

class ArticleController extends Controller
{

	public function index()
	{
		$articles = (new ArticleModel())->all();
		var_dump($articles);
	}

}