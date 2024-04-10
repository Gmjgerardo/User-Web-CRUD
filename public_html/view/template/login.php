<div class="row justify-content-center">
    <div class="col-sm-6">
        <form action="index.php?controller=session&action=login" method="post">
            <div class="mb-3">
                <label for="username" class="form-label">Nombre de usuario</label>
                <input type="text" class="form-control" name="username">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" name="password">
            </div>
            <button type="submit" class="btn btn-primary">Entrar</button>
        </form>
        <p class="text-danger"><?= (isset($_GET['msg'])) ? $_GET['msg'] : "" ?></p>
    </div>
</div>