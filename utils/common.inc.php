<?php
    function loadModel($model_path, $model_name, $function, $arrArgument = '') {
        $model = $model_path . $model_name . '.class.singleton.php';

        if (file_exists($model)) {
<<<<<<< HEAD
            
=======

>>>>>>> oscar_produccion
            include_once($model);
            
            $modelClass = $model_name;
            
            if (!method_exists($modelClass, $function)){
                 
              throw new Exception();
            }

            $obj = $modelClass::getInstance();

            if (isset($arrArgument)) {
                
                return $obj->$function($arrArgument);
            }
        } else {
            
            throw new Exception();

        }

    }


    function loadView($rutaVista = "", $templateName = "", $arrPassValue = '') {
    		$view_path = $rutaVista . $templateName;
    		$arrData = '';
                  
    		if (file_exists($view_path)) {
            echo "entra al if ";
            echo $view_path;
      			if (isset($arrPassValue))
      				$arrData = $arrPassValue;
      			include_once($view_path);
                        
    		} else {
            echo "entra al else ";
            echo $rutaVista . $templateName;
            $result = filter_num_int($rutaVista);
            if ($result['resultado']) {
                $rutaVista = $result['datos'];
            } else {
                $rutaVista = http_response_code();
            }

            $log = log::getInstance();
            $log->add_log_general("error loadView general", $_GET['module'], "response ".http_response_code()); //$text, $controller, $function
            $log->add_log_user("error loadView general", "", $_GET['module'], "response ".http_response_code());//$msg, $username = "", $controller, $function


            $result = response_code($rutaVista);
            $arrData = $result;
            require_once VIEW_PATH_INC_ERROR . $result['code'] .'.php';

    		}
  	}
