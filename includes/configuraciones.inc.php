<?php

class configuraciones {

    public static function get($var = '') {
        $db = new base();
        $qry = "select *
            from configuraciones 
            order by id limit 1";
        $db->db_query($qry);

        return $db->data['0'][$var];
    }

    public static function check_dia_laborable($dia) {
        return in_array($dia, explode(':', configuraciones::get('dias_laborables')));
    }

    public static function edit($data) {
        $db = new base();
        return $db->db_update('cargos', array('cargo' => $data['cargo']), "id='" . $data['id'] . "'") === 1;
    }

    public static function lista() {
        $db = new base();
        $r.='<table class="table table-bordered table-hover">';
        $r.='<thead>';
        $r.='<tr><th>Cargos</th></tr>';
        $r.='</thead>';
        $r.='<tbody>';
        while (!$db->eof) {
            $r.='<tr>';
            $r.='<td>';
            if (sesiones::is_has_permission('cargos.editar')) {
                $r.='<a href="' . site_url() . '/cargos/edit.php?var=' . $db->fields['id'] . '">' . $db->fields['cargo'] . '</a>';
            } else {
                $r.=$db->fields['cargo'];
            }
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

    public static function esta_cargo_disponible($arg) {
        $db = new base();
        $db->db_query("
    select 1
    from cargos 
    where cargo='$arg'
    ");
        return count($db->data) == 0;
    }

    public static function esta_cargo_disponible_al_editar($id, $cargo) {
        $db = new base();
        $db->db_query("
    select 1
    from cargos 
    where cargo='$cargo'
    and id<>$id
    ");
        return count($db->data) == 0;
    }

    public static function obtener_fila($id) {
        $db = new base();
        $db->db_query("
            select *
            from cargos 
            where id=$id
        ");
        return $db->data[0];
    }

    public static function obtener_filas() {
        $db = new base();
        $db->db_query("
            select *
            from cargos 
            order by cargo
        ");
        return $db->data;
    }

}

?>
