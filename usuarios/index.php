<?php
require_once "../config.php";
require_once "../inc/valida.php";
requireAdmin(); // só admin pode ver usuários

require_once "functions.php";
index();
deleteUnusedImg();

include('modal.php'); // modal universal
include(HEADER_TEMPLATE);
?>

<style>
  .light-gray { background-color: #b7b7b7ff }
  .light-gray:hover { background-color: #d4d4d4ff }

  @media screen and (width < 768px) {
    #buttons{
        margin: .5rem 0;
        justify-content: space-between;
    }
    #buttons > a { margin: 0 .5rem; }
  }
</style>

<header>
    <div class="row">
        <div class="col-sm-6">
            <h2>Usuários</h2>
        </div>
        <div class="col-sm-6 text-end" id="buttons">
            <a class="btn btn-secondary" href="add.php"><i class="fa fa-user-tie"></i> Novo Usuário</a>
            <a class="btn btn-light" href="index.php"><i class="fas fa-sync-alt"></i> Atualizar</a>
        </div>
    </div>

    <form id="filtro" action="index.php" method="post">
        <div class="form-group col-md-4">
            <div class="input-group">
                <input type="text" class="form-control" maxlength="80" name="users" required>
                <button type="submit" class="btn btn-secondary"><i class="fa fa-search"></i> Consultar</button>
            </div>
        </div>
    </form>
</header>

<hr>

<?php if (!empty($_SESSION['message'])) : ?>
    <div class="alert alert-<?php echo $_SESSION['type']; ?> alert-dismissible">
        <?php echo $_SESSION['message']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<table class="table table-hover">
    <thead>
        <tr>
            <th>ID</th>
            <th width="35%">Nome</th>
            <th width="15%">Login</th>
            <th>Foto</th>
            <th></th>
        </tr>
    </thead>

    <tbody>
        <?php if ($usuarios): foreach ($usuarios as $usuario): ?>
            <tr>
                <td><?= $usuario['id']; ?></td>
                <td><?= $usuario['nome']; ?></td>
                <td><?= $usuario['user']; ?></td>
                <td>
                    <?php if (!empty($usuario['foto'])): ?>
                        <img src="../assets/usuarios/<?= $usuario['foto']; ?>" width="90">
                    <?php else: ?>
                        <img src="../assets/semimagem/semimagem.jpg" width="90">
                    <?php endif; ?>
                </td>

                <td class="actions text-center">
                    <a href="view.php?id=<?= $usuario['id']; ?>" class="btn btn-sm btn-dark">
                        <i class="fa fa-eye"></i> Visualizar
                    </a>

                    <a href="edit.php?id=<?= $usuario['id']; ?>" class="btn btn-sm btn-secondary">
                        <i class="fa fa-edit"></i> Editar
                    </a>

                    <a href="#" class="btn btn-sm light-gray"
                       data-bs-toggle="modal"
                       data-bs-target="#delete-modal"
                       data-user="<?= $usuario['id']; ?>">
                        <i class="fa fa-trash"></i> Excluir
                    </a>
                </td>
            </tr>
        <?php endforeach; else: ?>

            <tr>
                <td colspan="6">Nenhum registro encontrado.</td>
            </tr>

        <?php endif; ?>
    </tbody>
</table>

<?php include(FOOTER_TEMPLATE); ?>
