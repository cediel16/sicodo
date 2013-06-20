<?php

function valid_login() {
    return $_SESSION['logged'];
}

function menu_centros() {
    $db_mp = new base();
    $db_pq = new base();
    $db_ce = new base();
    if ($_SESSION['grupo'] == 'maestro') {
        $where_usr = '';
    } elseif ($_SESSION['grupo'] == 'operador') {
        $where_usr = "and cod_centro in (select cod_centro from centros_operadores where usuario_id=" . $_SESSION['id'] . ")";
    } elseif ($_SESSION['grupo'] == 'jefe de operacion') {
        $where_usr = "and cod_centro in (select cod_centro from centros_operadores a inner join usuarios b on b.id=a.usuario_id and b.jefe_id=" . $_SESSION['id'] . ")";
    } else {
        //return;
    }


    $qry = "select 
        distinct(municipio),
        cast(cod_municipio as integer) as cod_municipio
        from centros
        where 1=1
        $where_usr
        order by cod_municipio";
    $db_mp->db_query($qry);
    $r = '<section id="treeview">';
    while (!$db_mp->eof) {
        $r.='<article>';
        $r.='<input type="checkbox" checked class="treeview" id="item_mp' . $db_mp->fields['cod_municipio'] . '" /><label for="item_mp' . $db_mp->fields['cod_municipio'] . '">' . $db_mp->fields['municipio'] . '</label>';
        $qry = "select 
            distinct(parroquia),
            cast(cod_parroquia as integer) as cod_parroquia
            from centros
            where cod_municipio='" . $db_mp->fields['cod_municipio'] . "'
            $where_usr
            order by cod_parroquia";
        $db_pq->db_query($qry);
        while (!$db_pq->eof) {
            $r.='<article>';
            $r.='<input type="checkbox" checked class="treeview" id="item_mp' . $db_mp->fields['cod_municipio'] . '_pq' . $db_pq->fields['cod_parroquia'] . '" /><label for="item_mp' . $db_mp->fields['cod_municipio'] . '_pq' . $db_pq->fields['cod_parroquia'] . '">' . $db_pq->fields['parroquia'] . '</label>';
            $qry = "select
               distinct(cod_centro) as cod_centro,
               centro
               from centros
               where cod_municipio='" . $db_mp->fields['cod_municipio'] . "'
               and cod_parroquia='" . $db_pq->fields['cod_parroquia'] . "'
               $where_usr
               order by cod_centro";

            $db_ce->db_query($qry);
            while (!$db_ce->eof) {
                $r.='<article class="centro" onclick="get_info(\'' . $db_ce->fields['cod_centro'] . '\')">' . $db_ce->fields['cod_centro'] . ' - ' . $db_ce->fields['centro'] . '</article>';
                $db_ce->db_move_next();
            }
            $r.='</article>';
            $db_pq->db_move_next();
        }
        $db_mp->db_move_next();
        $r.='</article>';
    }
    $r.='</section>';
    return $r;
}

