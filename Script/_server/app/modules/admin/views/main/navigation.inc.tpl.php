<?php defined('H2O') or exit('Access denied') ?>

<nav class="box-left" role="navigation">
    <ul>
        <li><a href="?m=admin"><?php echo trans('Admin Home') ?></a></li>
        <li><a href="?m=game" title="<?php echo trans('Edit and Delete any game') ?>"><?php echo trans('Index Games') ?></a></li>
        <li><a href="?m=game&amp;c=admin&amp;a=add"><?php echo trans('Add Game') ?></a></li>
        <li><a href="?m=admin&amp;a=ads"><?php echo trans('Advertising Management') ?></a></li>
        <li><a href="?m=page&amp;c=admin"><?php echo trans('Pages Management') ?></a></li>
        <li><a href="?m=admin&amp;a=analytics"><?php echo trans('Analytics code') ?></a></li>
        <li><a href="?m=admin&amp;a=account"><?php echo trans('Edit my Account') ?></a></li>
        <li><a href="?m=admin&amp;a=password"><?php echo trans('Change my Password') ?></a></li>
        <li><a href="?m=admin&amp;a=logout"><?php echo trans('Logout') ?></a></li>
    </ul>
</nav>
