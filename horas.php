<?php

function es_hora_laborable($timestamp) {
    $horas = array(8, 9, 10, 11, 12, 13, 14, 15, 16, 17);
    if (in_array(date('G', $timestamp), $feriados)) {
        return FALSE;
    }
    return TRUE;
}

function sumar_horas($timestamp, $horas) {
    $seg_x_hora = 3600;
    $i = 0;
    while ($i < $horas) {
        $timestamp+=$seg_x_hora;
        //if (es_hora_laborable($timestamp)) {
        $i++;
        //}
    }
    return $timestamp;
}

$ruta = 9;
$inicio = strtotime('2013-06-21 08:00:00');
$fin = sumar_horas($inicio, $ruta);


echo 'Dias de ruta: ' . $ruta;
echo '<br>';
echo 'Fecha inicio: ' . date('d/m/Y - H:i:s a', $inicio);
echo '<br>';
echo 'Fecha fin: ' . date('d/m/Y - H:i:s a', $fin);
echo '<br>';
?>