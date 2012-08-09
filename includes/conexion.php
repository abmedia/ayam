<?php
include 'conf.inc.php';
/**
 * Description of conexion
 * This class is a little abstraction for work with the database
 * @author hawk
 */
class conexion {
    var $conexion;
    
    // Create a new connection
    function __construct() {
        include 'db.inc.php';
        $this->conexion = mysql_connect($dbhost, $dbuser, $dbpwd) or die(mysql_error());
        mysql_select_db($dbname, $this->conexion);
    }
    
    // Return only the number of rows of a $result.
    public function consultarRegistros($sql) {
        mysql_real_escape_string($sql, $this->conexion);
        $data = mysql_query($sql, $this->conexion) or die (mysql_error());
        $rows = mysql_num_rows($data);
        $this->closeResult($data);
        return $rows;
    }

    // Receives an argument (SQL Query) and execute. This method return the resultset.
    public function consultar($sql){
        $result = mysql_query($sql, $this->conexion) or die ("A:".mysql_error());
        return $result;
    }
    
    // This method recieves and resultset and this is close.
    public function closeResult($result){
        mysql_free_result($result);
    }
    
    // This method makes a insertion into database. If not make nothing, print a error message.
    public function insertar($query) {
        include 'conf.inc.php';
        $data = mysql_query($query, $this->conexion);
        // or die("A: ". mysql_error().'<br>')
        $num = mysql_affected_rows();
        if ($num > 0) {
            print '<div class="elementocentrado"> Tus datos fueron registrados con exitosamente <br>';
            print '<input type="button" onClick=location.href="../" value="Volver al Inicio"></div>';
        }else{
            print '<div class="elementocentrado">Hubo un error al guardar tus datos, intenta en otro momento.<br> ';
            print '<input type="button" onClick=location.href="../" value="Volver al Inicio"></div>';
        }
    }
}
?>