function formulario($cod_centro) {
    $db = new base();
    $qry = "select estado,municipio,parroquia,cod_centro,centro from centros where cod_centro='$cod_centro'";
    $db->db_query($qry);
    $r = '<div class="big-form">';
    
    $r.= '<div style="height:35px;">';
    $r.='<div style="float:left;">';
    $r.='<div style="font-size:10px; font-weight:bold;">' . $db->fields['estado'] . ' / ' . $db->fields['municipio'] . ' / ' . $db->fields['parroquia'] . '</div>';
    $r.='<div style="font-size:16px; font-weight:bold;">' . $db->fields['cod_centro'] . ' - ' . $db->fields['centro'] . '</div>';
    $r.='</div>';
    $r.='<div style="float:right;"><a href="http://172.17.40.90/text/?cod_centro='.$cod_centro.'" onclick="javascript:popup(this.href,\'390\',\'600\'); return false;"><img src="img/sms.png"></a></div>';    
    $r.='</div>';
    
    $r.= '<table>';
    $r.='<thead>';
    $r.='<tbody>';
    $r.='<tr>';
    $r.='<th colspan="6">';
    $r.='Miembros de la UBC';
    $r.='</th>';
    $r.='</tr>';
    $r.='<tr>';
    $r.='<th>';
    $r.='Cargo';
    $r.='</th>';
    $r.='<th>';
    $r.='Cédula';
    $r.='</th>';
    $r.='<th>';
    $r.='Nombre';
    $r.='</th>';
    $r.='<th>';
    $r.='Teléfono';
    $r.='</th>';
    $r.='<th>';
    $r.='Status';
    $r.='</th>';
    $r.='<th>';
    $r.='Acción';
    $r.='</th>';
    $r.='</tr>';
    $r.='</tbody>';
    $r.='</thead>';
    $qry = "select a.id as ubc_id,
        b.cargo_ubc,
        a.cedula,
        a.nombre,
        a.telefono,
        c.asis
        from ubc a
        inner join cargos_ubc b on b.id=a.cargo_ubc_id
        inner join ubc_incidencias c on c.ubc_id=a.id
        and a.cod_centro='$cod_centro'
        order by b.id";
    $db->db_query($qry);
    $n = 1;
    while (!$db->eof) {
        if ($db->fields['asis'] == '1') {
            $chkd_asis1 = 'checked';
            $chkd_asis0 = '';
        } elseif ($db->fields['asis'] == '0') {
            $chkd_asis1 = '';
            $chkd_asis0 = 'checked';
        } else {
            $chkd_asis1 = '';
            $chkd_asis0 = '';
        }

        $r.='<tr>';
        $r.='<td>';
        $r.=$db->fields['cargo_ubc'];
        $r.='</td>';
        $r.='<td align="right">';
        $r.=$db->fields['cedula'];
        $r.='</td>';
        $r.='<td>';
        $r.=$db->fields['nombre'];
        $r.='</td>';
        $r.='<td align="center" nowrap="nowrap">';
        /*
          if(is_numeric($db->fields['telefono']) && strlen($db->fields['telefono'])==10){
          $tlf=  substr($db->fields['telefono'], 0,3).' '.substr($db->fields['telefono'], 3,3).' '.substr($db->fields['telefono'], 6,2).' '.substr($db->fields['telefono'], 8,2);
          }else{
          $tlf='';
          }
         * */
        $r.='<span style="font-size:16px;">' . $db->fields['telefono'] . '</span>';
        $r.='</td>';
        $r.='<td align="center">';
        $r.='<ul>';
        $r.='<li><input type="radio" id="ubc_asis_' . $n . '_1" name="ubc_asis_' . $n . '" ' . $chkd_asis1 . ' onclick="cambiar_ubc_asis(\'' . $db->fields['ubc_id'] . '\',1);"><span>Presente</span></li>';
        $r.='<li><input type="radio" id="ubc_asis_' . $n . '_0" name="ubc_asis_' . $n . '" ' . $chkd_asis0 . ' onclick="cambiar_ubc_asis(\'' . $db->fields['ubc_id'] . '\',0);"><span>Ausente</span></li>';
        $r.='</ul>';
        $r.='</td>';
        $r.='<td align="center">';
        $r.='<input type="button" value="Editar" onclick="dialog_editar_ubc(\'' . $db->fields['ubc_id'] . '\',\'' . $cod_centro . '\');">';
        $r.='</td>';
        $r.='</tr>';
        $n++;
        $db->db_move_next();
    }
    $r.='</tbody>';
    $r.='</table>';
    $r.='</br>';

    $qry_ce = "select * from centros_incidencias where cod_centro='$cod_centro'";
    $db->db_query($qry_ce);

    if ($db->fields['apertura'] == '1') {
        $chkd_ce_apertura1 = 'checked';
        $chkd_ce_apertura0 = '';
    } elseif ($db->fields['apertura'] == '0') {
        $chkd_ce_apertura1 = '';
        $chkd_ce_apertura0 = 'checked';
    } else {
        $chkd_ce_apertura1 = '';
        $chkd_ce_apertura0 = '';
    }

    if ($db->fields['hidratacion'] == '1') {
        $chkd_ce_hidratacion1 = 'checked';
        $chkd_ce_hidratacion0 = '';
    } elseif ($db->fields['hidratacion'] == '0') {
        $chkd_ce_hidratacion1 = '';
        $chkd_ce_hidratacion0 = 'checked';
    } else {
        $chkd_ce_hidratacion1 = '';
        $chkd_ce_hidratacion0 = '';
    }

    if ($db->fields['alimentacion'] == '1') {
        $chkd_ce_alimentacion1 = 'checked';
        $chkd_ce_alimentacion0 = '';
    } elseif ($db->fields['alimentacion'] == '0') {
        $chkd_ce_alimentacion1 = '';
        $chkd_ce_alimentacion0 = 'checked';
    } else {
        $chkd_ce_alimentacion1 = '';
        $chkd_ce_alimentacion0 = '';
    }

    if ($db->fields['tarjetas'] == '1') {
        $chkd_ce_tarjetas1 = 'checked';
        $chkd_ce_tarjetas0 = '';
    } elseif ($db->fields['tarjetas'] == '0') {
        $chkd_ce_tarjetas1 = '';
        $chkd_ce_tarjetas0 = 'checked';
    } else {
        $chkd_ce_tarjetas1 = '';
        $chkd_ce_tarjetas0 = '';
    }

    if ($db->fields['vehiculos'] == '1') {
        $chkd_ce_vehiculos1 = 'checked';
        $chkd_ce_vehiculos0 = '';
    } elseif ($db->fields['vehiculos'] == '0') {
        $chkd_ce_vehiculos1 = '';
        $chkd_ce_vehiculos0 = 'checked';
    } else {
        $chkd_ce_vehiculos1 = '';
        $chkd_ce_vehiculos0 = '';
    }

    for ($i = 0; $i <= 20; $i++) {
        if ($i == $db->fields['posicionamiento']) {
            $sltd = 'selected';
        } else {
            $sltd = '';
        }
        $pos.='<option ' . $sltd . ' value="' . $i . '">' . $i . '</option>';
    }

    $r.='<table>';
    $r.='<tr>';
    $r.='<td align="center" nowrap="wrap">';
    $r.='<b>Posicionamiento de militacia<br>en cola</b>';
    $r.='</td>';
    $r.='<td align="center">';
    $r.='<b>Apertura de centro</b>';
    $r.='</td>';
    $r.='<td align="center">';
    $r.='<b>Evaluación de los vehículos</b>';
    $r.='</td>';
    $r.='<td align="center">';
    $r.='<b>Logistica: hidratación</b>';
    $r.='</td>';
    $r.='<td align="center">';
    $r.='<b>Logistica: alimentación</b>';
    $r.='</td>';
    $r.='<td align="center">';
    $r.='<b>Logistica: tarjetas telefónicas</b>';
    $r.='</td>';
    $r.='</tr>';
    $r.='<tr>';
    $r.='<td align="center">';
    $r.='<select onchange="cambiar_ce_posicionamiento(\'' . $db->fields['id'] . '\',this.value);">' . $pos . '</select>';
    $r.='</td>';
    $r.='<td>';
    $r.='<ul>';
    $r.='<li><input type="radio" name="ce_apertura" ' . $chkd_ce_apertura1 . ' onclick="cambiar_ce_apertura(\'' . $db->fields['id'] . '\',1);"><span>Sí</span></li>';
    $r.='<li><input type="radio" name="ce_apertura" ' . $chkd_ce_apertura0 . ' onclick="cambiar_ce_apertura(\'' . $db->fields['id'] . '\',0);"><span>No</span></li>';
    $r.='</ul>';
    $r.='</td>';
    $r.='<td>';
    $r.='<ul>';
    $r.='<li><input type="radio" name="ce_vehiculos" ' . $chkd_ce_vehiculos1 . ' onclick="cambiar_ce_vehiculos(\'' . $db->fields['id'] . '\',1);"><span>Positiva</span></li>';
    $r.='<li><input type="radio" name="ce_vehiculos" ' . $chkd_ce_vehiculos0 . ' onclick="cambiar_ce_vehiculos(\'' . $db->fields['id'] . '\',0);"><span>Negativa</span></li>';
    $r.='</ul>';
    $r.='</td>';
    $r.='<td>';
    $r.='<ul>';
    $r.='<li><input type="radio" name="ce_hidratacion" ' . $chkd_ce_hidratacion1 . ' onclick="cambiar_ce_hidratacion(\'' . $db->fields['id'] . '\',1);"><span>Sí</span></li>';
    $r.='<li><input type="radio" name="ce_hidratacion" ' . $chkd_ce_hidratacion0 . ' onclick="cambiar_ce_hidratacion(\'' . $db->fields['id'] . '\',0);"><span>No</span></li>';
    $r.='</ul>';
    $r.='</td>';
    $r.='<td>';
    $r.='<ul>';
    $r.='<li><input type="radio" name="ce_alimentacion" ' . $chkd_ce_alimentacion1 . ' onclick="cambiar_ce_alimentacion(\'' . $db->fields['id'] . '\',1);"><span>Sí</span></li>';
    $r.='<li><input type="radio" name="ce_alimentacion" ' . $chkd_ce_alimentacion0 . ' onclick="cambiar_ce_alimentacion(\'' . $db->fields['id'] . '\',0);"><span>No</span></li>';
    $r.='</ul>';
    $r.='</td>';
    $r.='<td>';
    $r.='<ul>';
    $r.='<li><input type="radio" name="ce_tarjetas" ' . $chkd_ce_tarjetas1 . ' onclick="cambiar_ce_tarjetas(\'' . $db->fields['id'] . '\',1);"><span>Sí</span></li>';
    $r.='<li><input type="radio" name="ce_tarjetas" ' . $chkd_ce_tarjetas0 . ' onclick="cambiar_ce_tarjetas(\'' . $db->fields['id'] . '\',0);"><span>No</span></li>';
    $r.='</ul>';
    $r.='</td>';
    $r.='</tr>';
    $r.='</table>';
    $r.='<br>';
    $r.='<table>';
    $r.='<tr>';
    $r.='<th>';
    $r.='Mesa';
    $r.='</th>';
    $r.='<th>';
    $r.='Miembros OSI<br>(Operador de máquina)';
    $r.='</th>';
    $r.='<th>';
    $r.='Máquina de votación';
    $r.='</th>';
    $r.='<th>';
    $r.='Testigos de mesa';
    $r.='</th>';
    $r.='<th>';
    $r.='Mesa constituida';
    $r.='</th>';
    $r.='<th>';
    $r.='Transmisión de acta';
    $r.='</th>';
    $r.='</tr>';
    $qry_tm = "select * from tablamesa_incidencias a inner join tablamesa b on b.id=a.tablamesa_id and b.cod_centro='$cod_centro' order by b.mesa";
    $db->db_query($qry_tm);
    while (!$db->eof) {
        $tes = '';

        for ($i = 0; $i <= 5; $i++) {
            if ($i == $db->fields['testigos']) {
                $sltd = 'selected';
            } else {
                $sltd = '';
            }
            $tes.='<option ' . $sltd . ' value="' . $i . '">' . $i . '</option>';
        }

        if ($db->fields['osi'] == '1') {
            $chkd_tablamesa_osi1 = 'checked';
            $chkd_tablamesa_osi0 = '';
        } elseif ($db->fields['osi'] == '0') {
            $chkd_tablamesa_osi1 = '';
            $chkd_tablamesa_osi0 = 'checked';
        } else {
            $chkd_tablamesa_osi1 = '';
            $chkd_tablamesa_osi0 = '';
        }

        if ($db->fields['maquina'] == '1') {
            $chkd_tablamesa_maquina1 = 'checked';
            $chkd_tablamesa_maquina0 = '';
        } elseif ($db->fields['maquina'] == '0') {
            $chkd_tablamesa_maquina1 = '';
            $chkd_tablamesa_maquina0 = 'checked';
        } else {
            $chkd_tablamesa_maquina1 = '';
            $chkd_tablamesa_maquina0 = '';
        }

        if ($db->fields['constituida'] == '1') {
            $chkd_tablamesa_constituida1 = 'checked';
            $chkd_tablamesa_constituida0 = '';
        } elseif ($db->fields['constituida'] == '0') {
            $chkd_tablamesa_constituida1 = '';
            $chkd_tablamesa_constituida0 = 'checked';
        } else {
            $chkd_tablamesa_constituida1 = '';
            $chkd_tablamesa_constituida0 = '';
        }

        if ($db->fields['transmision'] == '1') {
            $chkd_tablamesa_transmision1 = 'checked';
            $chkd_tablamesa_transmision0 = '';
        } elseif ($db->fields['transmision'] == '0') {
            $chkd_tablamesa_transmision1 = '';
            $chkd_tablamesa_transmision0 = 'checked';
        } else {
            $chkd_tablamesa_transmision1 = '';
            $chkd_tablamesa_transmision0 = '';
        }

        $r.='<tr>';
        $r.='<td align="center" width="10px">';
        $r.='<span style="font-size:18px; font-weight:bold;">' . $db->fields['mesa'] . '</span>';
        $r.='</td>';
        $r.='<td>';
        $r.='<ul>';
        $r.='<li><input type="radio" name="tablamesa_osi_' . $db->fields['mesa'] . '" ' . $chkd_tablamesa_osi1 . ' onclick="cambiar_tablamesa_osi(\'' . $db->fields['id'] . '\',1);"><span>Presente</span></li>';
        $r.='<li><input type="radio" name="tablamesa_osi_' . $db->fields['mesa'] . '" ' . $chkd_tablamesa_osi0 . ' onclick="cambiar_tablamesa_osi(\'' . $db->fields['id'] . '\',0);"><span>Ausente</span></li>';
        $r.='</ul>';
        $r.='</td>';
        $r.='<td>';
        $r.='<ul>';
        $r.='<li><input type="radio" name="tablamesa_maquina_' . $db->fields['mesa'] . '" ' . $chkd_tablamesa_maquina1 . ' onclick="cambiar_tablamesa_maquina(\'' . $db->fields['id'] . '\',1);"><span>Operativa</span></li>';
        $r.='<li><input type="radio" name="tablamesa_maquina_' . $db->fields['mesa'] . '" ' . $chkd_tablamesa_maquina0 . ' onclick="cambiar_tablamesa_maquina(\'' . $db->fields['id'] . '\',0);"><span>Inoperativa</span></li>';
        $r.='</ul>';
        $r.='</td>';
        $r.='<td align="center">';
        $r.='<ul>';
        $r.='<li>';
        $r.='<select onchange="cambiar_tablamesa_testigos(\'' . $db->fields['id'] . '\',this.value);">' . $tes . '</select>';
        $r.='</li>';
        $r.='</ul>';
        $r.='</td>';
        $r.='<td>';
        $r.='<ul>';
        $r.='<li><input type="radio" name="tablamesa_constituida_' . $db->fields['mesa'] . '" ' . $chkd_tablamesa_constituida1 . ' onclick="cambiar_tablamesa_constituida(\'' . $db->fields['id'] . '\',1);"><span>Sí</span></li>';
        $r.='<li><input type="radio" name="tablamesa_constituida_' . $db->fields['mesa'] . '" ' . $chkd_tablamesa_constituida0 . ' onclick="cambiar_tablamesa_constituida(\'' . $db->fields['id'] . '\',0);"><span>No</span></li>';
        $r.='</ul>';
        $r.='</td>';
        $r.='<td>';
        $r.='<ul>';
        $r.='<li><input type="radio" name="tablamesa_transmision_' . $db->fields['mesa'] . '" ' . $chkd_tablamesa_transmision1 . ' onclick="cambiar_tablamesa_transmision(\'' . $db->fields['id'] . '\',1);"><span>Sí</span></li>';
        $r.='<li><input type="radio" name="tablamesa_transmision_' . $db->fields['mesa'] . '" ' . $chkd_tablamesa_transmision0 . ' onclick="cambiar_tablamesa_transmision(\'' . $db->fields['id'] . '\',0);"><span>No</span></li>';
        $r.='</ul>';
        $r.='</td>';
        $r.='</tr>';
        $db->db_move_next();
    }
    $r.='</table>';

    /*
     * codigo_centro
     * mesa
     * 
     */
    $r.='</div>';
    return $r;
}

