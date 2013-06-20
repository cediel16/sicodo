<div class="banner">
    <ul>
        <li>Sistema para el Control de Documentos</li>
        <li>
            <div class="btn-group">
                <a class="btn btn-mini" href="<?php echo site_url() ?>/usuarios/perfil.php"><?php echo sesiones::userdata('nombre') ?></a>
                <a href="<?php echo site_url() ?>/sesiones/logout.php" class="btn btn-mini"><i class="icon-off"></i></a>
            </div>
        </li>
    </ul>
</div>
<?php
include_once 'menu.php';
?>