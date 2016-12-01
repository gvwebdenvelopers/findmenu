<?php
class ofertas_dao {
    static $_instance;

    private function __construct() {
        
    }

    public static function getInstance() {
        if (!(self::$_instance instanceof self))
            self::$_instance = new self();
        return self::$_instance;
    }

    public function create_ofertas_DAO($db, $arrArgument) {
        /* $usuario = $arrArgument['usuario'];
          $dni = $arrArgument['dni'];
          $nombre = $arrArgument['nombre'];
          $apellidos = $arrArgument['apellidos'];
          $email = $arrArgument['email'];
          $password = $arrArgument['password'];
          $date_birthday = $arrArgument['date_birthday'];
          $tipo = $arrArgument['tipo'];
          $bank = $arrArgument['bank'];
          $avatar = $arrArgument['avatar'];
          $pais = " ";
          $provincia = " ";
          $poblacion = " ";
          $valoracion = " ";
          $token = $arrArgument['token'];
          if ($arrArgument['activado'])
          $activado = $arrArgument['activado'];
          else
          $activado = 0;

          $sql = "INSERT INTO usuarios (usuario, email, nombre, apellidos, dni,"
          . " password, date_birthday, tipo, bank, pais, provincia, poblacion, avatar, valoracion, activado, token"
          . " ) VALUES ('$usuario', '$email', '$nombre',"
          . " '$apellidos', '$dni', '$password', '$date_birthday', '$tipo', '$bank','$pais','$provincia','$poblacion', '$avatar', '$valoracion', '$activado','$token')";


          return $db->ejecutar($sql); */
    }

    public function count_DAO($db, $arrArgument) {
        /* $arrArgument is composed by 2 array ("column" and "like"), this iterates 
         * the number of positions the array have, this way we get a method that builds a
         * custom sql to select with the needed arguments
         */
        $i = count($arrArgument['column']);
        $sql = "SELECT COUNT(*) as total FROM ofertas WHERE ";
        for ($j = 0; $j < $i; $j++) {
            if ($i > 1 && $j != 0)
                $sql.=" AND ";
            $sql .= $arrArgument['column'][$j] . " like '" . $arrArgument['like'][$j] . "'";
        }

        $stmt = $db->ejecutar($sql);
        return $db->listar($stmt);
    }

    public function select_DAO($db, $arrArgument) {
        $i = count($arrArgument['column']);
        $k = count($arrArgument['field']);
        $sql1 = "SELECT ";
        $sql2 = " FROM ofertas WHERE ";
      
        if ($arrArgument['column'][0] != 'false')
            for ($j = 0; $j < $i; $j++) {
                if ($i > 1 && $j != 0)
                    $sql.=" AND ";
                $sql .= $arrArgument['column'][$j] . " like '" . $arrArgument['like'][$j] . "'";
            }

        for ($l = 0; $l < $k; $l++) {
            if ($l > 1 && $k != 0)
                $fields.=", ";
            $fields .= $arrArgument['field'][$l];
        }

        if ($arrArgument['column'][0] != 'false')
            $sql = $sql1 . $fields . $sql2 . $sql;
        else
            $sql = $sql1 . $fields . ' FROM ofertas';

        $stmt = $db->ejecutar($sql);
        return $db->listar($stmt);
    }

    public function update_DAO($db, $arrArgument) {
        /*
         * @param= $arrArgument( column => array(colum),
         *                          like => array(like),
         *                          field => array(field),
         *                          new => array(new)
         *                      );
         */
        $i = count($arrArgument['field']);
        $k = count($arrArgument['column']);

        $sql1 = "UPDATE ofertas SET ";
        $sql2 = "  WHERE ";

        for ($j = 0; $j < $i; $j++) {
            if ($i > 1 && $j != 0)
                $change.=", ";
            $change .= $arrArgument['field'][$j] . "='" . $arrArgument['new'][$j] . "'";
        }
        for ($l = 0; $l < $k; $l++) {
            if ($k > 1 && $l != 0)
                $sql.=" AND ";
            $sql .= $arrArgument['column'][$l] . " like '" . $arrArgument['like'][$l] . "'";
        }

        $sql = $sql1 . $change . $sql2 . $sql;
        return $db->ejecutar($sql);
    }

}
