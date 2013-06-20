<?php

include_once '../config.php';

$data = var_post();

switch ($data['band']) {
    case 'add': {
            if ($data['cargo'] == '') {
                $json = array(
                    'resp' => 2,
                    'msj' => 'Escribe el cargo que deseas añadir.'
                );
            } elseif (!cargos::esta_cargo_disponible($data['cargo'])) {
                $json = array(
                    'resp' => 2,
                    'msj' => 'El cargo <i>"' . $data['cargo'] . '"</i> ya se encuntra registrado.'
                );
            } elseif (cargos::add(array('cargo' => $data['cargo']))) {
                $json = array(
                    'resp' => 1,
                    'msj' => 'El cargo se ha añadido con éxito.',
                    'lista' => cargos::lista()
                );
            } else {
                $json = array(
                    'resp' => 0,
                    'msj' => 'Error al intentar añadir el cargo.'
                );
            }
            break;
        }
    case 'edit': {
            if ($data['cargo'] == '') {
                $json = array(
                    'resp' => 2,
                    'msj' => 'Escribe el cargo que deseas añadir.'
                );
            } elseif (!cargos::esta_cargo_disponible_al_editar($data['id'], $data['cargo'])) {
                $json = array(
                    'resp' => 2,
                    'msj' => 'El cargo <i>"' . $data['cargo'] . '"</i> ya se encuntra registrado.'
                );
            } elseif (cargos::edit($data)) {
                $json = array(
                    'resp' => 1,
                    'msj' => 'El cargo se ha editado con éxito.'
                );
            } else {
                $json = array(
                    'resp' => 0,
                    'msj' => 'Error al intentar editar el cargo.'
                );
            }
            break;
        }
}

echo json_encode($json);
?>