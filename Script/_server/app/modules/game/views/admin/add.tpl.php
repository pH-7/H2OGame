<?php defined('H2O') or exit('Access denied') ?>

<?php include H2O_SERVER_PATH . 'app/modules/admin/views/main/navigation.inc.tpl.php' ?>

<div class="form_container">
    <?php H2O\AddForm::display() ?>
</div>