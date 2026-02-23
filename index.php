<?php 
if (session_status() === PHP_SESSION_NONE) session_start();

include "config.php";
include DBAPI;
include(HEADER_TEMPLATE);
?>

<?php if (!empty($_SESSION['message'])) : ?>
    <div class="alert alert-<?php echo $_SESSION['type']; ?> alert-dismissible fade show mt-3" role="alert">
        <?php echo $_SESSION['message']; ?>
        <button class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php clear_messages(); ?>
<?php endif; ?>

<?php $db = open_database(); ?>

<?php if ($db) : ?>

<div class="dashboard-container">

    <!-- ===============================
         CLIENTES
    =============================== -->
    <div class="dashboard-group">
        <h2>Clientes</h2>
        <div class="dashboard-buttons">

            <?php if (!empty($_SESSION['id'])) : ?>
                <a href="<?php echo BASEURL; ?>customers/add.php"
                   class="btn btn-secondary">
                   <i class="fa fa-user-plus"></i> Novo Cliente
                </a>
            <?php endif; ?>

            <a href="<?php echo BASEURL; ?>customers"
               class="btn btn-light">
               <i class="fa fa-users"></i> Clientes
            </a>

        </div>
    </div>

    <!-- ===============================
         AVIÕES
    =============================== -->
    <div class="dashboard-group">
        <h2>Aviões</h2>
        <div class="dashboard-buttons">

            <?php if (!empty($_SESSION['id'])) : ?>
                <a href="<?php echo BASEURL; ?>avioes/add.php"
                   class="btn btn-secondary">
                   <i class="fa fa-plane"></i> Novo Avião
                </a>
            <?php endif; ?>

            <a href="<?php echo BASEURL; ?>avioes"
               class="btn btn-light">
               <i class="fa fa-plane-departure"></i> Aviões
            </a>

        </div>
    </div>

    <!-- ===============================
         USUÁRIOS (SOMENTE ADMIN)
    =============================== -->
    <?php if (!empty($_SESSION['nivel']) && $_SESSION['nivel'] === 'admin') : ?>
    <div class="dashboard-group">
        <h2>Usuários</h2>
        <div class="dashboard-buttons">

            <a href="<?php echo BASEURL; ?>usuarios/add.php" 
               class="btn btn-secondary">
                <i class="fa fa-user-gear"></i> Novo Usuário
            </a>

            <a href="<?php echo BASEURL; ?>usuarios"
               class="btn btn-light">
               <i class="fa fa-users-gear"></i> Gerenciar Usuários
            </a>
        </div>
    </div>
    <?php endif; ?>

</div>

<?php else : ?>

<div class="alert alert-danger" role="alert">
    <strong>ERRO:</strong> Não foi possível conectar ao Banco de Dados!
</div>

<?php endif; ?>

<?php include(FOOTER_TEMPLATE); ?>
