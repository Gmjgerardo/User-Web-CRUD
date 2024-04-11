<?php
$usuarioLogueado = isset($_SESSION["login"]);
// Se completo exitosamente
if ($dataToView["data"]) { ?>
    <div class="row">
        <div class="alert alert-success">
            El usuario se <?= $usuarioLogueado ? "modifico" : "registro" ?> correctamente! <a href=<?= ROOT ?>>Regresar</a>
        </div>
    </div>
<?php } else { ?>
    <div class="row">
        <div class="alert alert-danger">
            Hubo un error al <?= $usuarioLogueado ? "modificar" : "registrar" ?> el usuario. Intentalo de nuevo <a href=<?= ROOT ?>>Regresar</a>
        </div>
    </div>
<?php } ?>