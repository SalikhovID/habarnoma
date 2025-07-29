<?php


use frontend\assets\AppAsset;
use frontend\components\Breadcrumbs;
use frontend\components\SidebarMenu;
use yii\bootstrap5\Html;

/**
 * @property string $content
 */
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <link rel="icon" href="/img/kaiadmin/favicon.ico" type="image/x-icon"/>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport"/>
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode(Yii::$app->name) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Fonts and icons -->
    <script src="/js/plugin/webfont/webfont.min.js"></script>
    <script>
        WebFont.load({
            google: {families: ["Public Sans:300,400,500,600,700"]},
            custom: {
                families: [
                    "Font Awesome 5 Solid",
                    "Font Awesome 5 Regular",
                    "Font Awesome 5 Brands",
                    "simple-line-icons",
                ],
                urls: ["/css/fonts.min.css"],
            },
            active: function () {
                sessionStorage.fonts = true;
            },
        });
    </script>
</head>
<body>
<?php $this->beginBody() ?>
<div class="wrapper">
    <!-- Sidebar -->
    <div class="sidebar" data-background-color="dark">
        <div class="sidebar-logo">
            <!-- Logo Header -->
            <div class="logo-header" data-background-color="dark">
                <a href="/" class="logo">
                    <img src="/img/logo.svg" alt="navbar brand" class="navbar-brand" height="37%"/>
                </a>
                <div class="nav-toggle">
                    <button class="btn btn-toggle toggle-sidebar">
                        <i class="gg-menu-right"></i>
                    </button>
                    <button class="btn btn-toggle sidenav-toggler">
                        <i class="gg-menu-left"></i>
                    </button>
                </div>
                <button class="topbar-toggler more">
                    <i class="gg-more-vertical-alt"></i>
                </button>
            </div>
            <!-- End Logo Header -->
        </div>
        <div class="sidebar-wrapper scrollbar scrollbar-inner">
            <div class="sidebar-content">
                <?=SidebarMenu::widget([
                    'items' => [
                        ['label' => Yii::t('app','Home'), 'url' => ['site/index'], 'icon' => 'fa-th-list'],
                        [
                            'label' => Yii::t('app','Events'),
                            'url' => ['event/index'],
                            'icon' => 'fa-building',
                            'active' => Yii::$app->controller->id == 'event',
                        ],
                        ['label' => Yii::t('app','Settings'), 'url' => ['profile/settings'], 'icon' => 'fa-cog'],
                    ],
                ])?>
            </div>
        </div>
    </div>
    <!-- End Sidebar -->

    <div class="main-panel">
        <div class="main-header">
            <div class="main-header-logo">
                <!-- Logo Header -->
                <div class="logo-header" data-background-color="dark">
                    <a href="../index.html" class="logo">
                        <img src="/img/logo.svg" alt="navbar brand" class="navbar-brand" height="20"/>
                    </a>
                    <div class="nav-toggle">
                        <button class="btn btn-toggle toggle-sidebar">
                            <i class="gg-menu-right"></i>
                        </button>
                        <button class="btn btn-toggle sidenav-toggler">
                            <i class="gg-menu-left"></i>
                        </button>
                    </div>
                    <button class="topbar-toggler more">
                        <i class="gg-more-vertical-alt"></i>
                    </button>
                </div>
                <!-- End Logo Header -->
            </div>
            <!-- Navbar Header -->
            <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
                <div class="container-fluid">
                    <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                        <li class="nav-item topbar-user dropdown hidden-caret">
                            <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#" aria-expanded="false">
                                <div class="avatar-sm">
                                    <img src="/img/profile.jpg" alt="..." class="avatar-img rounded-circle"/>
                                </div>
                                <span class="profile-username">
                                  <span class="fw-bold"><?=Yii::$app->user->identity?->fullname?></span>
                                </span>
                            </a>
                            <ul class="dropdown-menu dropdown-user animated fadeIn">
                                <div class="dropdown-user-scroll scrollbar-outer">
                                    <li>
                                        <div class="user-box">
                                            <div class="avatar-lg">
                                                <img src="/img/profile.jpg" alt="image profile" class="avatar-img rounded"/>
                                            </div>
                                            <div class="u-text">
                                                <h4><?=Yii::$app->user->identity?->fullname?></h4>
                                                <p class="text-muted"><?=Yii::$app->user->identity?->username?></p>
                                                <!--                                                <a href="profile.html" class="btn btn-xs btn-secondary btn-sm">View Profile</a>-->
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                        <!--                                        <a class="dropdown-item" href="#">My Profile</a>-->
                                        <!--                                        <a class="dropdown-item" href="#">My Balance</a>-->
                                        <!--                                        <a class="dropdown-item" href="#">Inbox</a>-->
                                        <!--                                        <div class="dropdown-divider"></div>-->
                                        <?= Html::a(Yii::t('app', 'Account Setting'), ['profile/settings'], ['class' => 'dropdown-item']) ?>
                                        <div class="dropdown-divider"></div>
                                        <?= Html::a(Yii::t('app', 'Logout'), ['site/logout'], ['data-method' => 'post', 'class' => 'dropdown-item']) ?>
                                    </li>
                                </div>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
            <!-- End Navbar -->
        </div>

        <div class="container">
            <div class="page-inner">
                <?= Breadcrumbs::widget([
                    'links' => $this->params['breadcrumbs'] ?? [],
                ]) ?>
                <?= $content ?>
            </div>
        </div>
    </div>
</div>
<?php $this->endBody() ?>
<?php if(Yii::$app->session->hasFlash('success')):?>
    <script>
        $.notify({
            message: "<?=Yii::$app->session->getFlash('success')?>",
            title: "<?=Yii::t('app', 'Habarnoma notification')?>",
            icon: "fa fa-bell"
        }, {delay: 100});
    </script>
<?php endif;?>
</body>
</html>
<?php $this->endPage() ?>