function patrulleros($cod_centro) {
    $db = new base();
    $qry = "select estado,municipio,parroquia,cod_centro,centro from centros where cod_centro='$cod_centro'";
    $db->db_query($qry);
    $r = '<div class="big-form">';
    $r.='<div style="font-size:10px; font-weight:bold;">' . $db->fields['estado'] . ' / ' . $db->fields['municipio'] . ' / ' . $db->fields['parroquia'] . '</div>';
    $r.='<div style="font-size:16px; font-weight:bold;">' . $db->fields['cod_centro'] . ' - ' . $db->fields['centro'] . '</div>';
    $r.='<div class="big-form">';
    $r.='<table width="100%">';
    $r.='<thead>';
    $r.='<tr>';
    $r.='<th align="center">N</th>';
    $r.='<th align="center" width="70">Cédula</th>';
    $r.='<th align="center">Nombre</th>';
    $r.='<th align="center" width="100">Teléfono</th>';
    $r.='<tr>';
    $r.='</thead>';
    $r.='<tbody>';
    $qry = "select *,cast(cedula as integer) as ci from patrulleros where cod_centro='$cod_centro' order by ci desc";
    $db->db_query($qry);
    $n = 1;
    while (!$db->eof) {
        $r.='<tr style="border-bottom:1px solid red;">';
        $r.='<td align="right">' . $n . '</td>';
        $r.='<td align="right">' . $db->fields['cedula'] . '</td>';
        $r.='<td>' . $db->fields['nombre'] . '</td>';
        $r.='<td align="center"><div style="font-size:16px;">' . $db->fields['telefono'] . '</div></td>';
        $r.='</tr>';
        $n++;
        $db->db_move_next();
    }
    $r.='';
    $r.='</tbody>';
    $r.='</table>';
    $r.='</div>';
    return $r;
}

