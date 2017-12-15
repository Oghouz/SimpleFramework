<?php

namespace Core;

defined('CORE_PATH') or define('CORE_PATH', __DIR__);


/**
 *  Framework core
 */
class Core
{

	//config
	protected $config = [];

	public function __construct($config)
	{
		$this->config = $config;
	}


	public function run()
	{
		spl_autoload_register([$this, 'loadClass']);
		$this->allowedCors();
		$this->setReporting();
		$this->setDbConfig();
		$this->route();

	}

	// Route
	public function route()
	{
		$controllerName =ucfirst($this->config['defaultController']);
		$actionName = $this->config['defaultAction'];
		$param = [];

		$url = $_SERVER['REQUEST_URI'];

		$position = strpos($url, '?');

		$url = $position === false ? $url : substr($url, 0, $position);

		$url = trim($url, '/');

		// TODO remove
        $urlArray = explode('/', $url);
        array_shift($urlArray); // remove projet repetoire
        array_shift($urlArray); // remove projet repetoire


		if ($urlArray) {
			
			//$urlArray = explode('/', $url);

			$urlArray = array_filter($urlArray);

			$controllerName = ucfirst($urlArray[0]);

			array_shift($urlArray);
			$actionName = $urlArray ? $urlArray[0] : $actionName;

			array_shift($urlArray);
			$param = $urlArray ? $urlArray : [];
		}

		$controller = 'app\\controllers\\' . $controllerName . 'Controller';

		if (!class_exists($controller)) {
			exit($controller . ' not found');
		}
		if (!method_exists($controller, $actionName)) {
			exit($actionName . " not found");
		}

		$dispatch = new $controller($controllerName, $actionName);

		call_user_func_array([$dispatch, $actionName], $param);
		
	}

	// Error reporting
	public function setReporting()
	{
		if (APP_DEBUG === true) {
			error_reporting(E_ALL);
			ini_set('display_errors', 'On');
		} else {
			error_reporting('E_ALL');
			ini_set('display_errors', 'Off');
			ini_set('log_errors', 'On');
		}
	}

	// defined DB config
	public function setDbConfig()
	{
		if ($this->config['db']) {
			define('DB_HOST', $this->config['db']['host']);
			define('DB_NAME', $this->config['db']['dbname']);
			define('DB_USER', $this->config['db']['username']);
			define('DB_PASS', $this->config['db']['password']);
		}
	}

    public function allowedCors()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET');
        header("Access-Control-Allow-Headers: X-Requested-With");
    }

	public function loadClass($className)
	{
		$classMap = $this->classMap();

		if (isset($classMap[$className])) {
			
			$file = $classMap[$className];
		} elseif (strpos($className, '\\') !== false) {
			$file = APP_PATH . '/../' . str_replace('\\', '/', $className) . '.php';

			if (!is_file($file)) {
				return;
			}
		} else {
			return;
		}

		var_dump($file);

		include $file;

	}

	protected function classMap()
	{
		return [
			'Core\Base\Controller' => CORE_PATH . '/base/Controller.php',
			'Core\Base\Model' => CORE_PATH . '/base/Model.php',
			'Core\Base\View' => CORE_PATH . '/base/View.php',
			'Core\DB\DB' => CORE_PATH . '/db/DB.php',
			'Core\DB\Sql' => CORE_PATH . '/db/Sql.php',
		];
	}






}