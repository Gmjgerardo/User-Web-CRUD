<?php
$id = $names = $lastName = $secondLastName = $username = $email = $rol = "";
if (isset($dataToView["data"])) {
    [$id, $names, $lastName, $secondLastName, $username, $email,, $rol] = $dataToView["data"][0];
}
?>
<div class="container-fluid justify-content-center row mb-5">
    <form id="userForm" class="col-4" action=<?= ROOT . "?controller=user&action=save" ?> method="post">
        <input type="hidden" name="id" value="<?= $id ?>">
        <div class="mb-3" id="namesField">
            <label for="name" class="form-label">Nombre(s)</label>
            <input type="text" class="form-control" name="name" value="<?= $names ?>">
            <div class="input-error text-danger" hidden>
                Debe contener al menos 2 letras. No se permiten números o caracteres especiales
            </div>
        </div>
        <div class="mb-3" id="lastNamesField">
            <label for="fullLastName" class="form-label">Apellidos</label>
            <input type="text" class="form-control" name="fullLastName" value="<?= "$lastName $secondLastName" ?>">
            <div class="input-error text-danger" hidden>
                Debe contener al menos 2 letras. No se permiten números o caracteres especiales
            </div>
        </div>
        <div class=" mb-3" id="emailField">
            <label for="email" class="form-label">Correo electronico</label>
            <input type="email" class="form-control" name="email" value="<?= $email ?>">
            <div class="input-error text-danger" hidden>
                Introduce un correo electronico valido
            </div>
        </div>
        <div class=" mb-3" id="usernameField">
            <label for="username" class="form-label">Nombre de usuario</label>
            <input type="text" class="form-control" name="username" value="<?= $username ?>">
            <div class="input-error text-danger" hidden>
                Debe contener al menos 4 digitos. No se permiten caracteres especiales
            </div>
        </div>

        <?php
        // Si no se recibe el id, se permite el ingreso de nuevas contraseñas
        if (!$id) {
            echo '<div class="mb-3" id="passwordField">
            <label for="password" class="form-label">Contraseña</label>
            <input id="password" type="password" class="form-control" name="password">
            <div class="input-error text-danger" hidden>
                Debe contener al menos 7 digitos, 1 caracter especial y 1 número
            </div>
        </div>
        <div class="mb-3" id="confirmField">
            <label for="confirm" class="form-label">Confirma contraseña</label>
            <input id="confirm" type="password" class="form-control" name="confirm">
            <div class="input-error text-danger" hidden>
                Introduce la misma contraseña
            </div>
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
    <div class="my-5 text-center" id="formConfirmation" hidden>
        <span class="p-3 bg-danger-subtle rounded"><b>Error:</b> Por favor rellena el formulario correctamente. </span>
    </div>

    <script src="view/js/form.js"></script>
</div>