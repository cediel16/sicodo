<?php

function es_dia_laborable($timestamp) {
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

function sumar_dias($timestamp, $dias) {
    $seg_x_dia = 86400;
    $i = 0;
    while ($i < $dias) {
        $timestamp+=$seg_x_dia;
        if (es_dia_laborable($timestamp)) {
            $i++;
        }
    }
    return $timestamp;
}

$ruta = 9;
$inicio = strtotime('2013-06-21');
$fin = sumar_dias($inicio, $ruta);


echo 'Dias de ruta: ' . $ruta;
echo '<br>';
echo 'Fecha inicio: ' . date('d/m/Y', $inicio);
echo '<br>';
echo 'Fecha fin: ' . date('d/m/Y', $fin);
echo '<br>';
?>