function from_editar_cargo_ubc($id) {
    $qry = "select * 
        from ubc a 
        inner join centros b on b.cod_centro=a.cod_centro
        inner join cargos_ubc c on c.id=a.cargo_ubc_id
        and a.id=$id";
    $db = new base();
    $db->db_query($qry);
    $d = $db->fields;

    $r = '<table>';
    $r.='<tr>';
    $r.='<th align="left">';
    $r.='Código del centro';
    $r.='</th>';
    $r.='<td>';
    $r.='<input type="text" id="cod_centro" name="cod_centro" value="' . $d['cod_centro'] . '" readonly size="50px" />';
    $r.='</td>';
    $r.='</tr>';
    $r.='<tr>';
    $r.='<tr>';
    $r.='<th align="left">';
    $r.='Centro electoral';
    $r.='</th>';
    $r.='<td>';
    $r.='<input type="text" id="cargo" name="centro" value="' . $d['centro'] . '" readonly size="50px" />';
    $r.='</td>';
    $r.='</tr>';
    $r.='<th align="left">';
    $r.='Cargo';
    $r.='</th>';
    $r.='<td>';
    $r.='<input type="text" id="cargo" name="cargo" value="' . $d['cargo_ubc'] . '" readonly size="50px" />';
    $r.='</td>';
    $r.='</tr>';
    $r.='<tr>';
    $r.='<th align="left">';
    $r.='Cédula';
    $r.='</th>';
    $r.='<td>';
    $r.='<input type="text" id="cedula" name="cedula" value="' . $d['cedula'] . '" size="50px" />';
    $r.='</td>';
    $r.='</tr>';
    $r.='<tr>';
    $r.='<th align="left">';
    $r.='Nombre';
    $r.='</th>';
    $r.='<td>';
    $r.='<input type="text" id="nombre" name="nombre" value="' . $d['nombre'] . '" size="50px" />';
    $r.='</td>';
    $r.='</tr>';
    $r.='<tr>';
    $r.='<th align="left">';
    $r.='Teléfono';
    $r.='</th>';
    $r.='<td>';
    $r.='<input type="text" id="telefono" name="telefono" value="' . $d['telefono'] . '" size="50px" />';
    $r.='</td>';
    $r.='</tr>';
    $r.='</table>';
    return $r;
}

