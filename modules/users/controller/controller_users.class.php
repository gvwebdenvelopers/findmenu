<?php

class controller_users {

    function __construct() {
        require_once(UTILS_USERS . "functions_user.inc.php");
        include (LIBS . 'password_compat-master/lib/password.php');
        include (UTILS . 'upload.inc.php');
        $_SESSION['module'] = "users";
    }

    ////////////////////////////////////////////////////begin signup///////////////////////////////////////////
    function signup() { //refactorizar loadView para hacer los requires allí
        loadView('modules/users/view/', 'signup.php');
    }

    public function signup_user() {
        $jsondata = array();
        $userJSON = json_decode($_POST['signup_user_json'], true);

        $result = validate_user($userJSON);
        if ($result['resultado']) {
            $avatar = get_gravatar($result['data']['user_email'], $s = 400, $d = 'identicon', $r = 'g', $img = false, $atts = array());
            $userName = explode('@', $result['data']['user_email']);
            $arrArgument = array(
                'avatar' => $avatar,
                'email' => $result['data']['user_email'],
                'name' => "",
                'lastname' => "",
                'password' => password_hash($result['data']['password'], PASSWORD_BCRYPT),
                'tipo' => "client",
                'token' => "",
                'user' => $userName[0]
            );
            /* Control de registro */
            set_error_handler('ErrorHandler');
            try {

                //loadModel
                $arrValue = loadModel(MODEL_USER, "users_model", "count", array('column' => array('user'), 'like' => array($arrArgument['user'])));

                if ($arrValue[0]['total'] == 1) {
                    $arrValue = false;
                    $typeErr = 'Name';
                    $error = "Ya existe un usuario con este email: " . $arrArgument['email'];
                }
            } catch (Exception $e) {

                $arrValue = false;
            }
            restore_error_handler();
            /* Fin de control de registro */

            if ($arrValue) {
                set_error_handler('ErrorHandler');
                try {
                    //loadModel

                    $arrArgument['token'] = "Ver" . md5(uniqid(rand(), true));

                    $arrValue = loadModel(MODEL_USER, "users_model", "create_user", $arrArgument);
                    //echo "en try " . $arrValue;
                } catch (Exception $e) {
                    $arrValue = false;
                }
                restore_error_handler();

                if ($arrValue) {
                    sendtoken($arrArgument, "alta");
                    $url = friendly('?module=home&function=init&param=reg', true);
                    $jsondata["success"] = true;
                    $jsondata["redirect"] = $url;
                    echo json_encode($jsondata);
                    exit;
                } else {
                    $url = friendly('?module=home&function=init&param=503', true);
                    $jsondata["success"] = true;
                    $jsondata["redirect"] = $url;
                    echo json_encode($jsondata);
                }
            } else {
                $jsondata["success"] = false;
                $jsondata["typeErr"] = $typeErr;
                $jsondata["error"] = $error;
                echo json_encode($jsondata);
            }
        } else {
            $jsondata["success"] = false;
            $jsondata['data'] = $result;
            echo json_encode($jsondata);
        }
    }

    ////////////////////////////////////////////////////begin signin///////////////////////////////////////////
    public function login() {
        $user = json_decode($_POST['login_json'], true);
        $column = array(
            'user'
        );
        $like = array(
            $user['user']
        );

        $arrArgument = array(
            'column' => $column,
            'like' => $like,
            'field' => array('password')
        );

        set_error_handler('ErrorHandler');
        try {
            //loadModel
            $arrValue = loadModel(MODEL_USER, "users_model", "select", $arrArgument);

            $arrValue = password_verify($user['password'], $arrValue[0]['password']);
        } catch (Exception $e) {
            $arrValue = "error";
        }
        restore_error_handler();

        if ($arrValue !== "error") {
            if ($arrValue) { //OK
                set_error_handler('ErrorHandler');
                try {
                    $arrArgument = array(
                        'column' => array("user", "active"),
                        'like' => array($user['user'], "1")
                    );
                    $arrValue = loadModel(MODEL_USER, "users_model", "count", $arrArgument);
                    //echo json_encode($arrValue);
                    //exit();
                    if ($arrValue[0]["total"] == 1) {
                        $arrArgument = array(
                            'column' => array("user"),
                            'like' => array($user['user']),
                            'field' => array('*')
                        );
                        $user = loadModel(MODEL_USER, "users_model", "select", $arrArgument);
                        $url = friendly('?module=home', true);
                        $jsondata["success"] = true;
                        $jsondata["redirect"] = $url;
                        $jsondata["user"] = $user;
                        echo json_encode($user);
                        exit();
                    } else {
                        $value = array(
                            "error" => true,
                            "datos" => "El usuario no ha sido activado, revise su correo"
                        );
                        echo json_encode($value);
                        exit();
                    }
                } catch (Exception $e) {
                    $value = array(
                        "error" => true,
                        "datos" => 503
                    );
                    echo json_encode($value);
                }
            } else {
                $value = array(
                    "error" => true,
                    "datos" => "El usuario y la contraseña no coinciden"
                );
                echo json_encode($value);
            }
        } else {
            $value = array(
                "error" => true,
                "datos" => 503
            );
            echo json_encode($value);
        }
    }

