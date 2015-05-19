<?php defined('H2O') or exit('Access denied') ?>

<h3><?php echo $this->sName ?></h3>

<script src="<?php echo H2O_ROOT_URL ?>static/js/flash.js"></script>
<script>pH7DisplayFlash("<?php echo $this->sFullFile ?>", 730, 550);</script>

<p><?php echo $this->sDescription ?></p>

<?php if (H2O\Admin::auth()): ?>
    <div>
        <a class="m_button" href="?m=game&amp;c=admin&amp;a=update&amp;id=<?php echo $this->iId ?>"><?php echo trans('Edit') ?></a> | <form class="form_link" action="?m=game&amp;c=admin&amp;a=remove" method="post" onsubmit="return confirm('<?php echo trans('Are you sure to delete this game?') ?>')"><input type="hidden" name="id" value="<?php echo $this->iId ?>" /><span class="m_button"><input type="submit" value="<?php echo trans('Delete') ?>" /></span></form>
    </div>
<?php endif ?>

<p><a class="m_button" href="?m=game&a=download&id=<?php echo $this->iId ?>"><?php echo trans('Download Game') ?></a></p>
<p class="italic"><?php echo trans('%0% was played %1% and download %2%', '<strong>'.$this->sTitle.'</strong>', '<strong>'.$this->sStats.'</strong>', '<strong>'.$this->sDownloads.'</strong>') ?></p>
<?php echo $this->sVotes ?>
<?php H2O\ShareUrlForm::display() ?>
<?php H2O\ShareEmbedForm::display($this->sFullFile) ?>
