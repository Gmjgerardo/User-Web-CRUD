<?php

?>
</div>
<?php if (isset($_SESSION["login"])) { ?>
    <footer class="vw-100 p-4 bg-dark d-flex justify-content-end mt-auto">
        <a class="btn btn-danger center-text" href="<?= ROOT . "?controller=session&action=logout" ?>">Cerrar sesión</a>
    </footer>
<?php } ?>
</body>

</html>