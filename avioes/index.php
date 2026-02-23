<?php 
    require_once "../config.php";
    require_once 'functions.php';

    // Carrega lista
    index();

    include(HEADER_TEMPLATE); 
?>

<header>
    <div class="row">
        <div class="col-sm-6">
            <h2><i class="fa fa-plane"></i> Aviões</h2>
        </div>

        <div class="col-sm-6 text-end h2">
            <!-- 🔒 Botão só aparece para logados -->
            <?php if (!empty($_SESSION['id'])): ?>
                <a class="btn btn-secondary" href="add.php">
                    <i class="fa fa-plus"></i> Novo Avião
                </a>
            <?php endif; ?>

            <a class="btn btn-light" href="index.php">
                <i class="fa fa-refresh"></i> Atualizar
            </a>
        </div>
    </div>
</header>

<?php if (!empty($_SESSION['message'])) : ?>
    <div class="alert alert-<?php echo $_SESSION['type']; ?> alert-dismissible fade show" role="alert">
        <?php echo $_SESSION['message']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
    </div>
    <?php clear_messages(); ?>
<?php endif; ?>

<hr>

<table class="table table-hover table-bordered table-responsive">
    <thead>
        <tr>
            <th>ID</th>
            <th>Prefixo</th>
            <th>Modelo</th>
            <th>Fabricante</th>
            <th>Tripulação</th>
            <th class="hide">Data Fabricação</th>
            <th>Foto</th>
            <th width="180">Opções</th>
        </tr>
    </thead>
    <tbody>
    <?php if ($airplanes) : ?>
        <?php foreach ($airplanes as $airplane) : ?>
        <tr>
            <td><?php echo $airplane['id']; ?></td>
            <td><?php echo $airplane['prefix']; ?></td>
            <td><?php echo $airplane['model']; ?></td>
            <td><?php echo $airplane['manufacturer']; ?></td>
            <td><?php echo $airplane['crew']; ?></td>
            <td class="hide"><?php echo formataData($airplane['manufacture_date'], "d/m/Y"); ?></td>

            <td>
                <?php if (!empty($airplane['image'])): ?>
                    <img src="/crud-bootstrap-php/assets/avioes/<?php echo $airplane['image']; ?>"  
                         alt="Foto do avião" 
                         class="avioes table-img">
                <?php else: ?>
                    <span class="text-muted">Sem foto</span>
                <?php endif; ?>
            </td>

            <td class="actions text-end">

                <!-- Sempre pode visualizar -->
                <a href="view.php?id=<?php echo $airplane['id']; ?>" 
                   class="btn btn-sm btn-light" title="Visualizar">
                    <i class="fa fa-eye"></i>
                </a>

                <!-- 🔒 Editar e excluir apenas para logados -->
                <?php if (!empty($_SESSION['id'])): ?>
                    <a href="edit.php?id=<?php echo $airplane['id']; ?>" 
                       class="btn btn-sm btn-secondary" title="Editar">
                        <i class="fa fa-pencil"></i>
                    </a>

                    <a href="#" class="btn btn-sm btn-secondary2" 
                        data-bs-toggle="modal" 
                        data-bs-target="#delete-modal" 
                        data-airplane="<?php echo $airplane['id']; ?>">
                        <i class="fa fa-trash"></i>
                    </a>
                <?php endif; ?>
            </td>

        </tr>
        <?php endforeach; ?>
    <?php else : ?>
        <tr>
            <td colspan="8">Nenhum avião cadastrado.</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>

<?php 
    include('modal.php'); 
    include(FOOTER_TEMPLATE); 
?>
