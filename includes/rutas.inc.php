<?php

class rutas {

    public static function add($data) {
        $db = new base();
        return $db->db_insert('rutas', $data) === 1;
    }

    public static function del($ruta_id) {
        if (!is_numeric($ruta_id)) {
            return FALSE;
        }

        $db = new base();
        if (!$db->db_query('BEGIN')) {
            return FALSE;
        }

        if (!$db->db_query("delete from estaciones where ruta_fkey=$ruta_id")) {
            $db->db_query('ROLLBACK');
            return FALSE;
        }

        if (!$db->db_query("delete from rutas where id=$ruta_id")) {
            $db->db_query('ROLLBACK');
            return FALSE;
        }
        $db->db_query('COMMIT');
        return TRUE;
    }

    public static function edit($data) {
        $db = new base();
        return $db->db_update('rutas', array('ruta' => $data['ruta']), "id='" . $data['id'] . "'") === 1;
    }

    public static function lista() {
        $db = new base();
        $db->db_query("
            select *,
            (select count(1) from estaciones where ruta_fkey=rutas.id) as estaciones,           
            (select sum(horas) from estaciones where ruta_fkey=rutas.id) as horas,
            round(cast ((select sum(horas) from estaciones where ruta_fkey=rutas.id) as numeric(10,2))/24,2) as dias
            from rutas 
            order by ruta
        ");
        $r.='<table class="table table-bordered table-hover">';
        $r.='<thead>';
        $r.='<tr><th>Rutas de documentos</th>';
        $r.='<th>Estaciones</th>';
        $r.='<th>Tiempo</th>';
        if (sesiones::is_has_permission('rutas.editar') || sesiones::is_has_permission('rutas.eliminar')) {
            $r.='<th class="span1"></th>';
        }
        $r.='</tr>';
        $r.='</thead>';
        $r.='<tbody>';
        while (!$db->eof) {
            $r.='<tr>';
            $r.='<td>';
            $r.=$db->fields['ruta'];
            $r.='</td>';
            $r.='<td>';
            $r.=$db->fields['estaciones'];
            $r.='</td>';
            $r.='<td>';
            $r.=$db->fields['horas'] . ' horas (' . $db->fields['dias'] . ' días)';
            $r.='</td>';
            if (sesiones::is_has_permission('rutas.editar') || sesiones::is_has_permission('rutas.eliminar')) {
                $r.='<td>';
                $r.='<div class="btn-group pull-right">';
                $r.='<button data-toggle="dropdown" class="btn btn-mini dropdown-toggle">Acciones <span class="caret"></span></button>';
                $r.='<ul class="dropdown-menu">';
                if (sesiones::is_has_permission('rutas.editar')) {
                    $r.='<li><a href="' . site_url() . '/rutas/edit.php?var=' . $db->fields['id'] . '">Editar</a></li>';
                }
                if (sesiones::is_has_permission('rutas.eliminar')) {
                    $r.='<li><a href="javascript:void(0);" onclick="del(' . $db->fields['id'] . ')">Eliminar</a></li>';
                }
                $r.='</ul>';
                $r.='</div>';
                $r.='</td>';
            }
            $r.='</tr>';
            $db->db_move_next();
        }
        $r.='</tbody>';
        $r.='</table>';
        return $r;
    }

    public static function esta_ruta_disponible($arg) {
        $db = new base();
        $db->db_query("
select 1
from rutas 
where ruta='$arg'
");
        return count($db->data) == 0;
    }

    public static function esta_ruta_disponible_al_editar($id, $ruta) {
        $db = new base();
        $db->db_query("
select 1
from rutas 
where ruta='$ruta'
and id<>$id
");
        return count($db->data) == 0;
    }

    public static function obtener_fila($id) {
        $db = new base();
        $db->db_query("
select *
from rutas 
where id=$id
");
        return $db->data[0];
    }

    public static function obtener_filas() {
        $db = new base();
        $db->db_query("
            select *
            from rutas 
            order by ruta
            
        ");
        return $db->data;
    }

    public static function obtener_filas_activas() {
        $db = new base();
        $db->db_query("
            select *
            from rutas 
            where status='activo'
            and bloqueado='si'
            order by ruta
        ");
        return $db->data;
    }

}

?>
