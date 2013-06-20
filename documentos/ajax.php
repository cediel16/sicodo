<?php

include_once '../config.php';

$data = var_post();

switch ($data['band']) {
    case 'add_resp': {
            if (documentos::add_resp($data)) {
                $json = array(
                    'resp' => 1
                );
            } else {
                $json = array(
                    'resp' => 0,
                    'msj' => 'Error al intentar registrar la respuesta.'
                );
            }
            break;
        }
}
echo json_encode($json);
?>