function editar_ubc($ubc_id, $ci, $nb, $tlf) {
    $db = new base();
    if ($db->db_update('ubc', array('cedula' => $ci, 'nombre' => strtoupper($nb), 'telefono' => strtoupper($tlf)), 'id=' . $ubc_id) == 1) {
        return json_encode(array('band' => 1, 'msg' => ''));
    } else {
        return json_encode(array('band' => 0, 'msg' => pg_last_error()));
    }
}

function cambiar_ubc_asis($ubc_id, $resp) {
    $db = new base();
    if ($db->db_update('ubc_incidencias', array('asis' => $resp), 'ubc_id=' . $ubc_id) == 1) {
        return json_encode(array('band' => 1, 'msg' => ''));
    } else {
        return json_encode(array('band' => 0, 'msg' => $db->db_last_error()));
    }
}

function cambiar_ce_posicionamiento($centro_incidencia_id, $resp) {
    $db = new base();
    if ($db->db_update('centros_incidencias', array('posicionamiento' => $resp), 'id=' . $centro_incidencia_id) == 1) {
        return json_encode(array('band' => 1, 'msg' => ''));
    } else {
        return json_encode(array('band' => 0, 'msg' => $db->db_last_query()));
    }
}

function cambiar_ce_vehiculos($centro_incidencia_id, $resp) {
    $db = new base();
    if ($db->db_update('centros_incidencias', array('vehiculos' => $resp), 'id=' . $centro_incidencia_id) == 1) {
        return json_encode(array('band' => 1, 'msg' => ''));
    } else {
        return json_encode(array('band' => 0, 'msg' => $db->db_last_query()));
    }
}

