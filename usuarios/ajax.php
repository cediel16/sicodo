<?php

include_once '../config.php';

$data = var_post();

switch ($data['band']) {
    case 'cambiar_status': {
            switch ($data['status']) {
                case 'activo': {
                        $msj_status_ok = 'activado';
                        $msj_status_error = 'activar';
                        break;
                    }
                case 'inactivo': {
                        $msj_status_ok = 'desactivado';
                        $msj_status_error = 'desactivar';
                        break;
                    }
                case 'bloqueado': {
                        $msj_status_ok = 'bloqueado';
                        $msj_status_error = 'bloquear';
                        break;
                    }
            }
            if (usuarios::cambiar_status($data['usuario_id'], $data['status'])) {
                $json = array(
                    'resp' => 1,
                    'msj' => "El usuario ha sido $msj_status_ok.",
                    'lista' => usuarios::lista()
                );
            } else {
                $json = array(
                    'resp' => 0,
                    'msj' => "Error al intentar $msj_status_error el usuario."
                );
            }
            break;
        }
    case 'filtrar': {
            $json = array(
                'lista' => usuarios::lista($data['filtro'])
            );
            break;
        }
}

echo json_encode($json);
?>