    ////////////////////////////////////////////////////end signin///////////////////////////////////////////

    function verify() {

        //a esta función se llega cuando el usuario verifica su alta
        if (substr($_GET['param'], 0, 3) == "Ver") {
            $arrArgument = array(
                'column' => array('token'),
                'like' => array($_GET['param']),
                'field' => array('active'),
                'new' => array('1')
            );
            set_error_handler('ErrorHandler');
            try {
                //consulta de sql que modificará el estado activado a 1 si es igual el token
                //la consulta esta preparada para actualizar mas cosas, se usa en mas lugares.
                $value = loadModel(MODEL_USER, "users_model", "update_one", $arrArgument);
            } catch (Exception $e) {
                $value = false;
            }
            restore_error_handler();
            if ($value) {
                loadView('modules/home/view/', 'home.php');
            } else {
                showErrorPage(1, "", 'HTTP/1.0 503 Service Unavailable', 503);
            }
        }
    }

    ////////////////////////////////////////////////////end signup///////////////////////////////////////////

    public function social_signin() { //utilitzada per Facebook i Twitter
        $user = json_decode($_POST['user'], true);

        set_error_handler('ErrorHandler');
        try {

            $arrValue = loadModel(MODEL_USER, "users_model", "count", array('column' => array('user'), 'like' => array($user['id'])));
        } catch (Exception $e) {
            $arrValue = false;
        }
        restore_error_handler();

        if (!$arrValue[0]["total"]) {
            if ($user['email'])
                $avatar = 'https://graph.facebook.com/' . ($user['id']) . '/picture';
            else
                $avatar = get_gravatar($mail, $s = 400, $d = 'identicon', $r = 'g', $img = false, $atts = array());

            $arrArgument = array(
                'active' => "1",
                'avatar' => $avatar,
                'email' => $user['email'],
                'lastname' => $user['apellidos'],
                'name' => $user['nombre'],
                'password' => "",
                'tipo' => "client",
                'token' => "",
                'user' => $user['id']
            );
            set_error_handler('ErrorHandler');
            try {
                $value = loadModel(MODEL_USER, "users_model", "create_user", $arrArgument);
            } catch (Exception $e) {
                $value = false;
            }
            restore_error_handler();
        } else
            $value = true;

        if ($value) {
            set_error_handler('ErrorHandler');
            $arrArgument = array(
                'column' => array("user"),
                'like' => array($user['id']),
                'field' => array('*')
            );
            $user = loadModel(MODEL_USER, "users_model", "select", $arrArgument);
            restore_error_handler();
            echo json_encode($user);
        } else {
            echo json_encode(array('error' => true, 'datos' => 503));
        }
    }

    ////////////////////////////////////////////////////begin restore///////////////////////////////////////////
    function restore() {
        //1- La función restore solo carga la vista en la que el usuario introducirá
        //su email para que le cambiemos la contraseña
        loadView('modules/users/view/', 'restore.php');
    }

