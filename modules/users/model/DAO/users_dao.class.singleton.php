<?php
class users_dao {

    static $_instance;

    private function __construct() {

    }

    public static function getInstance() {
        if (!(self::$_instance instanceof self))
            self::$_instance = new self();
        return self::$_instance;
    }

    public function create_user_DAO($db, $arrArgument) {
        $nombre = $arrArgument['nombre'];
        $apellidos = $arrArgument['apellidos'];
        $date_birthday = $arrArgument['date_birthday'];
        $sing_in_date = "";
        $email = $arrArgument['email'];
        $usuario = $arrArgument['usuario'];
        $password = $arrArgument['password'];
        $tipo = $arrArgument['tipo'];
        $avatar = $arrArgument['avatar'];
        $pais = " ";
        $provincia = " ";
        $poblacion = " ";
        $favorites = " ";
        $token = $arrArgument['token'];
        if ($arrArgument['activado'])
            $activado = $arrArgument['activado'];
        else
            $activado = 0;

        $sql = "INSERT INTO usuarios ( name, lastname, birthdate, singindate, email, user,"
                . " password, usertype, avatar, country, province, city, favorites, active, token"
                . " ) VALUES ('$nombre', '$apellidos','$date_birthday', '$sing_in_date', '$email', '$usuario',"
                . " '$password', '$tipo', '$avatar', '$pais','$provincia','$poblacion', '$favorites','$token', '$activado',)";

        return $db->ejecutar($sql);
    }

    public function obtain_countries_DAO($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $file_contents = curl_exec($ch);
        curl_close($ch);

        return ($file_contents) ? $file_contents : FALSE;
    }

    public function obtain_provinces_DAO() {
        $json = array();
        $tmp = array();

        $provincias = simplexml_load_file(RESOURCES . "provinciasypoblaciones.xml");
        $result = $provincias->xpath("/lista/provincia/nombre | /lista/provincia/@id");

        for ($i = 0; $i < count($result); $i+=2) {
            $e = $i + 1;
            $provincia = $result[$e];

            $tmp = array(
                'id' => (string) $result[$i], 'nombre' => (string) $provincia
            );
            array_push($json, $tmp);
        }
        return $json;
    }

    public function obtain_towns_DAO($arrArgument) {
        $json = array();
        $tmp = array();

        $filter = (string) $arrArgument;
        $xml = simplexml_load_file(RESOURCES . 'provinciasypoblaciones.xml');
        $result = $xml->xpath("/lista/provincia[@id='$filter']/localidades");

        for ($i = 0; $i < count($result[0]); $i++) {
            $tmp = array(
                'poblacion' => (string) $result[0]->localidad[$i]
            );
            array_push($json, $tmp);
        }
        return $json;
    }
}