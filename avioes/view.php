<?php 
    require_once "../config.php";
    require_once "functions.php"; 

    view($_GET['id']);
    include(HEADER_TEMPLATE); 
?>

<h2><i class="fa fa-plane"></i> Avião <?php echo $airplane['id']; ?></h2>
<hr>

<?php if (!empty($_SESSION['message'])) : ?>
    <div class="alert alert-<?php echo $_SESSION['type']; ?> alert-dismissible fade show" role="alert">
        <?php echo $_SESSION['message']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-md-8">
        <dl class="row">
            <dt class="col-sm-4">Prefixo:</dt>
            <dd class="col-sm-8"><?php echo $airplane['prefix']; ?></dd>

            <dt class="col-sm-4">Modelo:</dt>
            <dd class="col-sm-8"><?php echo $airplane['model']; ?></dd>

            <dt class="col-sm-4">Fabricante:</dt>
            <dd class="col-sm-8"><?php echo $airplane['manufacturer']; ?></dd>

            <dt class="col-sm-4">Tripulação:</dt>
            <dd class="col-sm-8"><?php echo $airplane['crew']; ?></dd>

            <dt class="col-sm-4">Data de Fabricação:</dt>
            <dd class="col-sm-8"><?php echo formataData($airplane['manufacture_date'], "d/m/Y"); ?></dd>

            <dt class="col-sm-4">Cadastrado em:</dt>
            <dd class="col-sm-8"><?php echo formataData($airplane['created'], "d/m/Y H:i:s"); ?></dd>

            <dt class="col-sm-4">Última atualização:</dt>
            <dd class="col-sm-8"><?php echo formataData($airplane['modified'], "d/m/Y H:i:s"); ?></dd>
        </dl>
    </div>

    <div class="col-md-4 text-center">
        <?php if (!empty($airplane['image'])): ?>
            <img src="/crud-bootstrap-php/assets/avioes/<?php echo $airplane['image']; ?>" 
                 alt="Foto do avião" 
                 class="img-fluid rounded shadow-sm border"
                 style="max-width: 100%; height: auto;">
        <?php else: ?>
            <p class="text-muted">Sem foto</p>
        <?php endif; ?>
    </div>
</div>

<div id="actions" class="row mt-4">
    <div class="col-md-12">

        <!-- 🔒 Só mostra EDITAR se usuário estiver logado -->
        <?php if (!empty($_SESSION['id'])): ?>
            <a href="edit.php?id=<?php echo $airplane['id']; ?>" class="btn btn-secondary">
                <i class="fa fa-pencil"></i> Editar
            </a>
        <?php endif; ?>

        <a href="index.php" class="btn btn-light">
            <i class="fa fa-arrow-left"></i> Voltar
        </a>
    </div>
</div>

<?php include(FOOTER_TEMPLATE); ?>
