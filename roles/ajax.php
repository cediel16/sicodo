<?php

include_once '../config.php';

$data = var_post();

switch ($data['band']) {
    case 'add': {
            if ($data['rol'] == '') {
                $json = array(
                    'resp' => 2,
                    'msj' => 'Escribe el rol que deseas añadir.'
                );
            } elseif (!roles::esta_rol_disponible($data['rol'])) {
                $json = array(
                    'resp' => 2,
                    'msj' => 'El rol <i>"' . $data['rol'] . '"</i> ya se encuntra registrado.'
                );
            } elseif (roles::add(array('rol' => $data['rol']))) {
                $json = array(
                    'resp' => 1,
                    'msj' => 'El rol se ha añadido con éxito.',
                    'lista' => roles::lista()
                );
            } else {
                $json = array(
                    'resp' => 0,
                    'msj' => 'Error al intentar añadir el rol.'
                );
            }
            break;
        }
    case 'edit': {
            if ($data['rol'] == '') {
                $json = array(
                    'resp' => 2,
                    'msj' => 'Escribe el rol.'
                );
            } elseif (!roles::esta_rol_disponible_al_editar($data['id'], $data['rol'])) {
                $json = array(
                    'resp' => 2,
                    'msj' => 'El rol <i>"' . $data['rol'] . '"</i> ya se encuntra registrado.'
                );
            } elseif (roles::edit($data)) {
                $json = array(
                    'resp' => 1,
                    'msj' => 'El rol se ha editado con éxito.'
                );
            } else {
                $json = array(
                    'resp' => 0,
                    'msj' => 'Error al intentar editar el rol. '
                );
            }
            break;
        }

    case 'del': {
            if (roles::del($data['id'])) {
                $json = array(
                    'resp' => 1,
                    'msj' => 'El rol se ha eliminado con éxito.',
                    'lista' => roles::lista()
                );
            } else {
                $json = array(
                    'resp' => 0,
                    'msj' => 'Error al intentar eliminar el rol.'
                );
            }

            break;
        }

    case 'act': {
            if (roles::act($data['id'])) {
                $json = array(
                    'resp' => 1,
                    'msj' => 'El rol se ha activado con éxito.',
                    'lista' => roles::lista()
                );
            } else {
                $json = array(
                    'resp' => 0,
                    'msj' => 'Error al intentar activar el rol.'
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