function cambiar_ce_hidratacion($centro_incidencia_id, $resp) {
    $db = new base();
    if ($db->db_update('centros_incidencias', array('hidratacion' => $resp), 'id=' . $centro_incidencia_id) == 1) {
        return json_encode(array('band' => 1, 'msg' => ''));
    } else {
        return json_encode(array('band' => 0, 'msg' => 'xxx'));
    }
}

function cambiar_ce_alimentacion($centro_incidencia_id, $resp) {
    $db = new base();
    if ($db->db_update('centros_incidencias', array('alimentacion' => $resp), 'id=' . $centro_incidencia_id) == 1) {
        return json_encode(array('band' => 1, 'msg' => ''));
    } else {
        return json_encode(array('band' => 0, 'msg' => 'xxx'));
    }
}

function cambiar_ce_apertura($centro_incidencia_id, $resp) {
    $db = new base();
    if ($db->db_update('centros_incidencias', array('apertura' => $resp), 'id=' . $centro_incidencia_id) == 1) {
        return json_encode(array('band' => 1, 'msg' => ''));
    } else {
        return json_encode(array('band' => 0, 'msg' => 'xxx'));
    }
}

function cambiar_ce_tarjetas($centro_incidencia_id, $resp) {
    $db = new base();
    if ($db->db_update('centros_incidencias', array('tarjetas' => $resp), 'id=' . $centro_incidencia_id) == 1) {
        return json_encode(array('band' => 1, 'msg' => ''));
    } else {
        return json_encode(array('band' => 0, 'msg' => 'xxx'));
    }
}

