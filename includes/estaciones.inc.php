<?php

class estaciones {

    public static function add($data) {
        $db = new base();
        return $db->db_insert('estaciones', $data) === 1;
    }

    public static function edit($estacion_id, $data) {
        $db = new base();
        return $db->db_update('estaciones', $data, "id=" . $estacion_id) === 1;
    }

    public static function del($estacion_id) {
        $db = new base();
        return $db->db_delete('estaciones', "id=" . $estacion_id) === 1;
    }

    public static function lista_por_ruta($ruta) {
        if (!is_numeric($ruta))
            return '';
        $db = new base();
        $db->db_query("
            select a.id as estacion_id,
            a.orden,
            a.horas,
            a.descripcion,
            b.unidad,
            c.cargo,
            d.nombre as responsable
            from estaciones a
            inner join unidades b on b.id=a.unidad_fkey
            inner join cargos c on c.id=a.cargo_fkey
            inner join usuarios d on d.id=a.usuario_fkey
            and a.ruta_fkey=$ruta
            order by orden
        ");
        $r.='<table class="table table-bordered table-hover">';
        $r.='<thead>';
        $r.='<tr>
                <th class="span1">Orden</th>
                <th class="span1">Horas</th>
                <th class="span2">Unidad</th>
                <th class="span2">Cargo</th>
                <th class="span2" >Responsable</th>
                <th class="span3">Descripción del paso</th>
                <th class="span1">Acción</th>
                </tr>';
        $r.='</thead>';
        $r.='<tbody>';
        while (!$db->eof) {
            $r.='<tr>';
            $r.='<td>';
            $r.=$db->fields['orden'];
            $r.='</td>';
            $r.='<td>';
            $r.=$db->fields['horas'];
            $r.='</td>';
            $r.='<td>';
            $r.=$db->fields['unidad'];
            $r.='</td>';
            $r.='<td>';
            $r.=$db->fields['cargo'];
            $r.='</td>';
            $r.='<td>';
            $r.=$db->fields['responsable'];
            $r.='</td>';
            $r.='<td>';
            $r.=$db->fields['descripcion'];
            $r.='</td>';
            $r.='<td>';
            $r.='<div class="btn-group pull-right">
                <button data-toggle="dropdown" class="btn btn-mini dropdown-toggle">Acciones <span class="caret"></span></button>
                <ul class="dropdown-menu">
                  <li><a href="javascript:void(0);" onclick="javascript:edit(' . $db->fields['estacion_id'] . ');">Editar</a></li>
                  <li><a href="javascript:void(0);" onclick="javascript:del(' . $db->fields['estacion_id'] . ');">Eliminar</a></li>
                </ul>
              </div>';
            $r.='</td>';
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
        $db->fields_option['assoc'];
        $db->db_query("
            select *
            from estaciones 
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

}

?>
