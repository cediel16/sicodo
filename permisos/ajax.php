<?php

include_once '../config.php';

$data = var_post();

switch ($data['band']) {
    case 'edit': {
            if ($data['permiso'] == '') {
                $json = array(
                    'resp' => 2,
                    'msj' => 'Escribe el permiso.'
                );
            } elseif (!permisos::esta_permiso_disponible_al_editar($data['id'], $data['permiso'])) {
                $json = array(
                    'resp' => 2,
                    'msj' => 'El permiso <i>"' . $data['rol'] . '"</i> ya se encuntra registrado.'
                );
            } elseif ($data['descripcion'] == '') {
                $json = array(
                    'resp' => 2,
                    'msj' => 'Escribe la descripción del permiso.'
                );
            } elseif (permisos::edit($data)) {
                $json = array(
                    'resp' => 1,
                    'msj' => 'El permiso se ha editado con éxito.'
                );
            } else {
                $json = array(
                    'resp' => 0,
                    'msj' => 'Error al intentar editar el permiso.'
                );
            }
            break;
        }

    case 'del': {
            if (permisos::del($data['id'])) {
                $json = array(
                    'resp' => 1,
                    'msj' => 'El permiso se ha eliminado con éxito.',
                    'lista' => permisos::lista()
                );
            } else {
                $json = array(
                    'resp' => 0,
                    'msj' => 'Error al intentar eliminar el permiso.'
                );
            }

            break;
        }

    case 'act': {
            if (permisos::act($data['id'])) {
                $json = array(
                    'resp' => 1,
                    'msj' => 'El permiso se ha activado con éxito.',
                    'lista' => permisos::lista()
                );
            } else {
                $json = array(
                    'resp' => 0,
                    'msj' => 'Error al intentar activar el permiso.'
                );
            }

            break;
        }
    case 'asignar_permiso': {
            $r = roles::asignar_permiso($data['rol'], $data['permiso']);
            if ($r == 1) {
                $json = array(
                    'resp' => 1
                );
            } elseif ($r == 2) {
                $json = array(
                    'resp' => 1,
                    'msj' => 'Este permiso ya se encuentra asignado.'
                );
            } elseif ($r == 2) {
                $json = array(
                    'resp' => 1,
                    'msj' => 'Este permiso ya se encuentra asignado.'
                );
            }
            break;
        }
    case 'quitar_permiso': {
            roles::quitar_permiso($data['rol'], $data['permiso']);
            $json = array(
                'resp' => 1
            );
            break;
        }
}

echo json_encode($json);
?>