<?php
$id = $names = $lastName = $secondLastName = $username = $email = $rol = "";
if (isset($dataToView["data"])) {
    [$id, $names, $lastName, $secondLastName, $username, $email,, $rol] = $dataToView["data"][0];
}
?>
<div class="container-fluid justify-content-center row mb-5">
    <form class="col-4" action=<?= ROOT . "?controller=user&action=save" ?> method="post">
        <input type="hidden" name="id" value="<?= $id ?>">
        <div class="mb-3">
            <label for="name" class="form-label">Nombre(s)</label>
            <input type="text" class="form-control" name="name" value="<?= $names ?>">
        </div>
        <div class="mb-3">
            <label for="fullLastName" class="form-label">Apellidos</label>
            <input type="text" class="form-control" name="fullLastName" value="<?= "$lastName $secondLastName" ?>">
        </div>
        <div class=" mb-3">
            <label for="email" class="form-label">Correo electronico</label>
            <input type="email" class="form-control" name="email" value="<?= $email ?>">
        </div>
        <div class=" mb-3">
            <label for="username" class="form-label">Nombre de usuario</label>
            <input type="text" class="form-control" name="username" value="<?= $username ?>">
        </div>

        <?php
        // Si no se recibe el id, se permite el ingreso de nuevas contraseñas
        if (!$id) {
            echo '<div class=" mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" class="form-control" name="password">
        </div>
        <div class="mb-3">
            <label for="confirm" class="form-label">Confirma contraseña</label>
            <input type="password" class="form-control" name="confirm">
        </div>
        ';
        }
        ?>
        <!-- Campo extra para los administradores -->
        <?php if (isset($_SESSION["login"]["rol"]) and $_SESSION["login"]["rol"] == 1) { ?>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" name="adminCheck" <?php if ($rol == 1) echo "checked"; ?>>
                <label class="form-check-label" for="adminCheck">Administrador</label>
            </div>
        <?php } ?>
        <div class="w-100 d-flex justify-content-evenly mt-2">
            <button type="submit" class="btn btn-primary">Registrar</button>
            <a class="btn btn-danger" href=<?= ROOT ?>>Cancelar</a>
        </div>
    </form>
</div>