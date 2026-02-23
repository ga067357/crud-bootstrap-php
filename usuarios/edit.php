<?php
// usuarios/edit.php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once("../config.php");

// Somente administradores
if (!isset($_SESSION['nivel']) || $_SESSION['nivel'] !== 'admin') {
    $_SESSION['message'] = "Acesso negado. Apenas administradores podem editar usuários.";
    $_SESSION['type'] = 'danger';
    header("Location: " . BASEURL . "usuarios/index.php");
exit;

}

require_once("functions.php");
edit();
include(HEADER_TEMPLATE);
?>

<h2>Atualizar Usuário</h2>

<style>
  .previewImg {
    margin-top: 1rem;
    border: 1px solid #0e0e0e;
    border-radius: 15px;
    width: 150px;
    height: 150px;
    object-fit: cover;
  }
</style>

<form action="<?php echo BASEURL; ?>usuarios/edit.php?id=<?php echo $usuario['id']; ?>" method="post" enctype="multipart/form-data">

  <hr />

  <div class="row">

    <!-- Nome -->
    <div class="form-group col-md-6">
      <label for="nome">Nome</label>
      <input type="text" maxlength="250" class="form-control" id="nome"
             name="usuario[nome]" required value="<?php echo htmlspecialchars($usuario["nome"]); ?>">
    </div>

    <!-- Login -->
    <div class="form-group col-md-4">
      <label for="user">Usuário (login)</label>
      <input type="text" id="user" class="form-control"
             name="usuario[user]" autocomplete="username" required
             value="<?php echo htmlspecialchars($usuario['user']); ?>">
    </div>

    <!-- Senha -->
    <div class="form-group col-md-4">
      <label for="senha">Senha (deixe em branco para manter)</label>
      <input type="password" id="senha" class="form-control"
             name="usuario[password]" autocomplete="new-password">
    </div>

    <!-- Nível -->
    <div class="form-group col-md-3">
      <label for="nivel">Nível</label>
      <select name="usuario[nivel]" id="nivel" class="form-control" required>
        <option value="user" <?php if ($usuario['nivel'] === 'user') echo 'selected'; ?>>Usuário</option>
        <option value="admin" <?php if ($usuario['nivel'] === 'admin') echo 'selected'; ?>>Administrador</option>
      </select>
    </div>

    <!-- Foto -->
    <div class="form-group col-md-3">
      <label for="foto">Foto (novo upload substitui)</label>
      <input type="file" id="foto" class="form-control" name="foto" accept="image/*">
    </div>

  </div>

  <!-- Botões -->
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

  <!-- Imagem antiga -->
  <?php if (!empty($usuario["foto"])) : ?>
    <img src="../assets/usuarios/<?php echo htmlspecialchars($usuario["foto"]); ?>"
         id="oldImg" class="previewImg" alt="Foto atual do usuário">
  <?php endif; ?>

</form>

<script>
  const imgInput = document.getElementById('foto');

  imgInput.addEventListener('change', () => {

    const oldImg = document.getElementById('oldImg');
    if (oldImg) oldImg.remove();

    const previewOld = document.getElementById('previewImg');
    if (previewOld) previewOld.remove();

    if (imgInput.files.length === 0) return;

    const reader = new FileReader();
    reader.onload = function (event) {
      const previewImage = document.createElement('img');
      previewImage.id = 'previewImg';
      previewImage.className = 'previewImg';
      previewImage.src = event.target.result;

      document.getElementById('actions').insertAdjacentElement("afterend", previewImage);
    };

    reader.readAsDataURL(imgInput.files[0]);
  });
</script>

<?php include(FOOTER_TEMPLATE); ?>
