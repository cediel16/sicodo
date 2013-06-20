<?php

include_once '../config.php';

$data = var_post();

switch ($data['band']) {
    case 'add': {
            if ($data['unidad'] == '') {
                $json = array(
                    'resp' => 2,
                    'msj' => 'Escribe la unidad que deseas añadir.'
                );
            } elseif (!unidades::esta_unidad_disponible($data['unidad'])) {
                $json = array(
                    'resp' => 2,
                    'msj' => 'La unidad <i>"' . $data['unidad'] . '"</i> ya se encuntra registrada.'
                );
            } elseif (unidades::add(array('unidad' => $data['unidad']))) {
                $json = array(
                    'resp' => 1,
                    'msj' => 'La unidad se ha añadido con éxito.',
                    'lista' => unidades::lista()
                );
            } else {
                $json = array(
                    'resp' => 0,
                    'msj' => 'Error al intentar añadir la unidad.'
                );
            }
            break;
        }
    case 'edit': {
            if ($data['unidad'] == '') {
                $json = array(
                    'resp' => 2,
                    'msj' => 'Escribe la unidad que deseas añadir.'
                );
            } elseif (!unidades::esta_unidad_disponible_al_editar($data['id'], $data['unidad'])) {
                $json = array(
                    'resp' => 2,
                    'msj' => 'La unidad <i>"' . $data['unidad'] . '"</i> ya se encuntra registrada.'
                );
            } elseif (unidades::edit($data)) {
                $json = array(
                    'resp' => 1,
                    'msj' => 'La unidad se ha editado con éxito.'
                );
            } else {
                $json = array(
                    'resp' => 0,
                    'msj' => 'Error al intentar editar la unidad.'
                );
            }
            break;
        }
}

echo json_encode($json);
?>