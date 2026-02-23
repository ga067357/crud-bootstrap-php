<?php
// Inclui configuração e funções essenciais primeiro
require_once("../config.php");   // sessão + is_logged(), protect()
require_once(DBAPI);            // banco de dados
require_once("functions.php");   // funções específicas de clientes

// Carrega lista de clientes
index();

// Inclui cabeçalho
include(HEADER_TEMPLATE); 
?>

<header>
    <div class="row">
        <div class="col-sm-6">
            <h2><i class="fa fa-users"></i> Clientes</h2>
        </div>

        <div class="col-sm-6 text-end h2">
            <!-- Só mostra o botão se estiver logado -->
            <?php if (is_logged()) : ?>
                <a class="btn btn-secondary" href="add.php">
                    <i class="fa fa-user-plus"></i> Novo Cliente
                </a>
            <?php endif; ?>

            <a class="btn btn-light" href="index.php">
                <i class="fa fa-refresh"></i> Atualizar
            </a>
        </div>
    </div>
</header>

<?php if (!empty($_SESSION['message'])) : ?>
    <div class="alert alert-<?php echo $_SESSION['type']; ?> alert-dismissible fade show mt-3">
        <?php echo $_SESSION['message']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php clear_messages(); ?>
<?php endif; ?>

<hr>

<table class="table table-hover table-bordered table-responsive">
    <thead>
        <tr>
            <th>ID</th>
            <th width="25%">Nome</th>
            <th>CPF/CNPJ</th>
            <th>Telefone</th>
            <th>Celular</th>
            <th>Atualizado em</th>
            <th width="180">Opções</th>
        </tr>
    </thead>

    <tbody>
    <?php if ($customers) : ?>
        <?php foreach ($customers as $customer) : ?>
        <tr>
            <td><?php echo $customer['id']; ?></td>
            <td><?php echo $customer['name']; ?></td>
            <td><?php echo $customer['cpf_cnpj']; ?></td>
            <td><?php echo $customer['phone']; ?></td>
            <td><?php echo $customer['mobile']; ?></td>
            <td><?php echo formataData($customer['modified'], "d/m/Y - H:i:s"); ?></td>

            <td class="actions text-end">
                <!-- Visualizar sempre -->
                <a href="view.php?id=<?php echo $customer['id']; ?>" 
                   class="btn btn-sm btn-light" title="Visualizar">
                    <i class="fa fa-eye"></i>
                </a>

                <!-- Editar / Excluir apenas para logados -->
                <?php if (is_logged()) : ?>
                    <a href="edit.php?id=<?php echo $customer['id']; ?>" 
                       class="btn btn-sm btn-secondary" title="Editar">
                        <i class="fa fa-pencil"></i>
                    </a>

                    <a href="#" class="btn btn-sm btn-danger"
                       data-bs-toggle="modal" data-bs-target="#delete-modal"
                       data-customer="<?php echo $customer['id']; ?>" 
                       title="Excluir">
                        <i class="fa fa-trash"></i>
                    </a>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    <?php else : ?>
        <tr>
            <td colspan="7">Nenhum cliente cadastrado.</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>

<?php 
// Modal de exclusão
include("modal.php"); 

// Rodapé
include(FOOTER_TEMPLATE); 
?>