function cambiar_tablamesa_osi($tablamesa_incidencia_id, $resp) {
    $db = new base();
    if ($db->db_update('tablamesa_incidencias', array('osi' => $resp), 'id=' . $tablamesa_incidencia_id) == 1) {
        return json_encode(array('band' => 1, 'msg' => ''));
    } else {
        return json_encode(array('band' => 0, 'msg' => $db->db_last_query()));
    }
}

function cambiar_tablamesa_maquina($tablamesa_incidencia_id, $resp) {
    $db = new base();
    if ($db->db_update('tablamesa_incidencias', array('maquina' => $resp), 'id=' . $tablamesa_incidencia_id) == 1) {
        return json_encode(array('band' => 1, 'msg' => ''));
    } else {
        return json_encode(array('band' => 0, 'msg' => $db->db_last_query()));
    }
}

function cambiar_tablamesa_testigos($tablamesa_incidencia_id, $resp) {
    $db = new base();
    if ($db->db_update('tablamesa_incidencias', array('testigos' => $resp), 'id=' . $tablamesa_incidencia_id) == 1) {
        return json_encode(array('band' => 1, 'msg' => ''));
    } else {
        return json_encode(array('band' => 0, 'msg' => $db->db_last_query()));
    }
}

function cambiar_tablamesa_transmision($tablamesa_incidencia_id, $resp) {
    $db = new base();
    if ($db->db_update('tablamesa_incidencias', array('transmision' => $resp), 'id=' . $tablamesa_incidencia_id) == 1) {
        return json_encode(array('band' => 1, 'msg' => ''));
    } else {
        return json_encode(array('band' => 0, 'msg' => $db->db_last_query()));
    }
}

function cambiar_tablamesa_constituida($tablamesa_incidencia_id, $resp) {
    $db = new base();
    if ($db->db_update('tablamesa_incidencias', array('constituida' => $resp), 'id=' . $tablamesa_incidencia_id) == 1) {
        return json_encode(array('band' => 1, 'msg' => ''));
    } else {
        return json_encode(array('band' => 0, 'msg' => $db->db_last_query()));
    }
}

