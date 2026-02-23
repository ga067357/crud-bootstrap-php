<?php
// usuarios/add.php

if (session_status() === PHP_SESSION_NONE) session_start();
require_once("../config.php");

// 🔒 Apenas administradores podem criar usuários
if (!isset($_SESSION['nivel']) || $_SESSION['nivel'] !== 'admin') {
    $_SESSION['message'] = "Apenas administradores podem criar usuários.";
    $_SESSION['type'] = "danger";
    header("Location: " . BASEURL . "usuarios/index.php");
exit;

}

require_once("functions.php");

// Processa envio do formulário
add();

include(HEADER_TEMPLATE);
?>

<h2>Novo Usuário</h2>

<style>
  .previewImg {
    width: 150px;
    height: 150px;
    margin-top: 1rem;
    border-radius: 30px;
    border: 1px solid #000;
    object-fit: cover;
  }
</style>

<form action="<?php echo BASEURL; ?>usuarios/add.php" method="post" enctype="multipart/form-data">


  <hr />

  <div class="row">

    <div class="form-group col-md-7">
      <label for="nome">Nome completo</label>
      <input type="text" maxlength="250" class="form-control"
             id="nome" name="usuario[nome]" autocomplete="name" required>
    </div>

    <div class="form-group col-md-3">
      <label for="user">Usuário (login)</label>
      <input type="text" id="user" class="form-control"
             name="usuario[user]" autocomplete="username" required>
    </div>

    <div class="form-group col-md-3">
      <label for="senha">Senha</label>
      <input type="password" id="senha" class="form-control"
             name="usuario[password]" autocomplete="new-password" required>
    </div>

    <div class="form-group col-md-3">
      <label for="nivel">Nível</label>
      <select name="usuario[nivel]" id="nivel" class="form-control" required>
        <option value="user">Usuário</option>
        <option value="admin">Administrador</option>
      </select>
    </div>

    <div class="form-group col-md-3">
      <label for="foto">Foto</label>
      <input type="file" id="foto" class="form-control"
             name="foto" accept="image/*">
    </div>

  </div>

  <div id="actions" class="row mt-3">
    <div class="col-md-12">
      <button type="submit" class="btn btn-dark">
        <i class="fa-solid fa-floppy-disk me-1"></i> Salvar
      </button>
      <a href="index.php" class="btn btn-secondary">
        <i class="fa-solid fa-xmark me-1"></i> Cancelar
      </a>
    </div>
  </div>
</form>

<script>
  const actions = document.getElementById('actions');
  const imgInput = document.getElementById('foto');

  if (imgInput) {
    imgInput.addEventListener('change', () => {

      // Remove preview anterior, se houver
      const oldPreview = document.getElementById('previewImg');
      if (oldPreview) oldPreview.remove();

      // Carrega nova imagem
      const file = imgInput.files[0];
      if (!file) return;

      const reader = new FileReader();
      reader.onload = function (e) {
        const preview = document.createElement('img');
        preview.id = 'previewImg';
        preview.classList.add('previewImg');
        preview.src = e.target.result;

        actions.insertAdjacentElement("afterend", preview);
      };

      reader.readAsDataURL(file);
    });
  }
</script>

<?php include(FOOTER_TEMPLATE); ?>
