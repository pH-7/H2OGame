<?php defined('H2O') or exit('Access denied') ?>

<p><strong><?php echo trans('Sorry, it is a Bad Request') ?></strong></p>
<p><strong><em><?php echo trans('Suggestions') ?></em></strong></p>

<ul>
  <li><a href="<?php echo H2O_ROOT_URL ?>"><?php echo trans('Main Page') ?></a></li>
  <li><a href="javascript:void(0);" onclick="history.go(-1);"><?php echo trans('Go back to the previous page') ?></a></li>
</ul>