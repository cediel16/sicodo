<?php

class base {

    private $database = 'pgsql';
    private $host = 'localhost';
    private $dbname = 'sicodo';
    private $user = 'sicodo';
    private $pass = '123456';
    private $cn;
    /* private $error; */
    var $rst;
    var $data;
    private $row_count;
    private $current_row = -1;
    private $MSJ_ERROR;
    private $MSJ_ERROR_TYPE;
    private $MSJ_ERROR_SHOW = 1;
    private $qry;
    var $eof = 1;
    var $fields;
    var $fields_option;
//paginado
    var $pagina = 1;
    var $por_pagina = 4;
    var $registros_por_pagina;
    var $total_paginas;
    var $total;
    var $error_pag;
    var $_anterior = '<';
    var $_siguiente = '>';
    var $_primero = '<<';
    var $_ultimo = '>>';
    var $_separador = '|';
//numero de paginas
    var $pagina_actual = 1;
    var $seccion_actual = 1;
    var $total_secciones;
    var $paginas_seccion;
    var $max_paginas_por_seccion = 4;
//SESSION
    var $cookie_expire = 3600;

    function base($database = NULL) {
        if (!is_null($database)) {
            $this->database = $database;
        }

        $this->db_connect($this->database);
        
    }

    function db_query($qry) {

        $this->MSJ_ERROR_TYPE = 's';
        $this->qry = $qry;
        switch ($this->database) {
            case 'pgsql': {
                    pg_send_query($this->cn, $this->qry);
                    $rst = pg_get_result($this->cn);
                    if (is_numeric(pg_num_rows($rst))) {
                        $row_count = pg_num_rows($rst);
                    } else {
                        $row_count = 0;
                    }
                    break;
                }
            case 'mysql': {
                    $rst = mysql_query($this->qry);
                    if (is_numeric(strpos($this->qry, 'select'))) {
                        $row_count = mysql_num_rows($rst);
                    } else {
                        $row_count = 0;
                    }
                    break;
                }
        }

        if (strlen($this->db_last_error())) {
            return 0;
        } else {
            $this->rst = $rst;
            $this->row_count = $row_count;
            if ($this->row_count > 0) {
                $this->eof = 0;
                $this->current_row = 0;
                $this->db_set_data();
                $this->db_set_fetch();
            } else {
                $this->eof = 1;
                $this->current_row = -1;
            }
            return 1;
        }
    }

    function db_insert($tabla, $d) {
        $this->MSJ_ERROR_TYPE = 'i';
        if (!is_array($d)) {
            return 0;
        } elseif (!$this->db_query('select * from ' . $tabla . ' limit 1')) {
            return 0;
        } else {
            foreach ($d as $k => $v) {
                if (is_numeric($k)) {
                    $campos.=$this->db_field_name($this->rst, $k) . ',';
                    $valores.=$this->db_dato($this->rst, $v, $k) . ',';
                } else {
                    $campos.=$k . ',';
                    $valores.=$this->db_dato($this->rst, $v, $this->db_field_num($this->rst, $k)) . ',';
                }
            }
            $this->qry = 'insert into ' . $tabla . ' (' . substr($campos, 0, strlen($campos) - 1) . ') values (' . substr($valores, 0, strlen($valores) - 1) . ')';
            if ($this->db_query($this->qry) == 0) {
                return 0;
            } else {
                if (!$this->db_affected_rows($this->rst)) {
                    return 0;
                } else {
                    return 1;
                }
            }
        }
    }

    function db_update($tabla, $d, $op) {
        $this->MSJ_ERROR_TYPE = 'u';
        if (!is_array($d)) {
            return -1;
        } elseif (!$this->db_query('select * from ' . $tabla . ' limit 1')) {
            return -1;
        } else {
            foreach ($d as $k => $v) {
                if (is_numeric($k)) {
                    $campos_datos.=$this->db_field_name($this->rst, $k) . '=' . $this->db_dato($this->rst, $v, $this->db_field_num($this->rst, $k)) . ',';
                } else {
                    $campos_datos.=$k . '=' . $this->db_dato($this->rst, $v, $this->db_field_num($this->rst, $k)) . ',';
                }
            }
            $this->qry = "update $tabla set " . substr($campos_datos, 0, strlen($campos_datos) - 1) . " where $op";
            if (!$this->db_query($this->qry)) {
                return -1;
            } elseif (!$this->db_affected_rows($this->rst)) {
                return 0;
            } else {
                return 1;
            }
        }
    }