    public function process_restore() {
        //2- La función process_restore cambia el token si existe el correo
        //introducido y envia un correo con el token
        $result = array();
        if (isset($_POST['inputEmail'])) {
            $result = valida_email($_POST['inputEmail']);
            if ($result) {
                $column = array(
                    'email'
                );
                $like = array(
                    $_POST['inputEmail']
                );
                $field = array(
                    'token'
                );

                $token = "Cha" . md5(uniqid(rand(), true));
                $new = array(
                    $token
                );

                $arrArgument = array(
                    'column' => $column,
                    'like' => $like,
                    'field' => $field,
                    'new' => $new
                );
                $arrValue = loadModel(MODEL_USER, "users_model", "count", $arrArgument);
                if ($arrValue[0]['total'] == 1) {
                    //Esta consulta meda error de variables no definidas change y sql3 pero realiza
                    //realiza la consulta igual aunque al fallar no redirecciona
                    $arrValue = loadModel(MODEL_USER, "users_model", "update_one", $arrArgument);
                    if ($arrValue) {
                        //////////////// Envio del correo al usuario
                        $arrArgument = array(
                            'token' => $token,
                            'email' => $_POST['inputEmail']
                        );

                        if (sendtoken($arrArgument, "modificacion")) {

                            echo "Tu nueva contraseña ha sido enviada al email";
                        } else {

                            echo "Error en el servidor. Intentelo más tarde";
                        }
                    }
                } else {
                    echo "El email introducido no existe ";
                }
            } else {
                echo "El email no es válido";
            }
        }
    }

    function changepass() {
        //3-esta funcioón la utilizamos para entrar a la vista changepass desde el correo enviado
        if (substr($_GET['param'], 0, 3) == "Cha") {
            loadView('modules/users/view/', 'changepass.php');
        } else {
            showErrorPage(1, "", 'HTTP/1.0 503 Service Unavailable', 503);
        }
    }

    function update_pass() {
        //4-cuando ya hemos validado el password con js utilizamos esta función
        //para actualizar el password en la base de datos
        $jsondata = array();
        $pass = json_decode($_POST['passw'], true);
        $arrArgument = array(
            'column' => array('token'),
            'like' => array($pass['token']),
            'field' => array('password'),
            'new' => array(password_hash($pass['password'], PASSWORD_BCRYPT))
        );

        set_error_handler('ErrorHandler');
        try {
            $value = loadModel(MODEL_USER, "users_model", "update_one", $arrArgument);
        } catch (Exception $e) {
            $value = false;
        }
        restore_error_handler();

        if ($value) {
            $url = friendly('?module=home&function=init&param=rest', true);
            $jsondata["success"] = true;
            $jsondata["redirect"] = $url;
            echo json_encode($jsondata);
            exit;
        } else {
            $url = friendly('?module=home&function=init&param=503', true);
            $jsondata["success"] = true;
            $jsondata["redirect"] = $url;
            echo json_encode($jsondata);
            exit;
        }
    }

    ////////////////////////////////////////////////////end restore///////////////////////////////////////////

    ////////////////////////////////////////////////////begin profile///////////////////////////////////////////
    function profile() {
        loadView('modules/users/view/', 'profile.php');
    }

      function upload_avatar() {
      $result_avatar = upload_files();
      $_SESSION['avatar'] = $result_avatar;
      }

      function delete_avatar() {
      $_SESSION['avatar'] = array();
      $result = remove_files();
      if ($result === true) {
      echo json_encode(array("res" => true));
      } else {
      echo json_encode(array("res" => false));
      }
      }

    function profile_filler() {
        if (isset($_POST['user'])) {
            set_error_handler('ErrorHandler');
            try {
                $arrValue = loadModel(MODEL_USER, "users_model", "select", array(column => array('user'), like => array($_POST['user']), field => array('*')));
                //$jsondata["arrValue"] = $arrValue;
                //$jsondata["msg"] = "en try";
            } catch (Exception $e) {
                //$jsondata["msg"] = "en excepcion";
                $arrValue = false;
            }
            //echo json_encode($jsondata);
            //exit();
            restore_error_handler();

            if ($arrValue) {
                $jsondata["success"] = true;
                $jsondata['user'] = $arrValue[0];
                echo json_encode($jsondata);
                exit();
            } else {
                $url = friendly('?module=home&function=init&param=503', true);
                $jsondata["success"] = false;
                $jsondata['redirect'] = $url;
                echo json_encode($jsondata);
                exit();
            }
        } else {
            $url = friendly('?module=home', true);
            $jsondata["success"] = false;
            $jsondata['redirect'] = $url;
            echo json_encode($jsondata);
            exit();
        }
    }

