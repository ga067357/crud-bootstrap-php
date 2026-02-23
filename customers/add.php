<?php 
require_once "../config.php"; 
require_once "functions.php"; 
require_once "../inc/valida.php";  

// 🔒 Visitante pode ver o formulário, mas NÃO pode salvar
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    requireLogin();
}

add();
include(HEADER_TEMPLATE);
?>


<h2>Novo Cliente</h2>

<form action="<?php echo BASEURL; ?>customers/add.php" method="post" enctype="multipart/form-data">

  <hr />
  <div class="row">
      <div class="form-group col-md-7">
          <label for="name">Nome / Razão Social</label>
          <input type="text" class="form-control" id="name" name="customer[name]" maxlength="100" required>
      </div>

      <div class="form-group col-md-3">
          <label for="cpf">CNPJ / CPF</label>
          <input type="text" class="form-control" id="cpf" name="customer[cpf_cnpj]" maxlength="15" required>
      </div>

      <div class="form-group col-md-2">
          <label for="birth">Data de Nascimento</label>
          <input type="date" class="form-control" id="birth" name="customer[birthdate]">
      </div>
  </div>
  
  <div class="row">
      <div class="form-group col-md-5">
          <label for="end">Endereço</label>
          <input type="text" class="form-control" id="end" name="customer[address]" maxlength="80">
      </div>

      <div class="form-group col-md-3">
          <label for="hood">Bairro</label>
          <input type="text" class="form-control" id="hood" name="customer[hood]" maxlength="50">
      </div>
      
      <div class="form-group col-md-2">
          <label for="cep">CEP</label>
          <input type="text" class="form-control" id="cep" name="customer[zip_code]" maxlength="8">
      </div>
      
      <div class="form-group col-md-2">
          <label for="cad">Data de Cadastro</label>
          <input type="date" class="form-control" id="cad" name="customer[created]" disabled>
      </div>
  </div>
  
  <div class="row">
      <div class="form-group col-md-5">
          <label for="cidade">Cidade</label>
          <input type="text" class="form-control" id="cidade" name="customer[city]" maxlength="80">
      </div>
      
      <div class="form-group col-md-2">
          <label for="telefone">Telefone</label>
          <input type="tel" class="form-control" id="telefone" name="customer[phone]" maxlength="11">
      </div>
      
      <div class="form-group col-md-2">
          <label for="cel">Celular</label>
          <input type="tel" class="form-control" id="cel" name="customer[mobile]" maxlength="11">
      </div>
      
      <div class="form-group col-md-1">
          <label for="estado">UF</label>
          <input type="text" class="form-control" id="estado" name="customer[state]" maxlength="2">
      </div>
      
      <div class="form-group col-md-2">
          <label for="ie">Inscrição Estadual</label>
          <input type="text" class="form-control" id="ie" name="customer[ie]" maxlength="15">
      </div>
  </div>

  <div class="row mt-2">
      <div class="form-group col-md-12">
          <label for="image">Foto</label>
          <input type="file" class="form-control" id="image" name="image" accept="image/*" onchange="previewImage(event)">
          <div class="mt-2">
              <img id="preview" src="#" alt="Preview" style="max-width: 300px; display:none;" class="img-thumbnail">
          </div>
      </div>
  </div>
  
  <div id="actions" class="row mt-3">
      <div class="col-md-12">
          <button type="submit" class="btn btn-secondary"><i class="fa-solid fa-sd-card"></i> Salvar</button>
          <a href="index.php" class="btn btn-light"><i class="fa-solid fa-arrow-rotate-left"></i> Cancelar</a>
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