    function db_delete($tabla, $op) {
        if (!$rst = $this->db_query('select * from ' . $tabla . ' limit 1')) {
            return -1;
        } else {
            $this->MSJ_ERROR_TYPE = 'd';
            $this->qry = "delete from $tabla where $op";
            if (!$this->db_query($this->qry)) {
                return -1;
            } elseif (!$this->db_affected_rows($this->rst)) {
                return 0;
            } else {
                return 1;
            }
        }
    }

    function db_move_next() {
        if (!$this->eof) {
            $this->current_row++;
            if ($this->db_set_fetch())
                return 1;
        }
        $this->eof = 1;
        return 0;
    }

    function db_move_first() {
        if ($this->current_row == 0)
            return 1;
        return $this->db_move(0);
    }

    function db_move_last() {
        $pos = $this->row_count - 1;
        if ($this->current_row == $pos)
            return 1;
        return $this->db_move($pos);
    }

    function db_move($row_num = 0) {
        if ($row_num < 0 || $row_num > $this->row_count) {
            return 0;
        }
        $this->current_row = $row_num;
        if ($this->current_row == ($this->row_count - 1)) {
            $this->eof = 1;
        } else {
            $this->eof = 0;
        }
        $this->db_set_fetch();
        return 1;
    }

    function db_set_fetch() {
        $pos = $this->current_row;
        if ($this->row_count <= $pos) {
            return 0;
        }
        $this->fields = $this->data[$pos];
        return 1;
    }

    function db_set_data() {
        while ($d = $this->db_fetch()) {
            $a[] = $d;
        }
        $this->data = $a;
    }

    function db_dato($rst, $d, $n) {
        if ($this->db_field_name($rst, $n) == 'pass') {
            return $d;
        } else {

            $this->db_field_type($rst, $n);
            switch ($this->db_field_type($rst, $n)) {
//pgsql
                case 'numeric':
                case 'varchar':
                case 'text':
                case 'date':
                case 'time':

//mysql
                case 'string':
                case 'blob':
                    return "'$d'";
                default:
                    return $d;
            }
        }
    }

    function db_error() {
        switch ($this->MSJ_ERROR_TYPE) {
            case 'n':
                $this->MSJ_ERROR = 'Base de datos "' . $this->database . '" no soportada.';
                break;
            case 'c':
                $this->MSJ_ERROR = 'Error en la conexion...';
                break;
            case 'i':
                $this->MSJ_ERROR = 'Error al tratar de insertar en la base de datos.';
                break;
            case 's':
                $this->MSJ_ERROR = 'Error al tratar de consultar la base de datos.';
                break;
            case 'u':
                $this->MSJ_ERROR = 'Error al tratar de actualizar la base de datos.';
                break;
            case 'd':
                $this->MSJ_ERROR = 'Error al tratar de elminar en la base de datos.';
                break;
            case 'bt':
                $this->MSJ_ERROR = 'Error al tratar de iniciar transaccion en la base de datos.';
                break;
            case 'rt':
                $this->MSJ_ERROR = 'Error al tratar de cancelar transaccion en la base de datos.';
                break;
            case 'et':
                $this->MSJ_ERROR = 'Error al tratar de finalizar transaccion en la base de datos.';
                break;
            default:
                $this->MSJ_ERROR = 'Error al tratar de manipular la base de datos.';
                break;
        }
        $this->MSJ_ERROR_TYPE = '';
        if (!$this->MSJ_ERROR_SHOW) {
            return $this->MSJ_ERROR;
        } else {

            if (!strlen($this->db_last_error())) {
                $error = '';
            } else {
                $error = ' (' . $this->db_last_error() . ')';
            }
            return $this->MSJ_ERROR . $error;
        }
    }

