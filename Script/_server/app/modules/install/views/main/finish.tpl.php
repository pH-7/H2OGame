<?php defined('H2O') or exit('Access denied') ?>

<p class="bold"><?php echo trans('Hooray! Your site has been successfully installed') ?></p>
<p class="bold italic"><?php echo trans('Two thing to do before visiting your site') ?></p>
<ol>
    <li><?php echo trans('For security reasons, please remove the following folder: %0%', H2O_SERVER_PATH . 'app' . H2O_DS . 'modules' . H2O_DS . 'install' . H2O_DS) ?></li>
    <li><?php echo trans('Download your games %0% and unzip the zip archive into the following directory: %1%', '<a href="http://software.hizup.com/web/h2ogamedata">' . trans('here') . '</a>', H2O_ROOT_PATH) ?></li>
</ol>
<p><a href="<?php echo H2O_ROOT_URL ?>"><?php echo trans('If you have completed both steps above, go to your site') ?></a></p>