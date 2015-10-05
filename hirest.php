<?php

/**
 * Грузим на лету классы по имени. Ищем в нужных папках.
 * @param $class_name
 */
function __autoload($class_name) {
    if(file_exists($class_name.'/index.php'))
        include $class_name.'/index.php';
    if(file_exists($class_name.'/'.$class_name.'.php'))
        include $class_name.'/'.$class_name.'.php';
    if(file_exists($class_name.'.php'))
        include $class_name.'.php';
}

class hirest{

    var $routes = array();
    private static $instance;

    /**
     * Делаем сиглетон
     * @return mixed
     */
    public static function getInstance() {
        if(!is_object(self::$instance)) {
            $c = __CLASS__;
            self::$instance = new $c();
        }
        return self::$instance;
    }

    /**
     * Добавляем роут в наше приложение.
     * Все роуты добавляются в файле routes.php
     * @param $regex
     * @param $controller
     * @param $action
     * @return $this
     */
    public function route($regex, $controller, $action){
        $this->routes[$regex] = array($controller,$action);
        return $this;
    }


    /**
     * Парсим URL и если он попадает под роут, запускаем соответствующий контроллер и экшн
     * @return bool
     */
    public function run(){
        preg_match('~^([^\?]+)~ui',$_SERVER['REQUEST_URI'],$uri);

        $uri = $uri[0];
        $route_founded = false;
        foreach($this->routes AS $route => $action){
            if(preg_match('~^'.$route.'[/]?$~iu',$uri,$params)){
                $route_founded = true;
                unset($params[0]); // вся подстрока не нужна. Мусор регекспа в данном случае

                $controller_name      = $action[0];                       // Имя контроллера
                $action_name          = $action[1];                       // Имя экшена
                break;
            }
        }
        if($route_founded == false){
            throw new NotFoundHttpException('Interface not found');
        }


        // Запускаем контроллер
        $controller = new $controller_name();
        $controller->$action_name(list($params));


        // Выполним, если есть что, перед экшеном
        $controller->beforeActionRun();
        // Выполняем экшн
        $controller->$action_name();
        // Выполним, если есть что, после экшена
        $controller->afterActionRun();

        return true;
    }

}

function hirest(){
    return hirest::getInstance();
}


