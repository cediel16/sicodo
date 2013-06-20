<?php

include_once '../config.php';

$data = var_post();

switch ($data['band']) {
    case 'lista': {
            $json = array(
                'lista' => estaciones::lista_por_ruta($data['ruta'])
            );
            break;
        }

    case 'obtener_fila': {
            $json = array(
                'fila' => estaciones::obtener_fila($data['estacion_id'])
            );
            break;
        }
    case 'add': {
            $d = array(
                'ruta_fkey' => $data['ruta'],
                'unidad_fkey' => $data['unidad'],
                'cargo_fkey' => $data['cargo'],
                'usuario_fkey' => $data['usuario'],
                'orden' => $data['orden'],
                'horas' => $data['horas'],
                'descripcion' => $data['descripcion']
            );
            if (estaciones::add($d)) {
                $json = array(
                    'resp' => 1,
                    'msj' => 'La estación se ha añadido con éxito.',
                    'lista' => estaciones::lista_por_ruta($data['ruta'])
                );
            } else {
                $json = array(
                    'resp' => 0,
                    'msj' => 'Error al intentar añadir la estación.'
                );
            }
            break;
        }
    case 'edit': {
            $estacion_id = $data['estacion_id'];
            $d = array(
                'ruta_fkey' => $data['ruta'],
                'unidad_fkey' => $data['unidad'],
                'cargo_fkey' => $data['cargo'],
                'usuario_fkey' => $data['usuario'],
                'orden' => $data['orden'],
                'horas' => $data['horas'],
                'descripcion' => $data['descripcion']
            );
            if (estaciones::edit($estacion_id, $d)) {
                $json = array(
                    'resp' => 1,
                    'msj' => 'La estación se ha editado con éxito.',
                    'lista' => estaciones::lista_por_ruta($data['ruta'])
                );
            } else {
                $json = array(
                    'resp' => 0,
                    'msj' => 'Error al intentar editar la estación.'
                );
            }
            break;
        }
    case 'del': {
            if (estaciones::del($data['estacion_id'])) {
                $json = array(
                    'resp' => 1,
                    'msj' => 'La estación se ha eliminado con éxito.',
                    'lista' => estaciones::lista_por_ruta($data['ruta'])
                );
            } else {
                $json = array(
                    'resp' => 0,
                    'msj' => 'Error al intentar eliminar la estación.'
                );
            }
            break;
        }
}

echo json_encode($json);
?>