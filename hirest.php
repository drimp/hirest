<?php
/**
 * Autoload requested classes
 * @param $class_name
 */
function __autoload($c) {
    if(!defined('APP_PATH')){
        define( 'APP_PATH', dirname(__FILE__).DIRECTORY_SEPARATOR) ;
    }

    if(file_exists(APP_PATH.$c.'/index.php')){
        include APP_PATH.$c.DIRECTORY_SEPARATOR.'index.php';
    }
    if(file_exists(APP_PATH.$c.DIRECTORY_SEPARATOR.$c.'.php')){
        include APP_PATH.$c.DIRECTORY_SEPARATOR.$c.'.php';
    }
    if(file_exists(APP_PATH.$c.'.php')){
        include APP_PATH.$c.'.php';
    }
    if(file_exists($c.'.php')){
        include $c.'.php';
    }
}

class hirest{

    public $routes = array();
    private static $instance;
    private $responseHandlerFunctions = [];
    private $request = null;

    /**
     * Singleton
     * @return hirest
     */
    public static function getInstance() {
        if(!is_object(self::$instance)) {
            $c = __CLASS__;
            self::$instance = new $c();
        }
        return self::$instance;
    }

    /**
     * @param $response
     * @return response handled with defined functions
     */
    public function responseHandle($response){
        if(!empty($this->responseHandlerFunctions)){
            foreach($this->responseHandlerFunctions AS $handler){
                $response = call_user_func($handler,$response);
            }
        }
        return $response;
    }

    /** add response handler function
     * @param $function
     */
    public function addResponseHandler($function){
        if(is_callable($function,true)){
            $this->responseHandlerFunctions[] = $function;
            return true;
        }
        throw new Exception('Response handler is not a function');
    }

    /**
     * Add route rule
     * @param $regex
     * @param $controller
     * @param $action
     * @return $this
     */
    public function route($regex, $action, $allowed_methods = null ){
        $this->routes[$regex] = array(
            'action' => $action,
            'allowed_methods' => $allowed_methods
        );
        return $this;
    }

    /**
     * parse URI and handle it
     * @return response
     */
    public function run(){

        if(isset($_SERVER['REQUEST_URI'])){
            $request_uri = $_SERVER['REQUEST_URI'];
        }elseif(isset($_SERVER['argv'][1])){
            $request_uri = $_SERVER['argv'][1];
        }else{
            exit('invalid request');
        }
        preg_match('~^([^\?]+)~ui',$request_uri,$uri);

        $uri = $uri[0];
        $route_founded = false;
        foreach($this->routes AS $route => $action){
            if(preg_match('~^/?'.$route.'[/]?$~iu',$uri,$params)){
                if($action['allowed_methods'] !== null
                    && (
                        !isset($_SERVER['REQUEST_METHOD'])
                        || !in_array($_SERVER['REQUEST_METHOD'],$action['allowed_methods'])
                    )){
                    continue;
                }
                $route_founded = true;
                foreach( $params AS $key => $value){
                    if(is_numeric($key)){
                        unset($params[$key]);
                    }
                }
                $this->request = [
                    'URI'    => $uri,
                    'route'  => $route,
                    'action' => $action
                ];
                break;
            }
        }
        if($route_founded == false){
            http_response_code(404);
            exit();
        }

        if(is_callable($action['action'],true)){
            if(is_array($action['action'])){
                $action['action'][0] = new $action['action'][0];
            }
            $response = call_user_func_array($action['action'],$params);
        }

        echo $this->responseHandle($response);
        return;
    }

}

/**
 * Return hirest instance
 * @return hirest
 */
function hirest(){
    return hirest::getInstance();
}


