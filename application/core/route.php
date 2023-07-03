<? 
class Route { 
    protected static $ControllerRun; 
    protected static $ModelRun; 
    protected static $URLRun; 

    public static function run() 
    { 
        $controller; 
        $action;
        $model; 
        /** 
         * Извлекаем из URI наш маршрут
        */
        $routes = explode('/', $_SERVER['REQUEST_URI']);
        $routes_len = count($routes) - 1; 

        //var_dump($routes);
        //удаляем одну точку маршрута, потому что полагается, что наш сайт находится в корне, а не в папке Modul25
        //Проще говоря: наш route не должен думать, что Modul25 - какой-то компонент сайта
 
        //$routes[0] = "Modul25"; по умолчанию
        if(isset($_GET['debug']) && $_GET['debug'] == 1)
        { 
            echo $routes[1].'/'.$routes[2]; // наши 2 точки 1 - компонент, 2 - действие
        }
        // Если вы в конце URI добавите ?debug=1 увидите эту информацию
        /**
         * Пользователь перешёл на страничку с index.php впервые 
         * Какую страницу открывать по умолчанию первой? 
         * 
         * Кстати, пример базовой ссылки: 
         * 
         * localhost.ru/Modul25 - наш сайт
         * 
         * localhost.ru/Modul25/ - стартовая страница контроллера Main 
         * localhost.ru/Modul25/main/ - прямое обращение к контроллеру main 
         * localhost.ru/Modul25/main/index - то же самое, что и localhost.ru/Modul25/main/ 
         */

        if( ($routes[1] === "/" || empty($routes[1])) && empty($routes[2]) ) 
        { 
            $controller = 'Main'; 
            $model = "Main";
            $action = "index"; 
        } 
        else if (!empty($routes[1])) 
        { 
            $controller = $routes[1]; 
            $model = $routes[1]; 

            if(!empty($routes[2])) 
                $action = $routes[2]; 
            else
                $action = 'index';   
        }
        /** 
         * Что после else if ? 
         * если не пустой первый route и если существует action 
         */

        /* 
            Поднимим первую букву в высокий регистр
        */ 
        if(isset($model)) 
            $model = ucfirst($model); 

        if(isset($controller)) 
            $controller = ucfirst($controller); 

        $controller = 'Controller_'.$controller; // Было Controller_Main стало ControllerMain 
        $model = 'Model_'.$model; // Было Model_Main стало ModelMain 
        // за $action будет браться функция из Controller (сразу) 

        $_model_file = strtolower($model).'.php'; 
        $_model_path = "application/models/".$_model_file;  

        if(file_exists($_model_path))
        {
            include $_model_path;
        } 
        // Model - необязательная часть компонента(она просто даёт нам какую-то информацию)
      
        // Controller - обязательная, это и есть сама страница 
        $_controller_file = strtolower($controller).'.php';
        $_controller_path = "application/controllers/".$_controller_file;

        self::$ControllerRun = $_controller_path; 
        self::$ModelRun = $_model_file; 
        self::$URLRun = $_SERVER['REQUEST_URI'];  

        if(file_exists($_controller_path))
        {
            include $_controller_path;
        }
        else
        { 
            // Поэтому, если страницы не существует, то возвращаем 404
            Route::ErrorPage404();
        }
        
        // создаем контроллер
        $controller = new $controller;
        $action = $action;
        
        if(method_exists($controller, $action))
        {
            $controller->$action();
        }
        else
        {
            Route::ErrorPage404();
        }
       

    }
       
    static function ErrorPage404()
    {
        echo "404 ERROR<br>";
        
        var_dump(self::$ControllerRun); 
        
        echo "<br>"; 

        var_dump(self::$ModelRun); 

        echo "<br>"; 

        var_dump(self::$URLRun); 

        echo "<br>"; 
        
        if(!file_exists(self::$ControllerRun))
        { 
            echo "Контроллера ".self::$ControllerRun." не существует <br/>"; 
        }
        if(!file_exists(self::$ModelRun)) 
        { 
            echo "Модели ".self::$ModelRun." не существует (не критично) <br/>";  
        }
        

        //       $host = 'http://'.$_SERVER['HTTP_HOST'].'/';
        //       header('HTTP/1.1 404 Not Found');
        // header("Status: 404 Not Found");
        // header('Location:'.$host.'404');
    
    
    }
}