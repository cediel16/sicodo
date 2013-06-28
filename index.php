<?php
require_once 'config.php';

sesiones::logged_in();

sesiones::is_has_permission('unidades.anadir');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title><?php echo tag_title() ?></title>
        <?php include_once 'tpl/link.php'; ?>
    </head>
    <body>
        <header>
            <?php include_once 'tpl/header.php'; ?>
        </header>
        <section class="container-fluid contenedor-principal">
        </section>
    </body>
    <?php include_once 'tpl/script.php'; ?>
</html>


<?php
$email = new email();
$r=$email->enviar('cedielj@alcaldiadeguacara.gob.ve', 'Prueba ' . date('d/m/Y - h:i:s a'), 'Esto es una prueba...');
var_dump($r);
//8,9,10,11,12,2,3,4,5
?>