<?php defined('H2O') or exit('Access denied') ?>

<!DOCTYPE html>
<html lang="<?php echo trans('lang') ?>">
    <head>
        <meta charset="<?php echo trans('charset') ?>" />
        <!-- Begin Title and Meta -->
        <title><?php echo $this->sTitle ?> - <?php echo $this->sSiteName ?></title>
        <meta name="description" content="<?php echo $this->sDescription ?>" />
        <meta name="keywords" content="<?php echo $this->sKeywords ?>" />
        <link rel="shortcut icon" href="<?php echo H2O_ROOT_URL ?>favicon.ico" />
        <!-- Copyright pH7 Dating/Social CMS; All Rights Reserved -->
        <meta name="author" content="<?php echo $this->sSoftAuthor ?>" />
        <meta name="creator" content="H2O CMS (Pierre-Henry Soria)" />
        <meta name="designer" content="H2O CMS (Pierre-Henry Soria)" />
        <meta name="generator" content="<?php echo $this->sSoftName, ' ', $this->sSoftVer ?>" />
        <!-- End Copyright pH7 Dating/Social CMS; All Rights Reserved -->
        <!-- End Title and Meta -->
        <!-- Begin Sheet CSS -->
        <link rel="stylesheet" href="<?php echo H2O_ROOT_URL ?>themes/<?php echo $this->sTplName ?>/css/common.css" />
        <link rel="stylesheet" href="<?php echo H2O_ROOT_URL ?>themes/<?php echo $this->sTplName ?>/css/pagination.css" />
        <link rel="stylesheet" href="<?php echo H2O_ROOT_URL ?>themes/<?php echo $this->sTplName ?>/css/alert-msg.css" />
        <link rel="stylesheet" href="<?php echo H2O_ROOT_URL ?>themes/<?php echo $this->sTplName ?>/css/js/jquery/rating.css" />
        <link rel="stylesheet" href="<?php echo H2O_ROOT_URL ?>themes/<?php echo $this->sTplName ?>/css/js/jquery/tipTip.css" />
        <link rel="stylesheet" href="<?php echo H2O_ROOT_URL ?>static/css/bootstrap.css" />
        <!-- End CSS -->
        <!-- Begin JS -->
        <script src="<?php echo H2O_ROOT_URL ?>static/js/jquery/jquery.js"></script>
        <script src="<?php echo H2O_ROOT_URL ?>static/js/bootstrap.js"></script>
        <script>var H2OUrl={base:'<?php echo H2O_ROOT_URL ?>'}</script>
        <!-- End JS -->
        <!-- Begin Analytics Code -->
        <?php if (H2O\Application::getModule() != 'install') echo (new H2O\MainModel)->getAnalytics() ?>
        <!-- End Analytics Code -->
    </head>
    <body>
        <div id="logo">
            <h1><a href="<?php echo H2O_ROOT_URL ?>"><?php echo $this->sSiteName ?></a></h1>
            <p class="italic small"><?php echo $this->sSiteSlogan ?></p>
        </div>

        <div role="main" id="container">
            <!-- Begin Header -->
            <header>
                <?php if (!empty($this->sH2Title)) echo '<h2>', $this->sH2Title, '</h2>' ?>
            </header>
            <!-- End Header -->

            <!-- Begin Content -->
            <div role="banner" class="center"><?php if (H2O\Application::getModule() != 'install' && H2O\Application::getModule() != 'admin') echo (new H2O\MainModel)->getAd(1) ?></div>
            <div role="banner" class="right"><?php if (H2O\Application::getModule() != 'install' && H2O\Application::getModule() != 'admin') echo (new H2O\MainModel)->getAd(3) ?></div>
            <?php include 'inc/success_msg.inc.php' ?>
            <?php $this->includeModule() ?>
            <div role="banner" class="center"><?php if (H2O\Application::getModule() != 'install' && H2O\Application::getModule() != 'admin') echo (new H2O\MainModel)->getAd(2) ?></div>
            <!-- End Content -->

            <!-- Begin Footer -->
            <footer >
                <div class="s_marg"></div>
                <?php $this->socialBookmark() ?>
                <?php H2O\LangForm::display($this->sCurrentLang) ?>

                <div role="contentinfo">
                    <p><strong><?php echo $this->sSiteName ?></strong> &copy; <?php echo date('Y') ?> <span role="navigation"><a href="?m=page&amp;n=privacy"><?php echo trans('Privacy Policy') ?></a> &bull; <a href="?m=page&amp;n=about"><?php echo trans('About') ?></a> &bull; <a href="?m=page&amp;n=contact"><?php echo trans('Contact') ?></a></span></p>
                    <p><?php echo trans('Powered by') ?> <strong><a href="<?php echo $this->sSoftSite ?>" title="<?php echo $this->sSoftName, ' ', $this->sSoftVer ?>"><?php echo $this->sSoftName, ' ', $this->sSoftVer ?></a></strong></p>
                </div>
            </footer>
            <!-- End Footer -->
        </div>
        <script src="<?php echo H2O_ROOT_URL ?>static/js/jquery/tipTip.js"></script>
        <script src="<?php echo H2O_ROOT_URL ?>themes/<?php echo $this->sTplName ?>/js/common.js"></script>
    </body>
</html>
