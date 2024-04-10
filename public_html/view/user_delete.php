<?php
$id = $names = $lastName = $username = "";
if (isset($dataToView["data"]) and is_array($dataToView["data"])) {
    [$id, $names, $lastName,, $username] = $dataToView["data"][0];
?>
    <div class="row">
        <form class="form" action=<?= ROOT . "?controller=user&action=confirmDelete" ?> method="post">
            <input type="hidden" name="id" value="<?= $id ?>" />
            <div class="alert alert-warning">
                <b>¿Estas seguro que deseas eliminar al usuario?:</b>
                <i><?= sprintf("%s %s (%s)", $names, $lastName, $username) ?></i>
            </div>
            <button type="submit" class="btn btn-danger">Eliminar</button>
            <a class="btn btn-outline-success" href="index.php?controller=user&action=list">Cancelar</a>
        </form>
    </div>
    <?php } else {
    // Respuesta de la acción confirmDelete del controlador (Se pudo eliminar el usuario)
    if ($dataToView["data"]) {
    ?>
        <div class="row">
            <div class="alert alert-success">
                Usuario eliminado correctamente. <a href="index.php?controller=user&action=list">Volver al listado</a>
            </div>
        </div>
    <?php } else { ?>
        <div class="row">
            <div class="alert alert-danger">
                Hubo un error al eliminar el usuario, intente mas tarde. <a href="index.php?controller=user&action=list">Volver al listado</a>
            </div>
        </div>
<?php }
} ?>