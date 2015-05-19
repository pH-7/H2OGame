<?php defined('H2O') or exit('Access denied') ?>

<?php if (!empty($this->sErrMsg)): ?>
    <?php echo $this->sErrMsg ?>
<?php else: ?>

    <div class="box-left">

        <div role="search" class="design-box">
            <h3><?php echo trans('Search') ?></h3>
            <?php H2O\SearchForm::display(true) ?>
        </div>

        <div class="design-box">
            <h3><?php echo trans('Categories') ?></h3>
            <ul>
                <?php foreach($this->oCategories as $oCategory): ?>
                    <li><a href="?m=game&amp;a=category&amp;name=<?php echo H2O\Url::encode($oCategory->name) ?>" title="<?php echo $oCategory->name ?>"><?php echo $oCategory->name ?></a> - (<?php echo $oCategory->totalCatGames ?>)</li>
                <?php endforeach ?>
            </ul>
        </div>

        <div class="design-box">
            <h3><?php echo trans('Top Popular') ?></h3>
            <ul>
                <?php foreach($this->oTopViews as $oViews): ?>
                    <li><a href="?m=game&amp;a=game&amp;id=<?php echo $oViews->gameId ?>" title="<?php echo $oViews->name ?>"><?php echo $oViews->title ?></a></li>
                <?php endforeach ?>
            </ul>
        </div>

        <div class="design-box">
            <h3><?php echo trans('Top Rated') ?></h3>
            <ul>
                <?php foreach($this->oTopRating as $oRating): ?>
                    <li><a href="?m=game&amp;a=game&amp;id=<?php echo $oRating->gameId ?>" title="<?php echo $oRating->name ?>"><?php echo $oRating->title ?></a></li>
                <?php endforeach ?>
            </ul>
        </div>

        <div class="design-box">
            <h3><?php echo trans('Newest') ?></h3>
            <ul>
                <?php foreach($this->oLatest as $oNew): ?>
                    <li><a href="?m=game&amp;a=game&amp;id=<?php echo $oNew->gameId ?>" title="<?php echo $oNew->name ?>"><?php echo $oNew->title ?></a></li>
                <?php endforeach ?>
            </ul>
        </div>

    </div>

    <div class="center box-right">
        <?php foreach($this->oGames as $oGame): ?>
            <?php if (is_file(H2O_PUBLIC_DATA_PATH . 'game/img/thumb/' . $oGame->thumb) && is_file(H2O_PUBLIC_DATA_PATH . 'game/file/' . $oGame->file)): ?>
                <h3><a href="?m=game&amp;a=game&amp;id=<?php echo $oGame->gameId ?>"><?php echo $oGame->title ?></a></h3>
                <div class="content">
                    <p><a href="?m=game&amp;a=game&amp;id=<?php echo $oGame->gameId ?>" rel="nofollow"><img alt="<?php echo $oGame->title ?>" title="<?php echo $oGame->title ?>" src="<?php echo H2O_PUBLIC_DATA_URL ?>game/img/thumb/<?php echo $oGame->thumb ?>" width="95" height="66" class="thumb_img" /></a></p>
                    <p><strong><?php echo $oGame->title ?></strong></p>
                    <p><?php echo $oGame->description ?></p>

                    <?php if (H2O\Admin::auth()): ?>
                        <div>
                            <a class="m_button" href="?m=game&amp;c=admin&amp;a=update&amp;id=<?php echo $oGame->gameId ?>"><?php echo trans('Edit') ?></a> | <form class="form_link" action="?m=game&amp;c=admin&amp;a=remove" method="post" onsubmit="return confirm('<?php echo trans('Are you sure to delete this game?') ?>')"><input type="hidden" name="id" value="<?php echo $oGame->gameId ?>" /><span class="m_button"><input type="submit" value="<?php echo trans('Delete') ?>" /></span></form>
                        </div>
                    <?php endif ?>
                    <hr />
                </div>
            <?php endif ?>
        <?php endforeach ?>
    </div>

<?php endif ?>

 <?php include H2O_ROOT_PATH . 'themes/' . $this->sTplName . '/tpl/inc/pagination.inc.tpl.php' ?>
