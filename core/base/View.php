<?php

namespace Core\Base;

class View
{
	protected $variables;
	protected $_controller;
	protected $_action;

	public function __construct($controller, $action)
	{
		$this->_controller = $controller;
		$this->_action = $action;
	}

	public function assign($name, $value)
	{
		$this->variables[$name] = $value;
	}

	public function render()
	{
		extract($this->variables);
		$defaultHeader = APP_PATH . 'app/views/header.php';
		$defaultFooter = APP_PATH . 'app/views/footer.php';

		$controllerHeader = APP_PATH . 'app/views/' . $this->_controller . '/header.php';
		$controllerFooter = APP_PATH . 'app/views/' . $this->_controller . '/footer.php';
		$controllerLayout = APP_PATH . 'app/views/' . $this->_controller . '/' . $this->_action . '.php';

		if (is_file($controllerHeader)) {
			include ($controllerHeader);
		} else {
			include ($defaultHeader);
		}

		if (is_file($controllerLayout)) {
			include ($controllerLayout);
		} else {
			echo "<p>Layout file not found!</p>";
		}

		if (is_file($controllerFooter)) {
			include ($controllerFooter);
		} else {
			include ($defaultFooter);
		}
 	}
}