      function load_pais_user() {
      if ((isset($_GET["param"])) && ($_GET["param"] == true)) {
      $json = array();
      $url = 'http://www.oorsprong.org/websamples.countryinfo/CountryInfoService.wso/ListOfCountryNamesByName/JSON';
      set_error_handler('ErrorHandler');
      try {
      $json = loadModel(MODEL_USER, "user_model", "obtain_paises", $url);
      } catch (Exception $e) {
      $json = false;
      }
      restore_error_handler();

      if ($json) {
      echo $json;
      exit;
      } else {
      $json = "error";
      echo $json;
      exit;
      }
      }
      }

      function load_provincias_user() {
      if ((isset($_GET["param"])) && ($_GET["param"] == true)) {
      $jsondata = array();
      $json = array();

      set_error_handler('ErrorHandler');
      try {
      $json = loadModel(MODEL_USER, "user_model", "obtain_provincias");
      } catch (Exception $e) {
      $json = false;
      }
      restore_error_handler();

      if ($json) {
      $jsondata["provincias"] = $json;
      echo json_encode($jsondata);
      exit;
      } else {
      $jsondata["provincias"] = "error";
      echo json_encode($jsondata);
      exit;
      }
      }
      }

      function load_poblaciones_user() {
      if (isset($_POST['idPoblac'])) {
      $jsondata = array();
      $json = array();

      set_error_handler('ErrorHandler');
      try {
      $json = loadModel(MODEL_USER, "user_model", "obtain_poblaciones", $_POST['idPoblac']);
      } catch (Exception $e) {
      $json = false;
      }
      restore_error_handler();

      if ($json) {
      $jsondata["poblaciones"] = $json;
      echo json_encode($jsondata);
      exit;
      } else {
      $jsondata["poblaciones"] = "error";
      echo json_encode($jsondata);
      exit;
      }
      }
      }

      function modify() {
      $jsondata = array();
      $userJSON = json_decode($_POST['mod_user_json'], true);
      $userJSON['password2'] = $userJSON['password'];

      $result = validate_userPHP($userJSON);
      if ($result['resultado']) {
      $arrArgument = array(
      'nombre' => $result['datos']['nombre'],
      'apellidos' => $result['datos']['apellidos'],
      'email' => $result['datos']['email'],
      'password' => password_hash($result['datos']['password'], PASSWORD_BCRYPT),
      'date_birthday' => strtoupper($result['datos']['date_birthday']),
      'tipo' => $result['datos']['tipo'],
      'bank' => $result['datos']['bank'],
      'avatar' => $_SESSION['avatar']['datos'],
      'dni' => $result['datos']['dni'],
      'pais' => $result['datos']['pais'],
      'provincia' => $result['datos']['provincia'],
      'poblacion' => $result['datos']['poblacion']
      );
      $arrayDatos = array(
      column => array(
      'email'
      ),
      like => array(
      $arrArgument['email']
      )
      );
      $j = 0;
      foreach ($arrArgument as $clave => $valor) {
      if ($valor != "") {
      $arrayDatos['field'][$j] = $clave;
      $arrayDatos['new'][$j] = $valor;
      $j++;
      }
      }

      set_error_handler('ErrorHandler');
      try {
      $arrValue = loadModel(MODEL_USER, "user_model", "update", $arrayDatos);
      } catch (Exception $e) {
      $arrValue = false;
      }
      restore_error_handler();
      if ($arrValue) {
      $url = amigable('?module=user&function=profile&param=done', true);
      $jsondata["success"] = true;
      $jsondata["redirect"] = $url;
      echo json_encode($jsondata);
      exit;
      } else {
      $jsondata["success"] = false;
      $jsondata["redirect"] = $url = amigable('?module=user&function=profile&param=503', true);
      echo json_encode($jsondata);
      }
      } else {
      $jsondata["success"] = false;
      $jsondata['datos'] = $result;
      echo json_encode($jsondata);
      }
      }
      ////////////////////////////////////////////////////end profile///////////////////////////////////////////
}
