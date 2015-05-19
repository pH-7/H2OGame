<?php defined('H2O') or exit('Access denied') ?>

<?php include 'navigation.inc.tpl.php' ?>

<div class="form_container">
    <?php foreach($this->oAds as $oAd): ?>
        <?php H2O\AdForm::display($oAd) ?>
    <?php endforeach ?>
</div>