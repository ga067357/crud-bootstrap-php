<?php
include("../config.php");
require_once(DBAPI);
include(HEADER_TEMPLATE);

if (!isset($_SESSION)) session_start();
?>

<?php if (!empty($_SESSION['message'])) : ?>
    <div class="alert alert-<?php echo $_SESSION['type']; ?> alert-dismissible fade show mt-4" role="alert">
        <?php echo $_SESSION['message']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php clear_messages(); ?>
<?php endif; ?>

<div id="actions" class="mt-5 mb-5">
    <form action="<?php echo BASEURL; ?>inc/valida.php" method="post">
        <div class="row">

            <div class="form-floating col-12 mb-2">
                <input type="text" class="form-control" name="login"
                       autocomplete="username" required>
                <label>Usuário</label>
            </div>

            <div class="form-floating col-12 mb-2">
                <input type="password" class="form-control" name="senha"
                       autocomplete="current-password" required>
                <label>Senha</label>
            </div>

            <div class="col-12 mb-2">
                <button type="submit" class="btn btn-secondary mb-4">
                    <i class="fa-solid fa-user-check"></i> Conectar
                </button>

                <a href="<?php echo BASEURL; ?>" class="btn btn-light mb-4">
                    <i class="fa-solid fa-rotate-left"></i> Cancelar
                </a>
            </div>

        </div>
    </form>
</div>

<?php include(FOOTER_TEMPLATE); ?>
