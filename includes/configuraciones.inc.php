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

    public static function total_dias_laborables() {
        return 7;
    }

    public static function es_hora_laborable($timestamp) {
        $turno1 = array(8, 9, 10, 11, 14, 15, 16);
        $turno2 = '';
        if (in_array(date('G', $timestamp), $turno1)) {

            return TRUE;
        }
        return FALSE;
    }

    public static function es_dia_laborable($timestamp) {
        $feriados = array(
            '24-06',
            '05-07'
        );
        // 0: Domingo ; 6: Sábado
        if (date('w', $timestamp) == 0 || date('w', $timestamp) == 6) {
            return FALSE;
        } elseif (in_array(date('d-m', $timestamp), $feriados)) {
            return FALSE;
        }
        return TRUE;
    }

    public static function sumar_horas($timestamp, $horas) {
        $seg_x_hora = 3600;
        $i = 0;
        while ($i < $horas) {
            $timestamp+=$seg_x_hora;
            if (configuraciones::es_hora_laborable($timestamp)) {
                if (configuraciones::es_dia_laborable($timestamp)) {
                    $i++;
                }
            }
        }
        return $timestamp;
    }

    public static function diferencia_en_responder($movimiento, $respuesta) {
        $seg_x_hora = 3600;
        $i = 0;
        if ($movimiento < $respuesta) {
            while ($movimiento < $respuesta) {
                $movimiento+=$seg_x_hora;
                if (configuraciones::es_hora_laborable($movimiento)) {
                    if (configuraciones::es_dia_laborable($movimiento)) {
                        $i++;
                    }
                }
            }
            $i = $i * -1;
        } elseif ($movimiento > $respuesta) {
            while ($respuesta < $movimiento) {
                $respuesta+=$seg_x_hora;
                if (configuraciones::es_hora_laborable($respuesta)) {
                    if (configuraciones::es_dia_laborable($respuesta)) {
                        $i++;
                    }
                }
            }
        }

        /*
         */
        return $i;
    }

}

?>
