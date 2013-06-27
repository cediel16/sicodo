<?php



$ruta = 7;
$inicio = strtotime('2013-06-21 08:00:00');
$fin = sumar_horas($inicio, $ruta);


echo '<pre>';
echo 'Horas de ruta: ' . $ruta;
echo '<br>';
echo 'Fecha inicio: ' . date('d/m/Y - h:i:s a', $inicio);
echo '<br>';
echo 'Fecha fin:    ' . date('d/m/Y - h:i:s a', $fin);
echo '<pre>';
?>