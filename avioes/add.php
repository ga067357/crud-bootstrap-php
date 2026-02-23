<?php 
require_once "../config.php"; 
require_once "functions.php"; 
require_once "../inc/valida.php"; // ALTERADO: agora usa valida.php

// Visitante pode ver, MAS não pode salvar
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    requireLogin(); // só permite salvar se estiver logado
}

add();

include(HEADER_TEMPLATE); 
?>

<h2>Novo Avião</h2>

<form action="<?php echo BASEURL; ?>avioes/add.php" method="post" enctype="multipart/form-data">

  <hr />
  <div class="row">
      <div class="form-group col-md-6">
          <label for="prefix">Prefixo</label>
          <input type="text" class="form-control" id="prefix" name="airplane[prefix]" maxlength="10" required>
      </div>

      <div class="form-group col-md-6">
          <label for="model">Modelo</label>
          <input type="text" class="form-control" id="model" name="airplane[model]" maxlength="30" required>
      </div>
  </div>

  <div class="row">
      <div class="form-group col-md-6">
          <label for="manufacturer">Fabricante</label>
          <input type="text" class="form-control" id="manufacturer" name="airplane[manufacturer]" maxlength="100">
      </div>

      <div class="form-group col-md-3">
          <label for="crew">Tripulação</label>
          <input type="number" class="form-control" id="crew" name="airplane[crew]">
      </div>

      <div class="form-group col-md-3">
          <label for="manufacture_date">Data de Fabricação</label>
          <input type="date" class="form-control" id="manufacture_date" name="airplane[manufacture_date]">
      </div>
  </div>

  <div class="row mt-2">
      <div class="form-group col-md-12">
          <label for="image">Foto</label>
          <input type="file" class="form-control" id="image" name="image" accept="image/*" onchange="previewImage(event)">
          <div class="mt-2">
              <img id="preview" src="#" alt="Pré-visualização" style="max-width: 300px; display:none;" class="img-thumbnail">
          </div>
      </div>
  </div>

  <div id="actions" class="row mt-3">
      <div class="col-md-12">
          <button type="submit" class="btn btn-secondary"><i class="fa-solid fa-sd-card"></i> Salvar</button>
          <a href="<?php echo BASEURL; ?>avioes" class="btn btn-light">Cancelar</a>
      </div>
  </div>

</form>

<?php include(FOOTER_TEMPLATE); ?>
