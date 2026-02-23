<?php
require_once "../config.php";
require_once "../inc/valida.php";
requireAdmin(); // só admin pode ver usuários

require_once "functions.php";
view($_GET["id"]);
include(HEADER_TEMPLATE);
?>

<style>
  .fa-eye {
    width: 1.2rem;
    height: 1.2rem;
  }
  .foto-user {
    width: 150px;
    height: 150px;
    object-fit: cover;
  }
</style>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-lg-8">

      <div class="card shadow-lg border-0 mb-4">

        <div class="card-header bg-dark text-white">
          <h3 class="mb-0">Usuário #<?= $usuario["id"] ?></h3>
        </div>

        <div class="card-body">

          <?php if (!empty($_SESSION["message"])): ?>
            <div class="alert alert-<?= $_SESSION["type"]; ?> alert-dismissible fade show" role="alert">
              <?= $_SESSION["message"]; ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
          <?php endif; ?>

          <div class="row mb-4">

            <div class="col-md-6 mb-3">
              <h6 class="text-muted">Nome</h6>
              <p class="fs-5 fw-semibold"><?= $usuario["nome"]; ?></p>
            </div>

            <div class="col-md-6 mb-3">
              <h6 class="text-muted">Login</h6>
              <p class="fs-5"><?= $usuario["user"]; ?></p>
            </div>

          </div>

          <div class="row mb-4">
            <div class="col-md-6 mb-3">
              <h6 class="text-muted">Foto</h6>

              <?php if (!empty($usuario["foto"])): ?>
                <img src="../assets/usuarios/<?= $usuario["foto"]; ?>" class="rounded shadow foto-user">
              <?php else: ?>
                <img src="../assets/semimagem/semimagem.jpg" class="rounded shadow foto-user">
              <?php endif; ?>

            </div>
          </div>

        </div>

        <div class="card-footer bg-light d-flex justify-content-end gap-2">
          <a href="edit.php?id=<?= $usuario["id"]; ?>" class="btn btn-dark">
            <i class="fa fa-pen-to-square me-1"></i> Editar
          </a>

          <a href="index.php" class="btn btn-secondary">
            <i class="fa fa-arrow-left me-1"></i> Voltar
          </a>
        </div>

      </div>

    </div>
  </div>
</div>

<?php include(FOOTER_TEMPLATE); ?>
