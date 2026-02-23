<?php 
require_once "../config.php"; 
require_once "functions.php"; 
require_once "../inc/valida.php"; // contém requireLogin()

// Apenas POST exige login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    requireLogin();
}

edit();
include(HEADER_TEMPLATE); 
?>

<h2>Editando Avião <?php echo $airplane['id']; ?></h2>

<form action="edit.php?id=<?php echo $airplane['id']; ?>" method="post" enctype="multipart/form-data">
  <hr />

  <div class="row">
      <div class="form-group col-md-6">
          <label for="prefix">Prefixo</label>
          <input type="text" class="form-control" id="prefix" 
          name="airplane[prefix]" value="<?php echo $airplane['prefix']; ?>" required>
      </div>

      <div class="form-group col-md-6">
          <label for="model">Modelo</label>
          <input type="text" class="form-control" id="model" 
          name="airplane[model]" value="<?php echo $airplane['model']; ?>" required>
      </div>
  </div>

  <div class="row">
      <div class="form-group col-md-6">
          <label for="manufacturer">Fabricante</label>
          <input type="text" class="form-control" id="manufacturer" 
          name="airplane[manufacturer]" value="<?php echo $airplane['manufacturer']; ?>">
      </div>

      <div class="form-group col-md-3">
          <label for="crew">Tripulação</label>
          <input type="number" class="form-control" id="crew" 
          name="airplane[crew]" value="<?php echo $airplane['crew']; ?>">
      </div>

      <div class="form-group col-md-3">
          <label for="manufacture_date">Data de Fabricação</label>
          <input type="date" class="form-control" id="manufacture_date" 
          name="airplane[manufacture_date]" 
          value="<?php echo substr($airplane['manufacture_date'], 0, 10); ?>">
      </div>
  </div>

  <div class="row mt-2">
      <div class="col-md-12">
          <?php if (!empty($airplane['image'])): ?>
              <p>Imagem atual:</p>
              <img src="/crud-bootstrap-php/assets/avioes/<?php echo $airplane['image']; ?>" 
              alt="Imagem atual" class="img-thumbnail" style="max-width: 300px; margin-bottom:10px;">
          <?php endif; ?>
          
          <label for="image">Nova imagem (opcional)</label>
          <input type="file" class="form-control" id="image" 
          name="image" accept="image/*" onchange="previewImage(event)">
          
          <div class="mt-2">
              <img id="preview" src="#" alt="Preview" 
              style="max-width: 300px; display:none;" class="img-thumbnail">
          </div>
      </div>
  </div>

  <div id="actions" class="row mt-3">
      <div class="col-md-12">
          <button type="submit" class="btn btn-secondary">
            <i class="fa-solid fa-sd-card"></i> Salvar
          </button>
          <a href="index.php" class="btn btn-light">
            <i class="fa-solid fa-arrow-rotate-left"></i> Cancelar
          </a>
      </div>
  </div>
</form>

<script>
function previewImage(event) {
    const preview = document.getElementById('preview');
    const file = event.target.files[0];

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    } else {
        preview.src = "#";
        preview.style.display = 'none';
    }
}
</script>

<?php include(FOOTER_TEMPLATE); ?>
