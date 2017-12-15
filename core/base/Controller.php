<?php

namespace Core\Base;

class Contorller
{

	protected $_controller;
	protected $_action;
	protected $_view;

	public function __construct($controller, $action)
	{
		$this->_controller = $controller;
		$this->_action = $action;
		$this->_view = new View($controller, $action);
	}

	public function assgin($name, $value)
	{
		$this>_view->assign($name, $value);
	}

	public function render()
	{
		$this->_view->render();
	}

}