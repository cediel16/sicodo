<?php
require_once '../config.php';
$post = var_post();
if (count($post) > 0) {
    if (sesiones::login($post['username'], $post['password'])) {
        redirect();
    } else {

        $msg = 'Usuario o contraseña inválidos';
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Control de documentos</title>

        <link rel="icon" href="/favicon.ico"/>
        <link rel="shortcut icon" href="/favicon.ico"/>
        <link type="image/x-icon" href="/favicon.ico" rel="shortcut icon"/>
        <script src="js/jquery.min.js" type="text/javascript"></script>

        <link rel="stylesheet" type="text/css" media="screen" href="../css/bootstrap.css" />
        <link rel="stylesheet" type="text/css" media="screen" href="../css/style.css" />
    </head>
    <body>
        <div class="content-fluid contenido-principal">
            <div class="row-fluid">
                <div class="span6 offset1 well">
                    <div class="header-login">
                        <legend>Control de documentos</legend>
                        <p>Aqui va una descripción breve de la usabilidad del sistema.</p>
                    </div>
                    <h4 class="header-login-phone">Control de documentos</h4>
                </div>
                <div class="span4 well">
                    <legend>Inicio de sesión</legend>
                    <form method="POST" action="." accept-charset="UTF-8">
                        <div class="control-group">
                            <!-- Username -->
                            <div class="controls">
                                <input class="span12" type="text" id="username" name="username" placeholder="Usuario" class="span4">
                            </div>
                        </div>
                        <div class="control-group">
                            <!-- Password-->
                            <div class="controls">
                                <input class="span12" type="password" id="password" name="password" placeholder="Contraseña" class="span4">
                            </div>
                        </div>
                        <div class="control-group">
                            <!-- Button -->
                            <div class="controls">
                                <button class="btn">Entrar</button>
                            </div>
                        </div>
                    </form>
                    <?php if (strlen($msg) > 1) { ?>
                        <p class="error"><?php echo $msg ?></p>
                    <?php } ?>
                </div>
            </div>
        </div>
    </body>
</html>
