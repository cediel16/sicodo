<div class="navbar navbar-inverse navbar-static-top">
    <div class="navbar-inner">
        <div class="container-fluid">
            <button data-target=".nav-collapse" data-toggle="collapse" class="btn btn-navbar" type="button">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <div class="nav-collapse collapse">
                <ul class="nav">
                    <li><a href="<?php echo site_url() ?>/expedientes">Expedientes</a></li>
                    <?php if (sesiones::is_has_permission('unidades.acceso') || sesiones::is_has_permission('cargos.acceso') || sesiones::is_has_permission('rutas.acceso') || sesiones::is_has_permission('estaciones.acceso')) { ?>
                        <li class="dropdown">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">Definiciones <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <?php if (sesiones::is_has_permission('unidades.acceso')) { ?>
                                    <li><a href="<?php echo site_url() ?>/unidades">Unidades</a></li>
                                <?php } ?>
                                <?php if (sesiones::is_has_permission('cargos.acceso')) { ?>
                                    <li><a href="<?php echo site_url() ?>/cargos">Cargos</a></li>
                                <?php } ?>
                                <?php if (sesiones::is_has_permission('rutas.acceso')) { ?>
                                    <li><a href="<?php echo site_url() ?>/rutas">Rutas de expedientes</a></li>
                                <?php } ?>
                                <?php if (sesiones::is_has_permission('estaciones.acceso')) { ?>
                                    <li><a href="<?php echo site_url() ?>/estaciones">Estadiones de ruta</a></li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>
                </ul>
                <ul class="nav pull-right">
                    <?php if (sesiones::is_has_permission('usuarios.acceso') || sesiones::is_has_permission('roles.acceso') || sesiones::is_has_permission('permisos.acceso')) { ?>
                        <li class="dropdown">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">Administración de acceso<b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <?php if (sesiones::is_has_permission('usuarios.acceso')) { ?>
                                    <li><a href="<?php echo site_url() ?>/usuarios">Usuarios</a></li>
                                <?php } ?>
                                <?php if (sesiones::is_has_permission('roles.acceso')) { ?>
                                    <li><a href="<?php echo site_url() ?>/roles">Roles</a></li>
                                <?php } ?>
                                <?php if (sesiones::is_has_permission('permisos.acceso')) { ?>
                                    <li><a href="<?php echo site_url() ?>/permisos">Permisos</a></li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
</div>


