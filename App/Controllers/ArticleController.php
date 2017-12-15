<?php


namespace App\Controllers;

class ArticleController
{

	public function index($id = null)
	{
		echo "<h1>Article</h1>";
		echo "<p>$id</p>";
	}

}