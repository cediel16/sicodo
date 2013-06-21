<?php

class usuarios {

    public static function add($data) {
        $db = new base();
        $data['usuario'] = $data['email'];
        $data['clave'] = md5($data['clave1']);
        $data['rol_fkey'] = $data['rol'];
        unset($data['clave1']);
        unset($data['clave2']);
        unset($data['rol']);
        return $db->db_insert('usuarios', $data) === 1;
    }

    public static function edit($data) {
        $db = new base();
        $id = $data['id'];
        $data['rol_fkey'] = $data['rol'];
        unset($data['id']);
        unset($data['rol']);
        return $db->db_update('usuarios', $data, "id=" . $id) === 1;
    }

    public static function cambiar_status($usuario_id, $status) {
        $db = new base();
        return $db->db_update('usuarios', array('status' => $status), "id=" . $usuario_id) === 1;
    }

    public static function cambiar_clave($usuario_id, $clave) {
        $db = new base();
        return $db->db_update('usuarios', array('clave' => md5($clave)), "id=" . $usuario_id) === 1;
    }

    public static function lista($filtro = '') {
        if ($filtro == 'activos' || $filtro == 'inactivos' || $filtro == 'bloqueados') {
            $where = str_replace(array('activos', 'inactivos', 'bloqueados'), array('activo', 'inactivo', 'bloqueado'), "and a.status='$filtro'");
        } elseif (is_numeric($filtro)) {
            $where = 'and b.id=' . $filtro;
        }
        $db = new base();
        $qry = "select a.id as usuario_id,a.nombre,b.rol,a.status
            from usuarios a
            inner join roles b on b.id=a.rol_fkey
            $where
            order by nombre";
        $db->db_query($qry);
        $r.='<table class="table table-bordered table-hover">';
        $r.='<thead>';
        $r.='<tr>';
        $r.='<th class="span1">Id</th>';
        $r.='<th>Nombre</th>';
        $r.='<th>Rol</th>';
        $r.='<th class="span1">Status</th>';
        $r.='<th class="span1">Acciones</th>';
        $r.='</tr>';
        $r.='</thead>';
        $r.='<tbody>';
        while (!$db->eof) {
            $r.='<tr>';
            $r.='<td>';
            $r.=$db->fields['usuario_id'];
            $r.='</td>';
            $r.='<td>';
            $r.=$db->fields['nombre'];
            $r.='</td>';
            $r.='<td>';
            $r.=$db->fields['rol'];
            $r.='</td>';
            $r.='<td>';
            switch ($db->fields['status']) {
                case 'activo':
                    $r.=status('info', $db->fields['status']);
                    break;
                case 'bloqueado':
                    $r.=status('warning', $db->fields['status']);
                    break;
                case 'inactivo':
                    $r.=status('important', $db->fields['status']);
                    break;
            }
            $r.='</td>';
            $r.='<td>';
            if (sesiones::is_has_permission('usuarios.editar') || sesiones::is_has_permission('usuarios.activar') || sesiones::is_has_permission('usuarios.desactivar') || sesiones::is_has_permission('usuarios.bloquear')) {
                $r.='<div class="btn-group pull-right">';
                $r.='<button data-toggle="dropdown" class="btn btn-mini dropdown-toggle">Acciones <span class="caret"></span></button>';
                $r.='<ul class="dropdown-menu">';
                if (sesiones::is_has_permission('usuarios.editar')) {
                    $r.='<li><a href="' . site_url() . '/usuarios/edit.php?var=' . $db->fields['usuario_id'] . '">Editar</a></li>';
                }
                if (sesiones::is_has_permission('usuarios.activar')) {
                    $r.='<li><a href = "javascript:void(0);" onclick = "activar(' . $db->fields['usuario_id'] . ')">Activar</a></li>';
                }
                if (sesiones::is_has_permission('usuarios.desactivar')) {
                    $r.='<li><a href = "javascript:void(0);" onclick = "desactivar(' . $db->fields['usuario_id'] . ')">Desactivar</a></li>';
                }
                if (sesiones::is_has_permission('usuarios.bloquear')) {
                    $r.='<li><a href = "javascript:void(0);" onclick = "bloquear(' . $db->fields['usuario_id'] . ')">Bloquear</a></li>';
                }
                /*


                 * 
                 */
                $r.='</ul>';
                $r.='</div>';
            }
            $r.='</td>';
            $r.='</tr>';
            $db->db_move_next();
        }
        $r.='</tbody>';
        $r.='</table>';
        return $r;
    }

    public static function esta_cedula_disponible($arg) {
        if ($arg == '')
            return FALSE;
        $db = new base();
        $db->db_query("
        select 1
        from usuarios 
        where cedula='$arg'
        ");
        return count($db->data) == 0;
    }

    public static function esta_cedula_disponible_al_editar($id, $ci) {
        if ($ci == '')
            return FALSE;
        $db = new base();
        $db->db_query("
    select 1
    from usuarios 
    where cedula='$ci'
    and id<>$id
    ");
        return count($db->data) == 0;
    }

    public static function esta_email_disponible($arg) {
        if ($arg == '')
            return FALSE;
        $db = new base();
        $db->db_query("
    select 1
    from usuarios 
    where email='$arg'
    ");
        return count($db->data) == 0;
    }

    public static function esta_email_disponible_al_editar($id, $email) {
        if ($email == '')
            return FALSE;
        $db = new base();
        $db->db_query("
    select 1
    from usuarios 
    where email='$email'
    and id<>$id
    ");
        return count($db->data) == 0;
    }

    public static function obtener_fila($id) {
        $db = new base();
        $db->db_query("
        select a.*,
        b.rol
        from usuarios a
        inner join roles b on b.id=a.rol_fkey    
        where a.id=$id
        ");
        return $db->data[0];
    }

    public static function obtener_filas() {
        $db = new base();
        $db->db_query("
            select *
            from usuarios 
            order by nombre
        ");
        return $db->data;
    }

    public static function obtener_lista_roles_para_filtrar() {
        $db = new base();
        $db->db_query("select distinct(id),rol from roles where id in (select rol_fkey from usuarios)");
        return $db->data;
    }

}

?>
