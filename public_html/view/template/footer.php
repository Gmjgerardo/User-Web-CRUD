<?php
$id = $_SESSION["login"]["id"] ?? false;
$username = $_SESSION["login"]["user"] ?? false;
?>
</div>
<?php if ($username) { ?>
    <footer class="vw-100 p-4 bg-dark d-flex justify-content-between mt-auto">
        <p class="text-light" style="font-size: 1.5rem;">
            <strong>Bienvenido:
                <a class="text-light" href="<?= ROOT . "?controller=user&action=edit&id=" . $id ?>">
                    <?= strval($username) ?>
                </a>
            </strong>
        </p>
        <a class="btn btn-danger center-text d-flex align-items-center" href="<?= ROOT . "?controller=session&action=logout" ?>">Cerrar Sesión
        </a>
    </footer>
<?php } ?>
</body>

</html>