<?php

class sesiones {

    public static function login($user, $pass) {
        $db = new base();
        $qry = "select id,
        usuario,
        nombre,
        status
        from usuarios
        where usuario='$user'
        and clave=md5('$pass')
        and status='activo'";
        $db->fields_option = 'assoc';
        if (!$db->db_query($qry)) {
            die($db->db_error());
        }

        if ($db->db_num_rows() == 1) {
            sesiones::set_userdata($db->fields);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public static function set_userdata($arg) {
        $_SESSION['sicodo'] = $arg;
    }

    public static function userdata($arg = '') {
        if ($arg == '') {
            return $_SESSION['sicodo'];
        } else {
            return $_SESSION['sicodo'][$arg];
        }
    }

    public static function logout() {
        session_destroy();
        redirect();
    }

    public static function logged_in() {
        if (!sesiones::is_logged_in()) {
            redirect('sesiones');
        }
    }

    public static function is_logged_in() {
        return sesiones::userdata('status') === 'activo';
    }

    public static function is_has_permission($p) {
        $db = new base();
        $qry = "
          select 1
          from usuarios a
          inner join roles b on b.id=a.rol_fkey
          inner join roles_permisos c on c.rol_fkey=b.id
          inner join permisos d on d.id=c.permiso_fkey
          and lower(permiso)=(select lower(permiso) from permisos where permiso='$p' and status='activo')
          and a.id=" . sesiones::userdata('id');
        if (!$db->db_query($qry)) {
            return FALSE;
        } elseif ($db->db_num_rows() == 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public static function has_permission($p) {
        if (!sesiones::is_has_permission($p)) {
            redirect();
        }
    }

}

?>