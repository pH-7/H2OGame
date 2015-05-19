<?php defined('H2O') or exit('Access denied') ?>

<?php echo (new H2O\Pagination($this->iTotalPages, $this->iCurrentPage))->getHtmlCode() ?>