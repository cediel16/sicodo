<?php



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

$ruta = 1;
$inicio = strtotime('2013-06-21');
$fin = sumar_dias($inicio, $ruta);


echo 'Dias de ruta: ' . $ruta;
echo '<br>';
echo 'Fecha inicio: ' . date('d/m/Y', $inicio);
echo '<br>';
echo 'Fecha fin: ' . date('d/m/Y', $fin);
echo '<br>';
?>