function resultado($titulo, $data, $result) {
    if ($result == 'mp') {
        $url = 'parroquias.php';
    } elseif ($result == 'pq') {
        $url = 'centros.php';
    } else {
        $url = '';
    }
    $r = '<div class="titulo">' . $titulo . '</div>';
    $r.='<table class="table-main">';
    $acum_pos = 0;
    $acum_neg = 0;
    foreach ($data as $v) {
        $pos_porcent = number_format(($v['pos'] * 100) / ($v['pos'] + $v['neg']), 2, ',', '');
        $neg_porcent = number_format(($v['neg'] * 100) / ($v['pos'] + $v['neg']), 2, ',', '');
        $r.= '<tr>';
        $r.='<td class="td-opcion" nowrap="nowrap">';
        $r.='<a href="' . $url . '?id=' . $v['cod_opcion'] . '">' . $v['opcion'] . '</a>';
        $r.='</td>';
        $r.= '<td class="td-porcentaje" nowrap="nowrap">';
        $r.= $v['pos'] . ' - (' . $pos_porcent . '%)';
        $r.= '</td>';
        $r.= '<td>';
        $r.= '<table class="table-barra">';
        $r.= '<tr>';
        $r.= '<td class="bar_pos" width="' . $pos_porcent . '%"></td>';
        $r.= '<td class="bar_neg" width="' . $neg_porcent . '%"></td>';
        $r.= '</tr>';
        $r.= '</table>';
        $r.= '</td>';
        $r.= '<td class="td-porcentaje" nowrap="nowrap">';
        $r.= $v['neg'] . ' - (' . $neg_porcent . '%)';
        $r.= '</td>';
        $r.= '</tr>';
        $acum_pos+=$v['pos'];
        $acum_neg+=$v['neg'];
    }
    $acum_pos_porcent = number_format(($acum_pos * 100) / ($acum_pos + $acum_neg), 2, ',', '');
    $acum_neg_porcent = number_format(($acum_neg * 100) / ($acum_pos + $acum_neg), 2, ',', '');

    $r.='<tr>';
    $r.='<td>';
    $r.='<b>TOTAL</b>';
    $r.='</td>';
    $r.='<td align="right" nowrap="nowrap">';
    $r.='<b>' . $acum_pos . ' - (' . $acum_pos_porcent . '%)</b>';
    $r.='</td>';
    $r.= '<td>';
    $r.= '<table class="table-barra">';
    $r.= '<tr>';
    $r.= '<td class="bar_pos" width="' . $acum_pos_porcent . '%"></td>';
    $r.= '<td class="bar_neg" width="' . $acum_neg_porcent . '%"></td>';
    $r.= '</tr>';
    $r.= '</table>';
    $r.= '</td>';
    $r.='<td align="right" nowrap="nowrap">';
    $r.='<b>' . $acum_neg . ' - (' . $acum_neg_porcent . '%)</b>';
    $r.='</td>';
    $r.='</tr>';
    $r.= '</table>';
    return $r;
}

function mp($arg) {
    $db = new base();
    $qry = "select distinct(municipio),estado from centros where cod_centro like '$arg%'";
    $db->db_query($qry);
    return '<a href=".">' . $db->fields['estado'] . '</a> - <a href="parroquias.php?id=' . $arg . '">' . $db->fields['municipio'] . '</a>';
}

function pq($arg) {
    $db = new base();
    $qry = "select distinct(parroquia),municipio,estado from centros where cod_centro like '$arg%'";
    $db->db_query($qry);

    return '<a href=".">' . $db->fields['estado'] . '</a> - <a href="parroquias.php?id=' . substr($arg, 0, 3) . '">' . $db->fields['municipio'] . '</a> - <a href="centros.php?id=' . $arg . '">' . $db->fields['parroquia'] . '</a>';
}

function mesa($arg) {
    $db = new base();
    $qry = "select cod_centro,
        centro,
        estado,
        municipio,
        parroquia
        from centros
        where cod_centro = '$arg'";
    $db->db_query($qry);

    return '<a href=".">' . $db->fields['estado'] . '</a> - <a href="parroquias.php?id=' . substr($arg, 0, 3) . '">' . $db->fields['municipio'] . '</a> - <a href="centros.php?id=' . substr($arg, 0, 5) . '">' . $db->fields['parroquia'] . '</a> - <a href="mesas.php?id=' . $arg . '">' . $db->fields['cod_centro'] . ' - ' . $db->fields['centro'] . '</a>';
}

//UBC
//Puntos rojos 
//Mesas instaladas 
//Testigos de mesa
//Logista (Hidratacion alimentacion)
//Tarjetas (Logistica)
//Domingo
//Movilizacion (Dinero)
?>