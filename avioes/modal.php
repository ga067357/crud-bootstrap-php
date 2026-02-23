<!-- Modal de Exclusão -->
<div class="modal fade" id="delete-modal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="deleteModalLabel">
          <i class="fa fa-exclamation-triangle"></i> Excluir
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      
      <div class="modal-body">
        Tem certeza que deseja excluir este item?
      </div>
      
      <div class="modal-footer">
        <a id="confirm" class="btn btn-danger" href="#">
          <i class="fa fa-check-circle"></i> Sim, excluir
        </a>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
          <i class="fa fa-times-circle"></i> Cancelar
        </button>
      </div>

    </div>
  </div>
</div>

<script>
// Script que pega o ID e coloca no botão de confirmação
document.addEventListener('DOMContentLoaded', function () {

    const deleteModal = document.getElementById('delete-modal');

    deleteModal.addEventListener('show.bs.modal', function (event) {

        // Botão que abriu o modal
        const button = event.relatedTarget;

        // ID do item armazenado no botão
        const id = button.getAttribute('data-airplane') 
               || button.getAttribute('data-customer') 
               || button.getAttribute('data-user');

        // Link do botão de confirmação
        const confirmBtn = document.getElementById('confirm');

        // Ajusta automaticamente para DELETE do módulo atual
        confirmBtn.href = "delete.php?id=" + id;
    });
});
</script>