    function db_connect($database) {
        $this->MSJ_ERROR_TYPE = 'c';
        $this->database = $database;
        $str_cn = 'host=' . $this->host . ' dbname=' . $this->dbname . ' user=' . $this->user . ' password=' . $this->pass;
        switch ($this->database) {
            case 'pgsql': {
                    $this->cn = @pg_connect($str_cn) or die($this->db_error());
                    break;
                }
            case 'mysql': {
                    $this->cn = @mysql_connect($this->host, $this->user, $this->pass) or die($this->db_error());
                    @mysql_select_db($this->dbname, $this->cn) or die($this->db_error());
                    break;
                }
            default: $this->MSJ_ERROR_TYPE = 'n';
                die($this->db_error());
                break;
        }
    }

    function db_close() {
        switch ($this == 'pgsql') {
            case 'pgsql': {
                    pg_close();
                    break;
                }
            case 'mysql': {
                    mysql_close();
                    break;
                }
        }
    }

    function db_affected_rows($rst = '') {
        if ($rst == '') {
            $rst = $this->rst;
        }
        switch ($this->database) {
            case 'pgsql': {
                    $affected_rows = pg_affected_rows($rst);
                    break;
                }
            case 'mysql': {
                    $affected_rows = @mysql_affected_rows();
                    break;
                }
        }
//        if ($affected_rows < 0) {
//            $affected_rows = 0;
//        }

        return $affected_rows;
    }

    function db_last_error() {
        switch ($this->database) {
            case 'pgsql': {
                    $last_error = @pg_last_error($this->cn);
                    break;
                }
            case 'mysql': {
                    $last_error = @mysql_error();
                    break;
                }
        }
        return $last_error;
    }

    function db_last_query() {
        return $this->qry;
    }

    function db_field_name($rst, $n) {
        switch ($this->database) {
            case 'pgsql': {
                    $field_name = @pg_field_name($rst, $n);
                    break;
                }
            case 'mysql': {
                    $field_name = @mysql_field_name($rst, $n);
                    break;
                }
        }
        return $field_name;
    }

    function db_field_num($rst, $name) {
        switch ($this->database) {
            case 'pgsql': {
                    return @pg_field_num($rst, $name);
                    break;
                }
            case 'mysql': {
                    if (!$rst = $this->query('show columns from ' . mysql_field_table($rst, 0))) {
                        return -1;
                    } else {
                        $n = -1;
                        while ($d = mysql_fetch_assoc($rst)) {
                            $n++;
                            if ($d['Field'] == $name) {
                                return $n;
                            }
                        }
                        return -1;
                    }//else
                    break;
                }//case
        }//switch
    }

    function db_field_type($rst, $n) {
        switch ($this->database) {
            case 'pgsql': {
                    $field_type = @pg_field_type($rst, $n);
                    break;
                }
            case 'mysql': {
                    $field_type = @mysql_field_type($rst, $n);
                    break;
                }
        }
        return $field_type;
    }

    function db_fetch() {
        switch ($this->database) {
            case 'pgsql': {
                    if ($this->fields_option == 'assoc') {
                        return @pg_fetch_assoc($this->rst);
                    } elseif ($this->fields_option == 'num') {
                        return @pg_fetch_row($this->rst);
                    } else {
                        return @pg_fetch_array($this->rst);
                    }
                    break;
                }
            case 'mysql': {
                    if ($this->fields_option == 'assoc') {
                        return @mysql_fetch_assoc($this->rst);
                    } elseif ($this->fields_option == 'num') {
                        return @mysql_fetch_row($this->rst);
                    } else {
                        return @mysql_fetch_array($this->rst);
                    }
                    break;
                }
        }//switch
    }

    function db_num_rows() {
        return $this->row_count;
    }

}

//class
?>
