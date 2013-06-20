<?php

class roles {

    public static function add($data) {
        $db = new base();
        return $db->db_insert('roles', $data) === 1;
    }

    public static function edit($data) {
        $db = new base();
        return $db->db_update('roles', array('rol' => $data['rol']), "id='" . $data['id'] . "'") === 1;
    }

    public static function del($rol_id) {
        $db = new base();
        return $db->db_update('roles', array('status' => 'eliminado'), "id='" . $rol_id . "'") === 1;
    }

    public static function act($rol_id) {
        $db = new base();
        return $db->db_update('roles', array('status' => 'activo'), "id='" . $rol_id . "'") === 1;
    }

    public static function lista() {
        $db = new base();
        $db->db_query("
            select *
            from roles
            order by status,rol
        ");
        $r.='<table class="table table-bordered table-hover">';
        $r.='<thead>';
        $r.='<tr>';
        $r.='<th>Rol</th>';
        $r.='<th class="span1">Status</th>';
        $r.='<th class="span1">Acciones</th>';
        $r.='</tr>';
        $r.='</thead>';
        $r.='<tbody>';
        while (!$db->eof) {
            $r.='<tr>';
            $r.='<td>';
            $r.=$db->fields['rol'];
            $r.='</td>';
            $r.='<td>';
            switch ($db->fields['status']) {
                case 'activo':
                    $r.=status('info', $db->fields['status']);
                    break;
                case 'eliminado':
                    $r.=status('important', $db->fields['status']);
                    break;
                case 'default':
                    $r.=status('default', $db->fields['status']);
                    break;
            }
            $r.='</td>';
            $r.='<td>';
            $r.='<div class="btn-group pull-right">';
            $r.='<button data-toggle="dropdown" class="btn btn-mini dropdown-toggle">Acciones <span class="caret"></span></button>';
            $r.='<ul class="dropdown-menu">';
            if (sesiones::is_has_permission('roles.permisos')) {
                $r.='<li><a href="' . site_url() . '/roles/edit.php?var=' . $db->fields['id'] . '">Editar</a></li>';
            }
            if ($db->fields['status'] == 'activo') {
                if (sesiones::is_has_permission('roles.permisos')) {
                    $r.='<li><a href="' . site_url() . '/roles/permisos.php?var=' . $db->fields['id'] . '">Gestionar permisos</a></li>';
                }
                if (sesiones::is_has_permission('roles.eliminar')) {
                    $r.='<li><a href="javascript:void(0);" onclick="javascript:del(' . $db->fields['id'] . ');">Eliminar</a></li>';
                }
            } elseif ($db->fields['status'] == 'eliminado') {
                if (sesiones::is_has_permission('roles.activar')) {
                    $r.='<li><a href="javascript:void(0);" onclick="javascript:act(' . $db->fields['id'] . ');">Activar</a></li>';
                }
            }
            $r.='</ul>';
            $r.='</div>';
            $r.='</td>';
            $r.='</tr>';
            $db->db_move_next();
        }
        /*
          <tr>
          <td>
          </td>
          </tr>
         */
        $r.='</tbody>';
        $r.='</table>';
        return $r;
    }

    public static function lista_permisos($rol_id) {
        $db = new base();
        $db->db_query("
            select *
            from permisos
            order by permiso
        ");
        $r.='<table class="table table-bordered table-hover">';
        $r.='<thead>';
        $r.='<tr>';
        $r.='<th class="span3">Permiso</th>';
        $r.='<th>Descripción</th>';
        $r.='<th class="span1">Asignación</th>';
        $r.='</tr>';
        $r.='</thead>';
        $r.='<tbody>';
        while (!$db->eof) {
            $r.='<tr>';
            $r.='<td>';
            $r.=$db->fields['permiso'];
            $r.='</td>';
            $r.='<td>';
            $r.=$db->fields['descripcion'];
            $r.='</td>';
            $r.='<td>';
            $r.='<div class="pull-center">';
            if (roles::esta_permiso_asignado($rol_id, $db->fields['id'])) {
                $chkd = 'checked';
            } else {
                $chkd = '';
            }

            $r.='<input ' . $chkd . ' type="checkbox" rel="' . $rol_id . '" value="' . $db->fields['id'] . '" />';
            $r.='</div>';
            $r.='</td>';
            $r.='</tr>';
            $db->db_move_next();
        }
        $r.='</tbody>';
        $r.='</table>';
        return $r;
    }

    public static function asignar_permiso($rol_id, $permiso_id) {
        $db = new base();
        if (!roles::esta_permiso_asignado($rol_id, $permiso_id)) {
            return $db->db_insert('roles_permisos', array('rol_fkey' => $rol_id, 'permiso_fkey' => $permiso_id)) === 1;
        }
        return 0;
    }

    public static function quitar_permiso($rol_id, $permiso_id) {
        $db = new base();
        return $db->db_delete('roles_permisos', "rol_fkey=$rol_id and permiso_fkey=$permiso_id") === 1;
    }

    public static function esta_permiso_asignado($rol_fkey, $permiso_fkey) {
        $db = new base();
        $qry = "select 1 from roles_permisos where rol_fkey=$rol_fkey and permiso_fkey=$permiso_fkey";
        if (!$db->db_query($qry)) {
            return FALSE;
        } else {
            return count($db->data) == 1;
        }
    }

    public static function esta_cedula_disponible($arg) {
        if ($arg == '')
            return FALSE;
        $db = new base();
        $db->db_query("
                select 1
                from usuarios
                where cedula = '$arg'
                ");
        return count($db->data) == 0;
    }

    public static function esta_email_disponible(
    $arg) {
        if ($arg == '')
            return FALSE;
        $db = new base();
        $db->db_query("
                select 1
                from usuarios
                where email = '$arg'
                ");
        return count($db->data) == 0;
    }

    public static function esta_rol_disponible(
    $rol) {
        if ($rol == '')
            return FALSE;
        $db = new base();
        $db->db_query("
                select 1
                from roles
                where lower(rol) = '" . strtolower($rol) . "'
                ");
        return count($db->data) == 0;
    }

    public static function esta_rol_disponible_al_editar(
    $id, $rol) {
        if ($rol == '')
            return FALSE;
        $db = new base();
        $db->db_query("
                select 1
                from roles
                where lower(rol) = '" . strtolower($rol) . "'
                and id<>$id
                ");
        return count($db->data) == 0;
    }

    public static function obtener_fila(
    $id) {
        $db = new base();
        $db->db_query("
                select *
                from roles
                where id = $id
                ");
        return $db->data[0];
    }

    public static function obtener_filas() {




        $db = new base();
        $db->db_query("
                select *
                from roles
                order by rol
                ");
        return $db->data;
    }

}

?>
