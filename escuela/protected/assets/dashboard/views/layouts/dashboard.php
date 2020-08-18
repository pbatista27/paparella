<?php
    use app\widgets\Alert;
    use yii\helpers\Json;
    use yii\helpers\Url;
    use yii\helpers\Html;
    use yii\bootstrap\Nav;
    use yii\bootstrap\NavBar;
    use yii\widgets\Breadcrumbs;
    use app\assets\dashboard\DashoardAsset;
    use yii\widgets\Pjax;

    #custom widgets
    use base\widgets\faicons\Fa;

    DashoardAsset::register($this);
    $this->registerJs('(function(){modal.setLoginUrl("'. Url::toRoute(['/site/login']) .'");})();', $this::POS_READY);

    if(Yii::$app->requestedRoute == 'site/index')
        $this->registerJs('(function(){ if(sessionStorage.getItem("menu") != null) sessionStorage.removeItem("menu"); })()', $this::POS_HEAD);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="noindex, nofollow">
        <script> paceOptions = {ajax: {trackMethods: ['GET', 'POST']}}; </script>
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body style="display:none;">

        <div id="root-app">
            <?php $this->beginBody(); ?>
            <!--primaryMenu-->
            <nav id="header" class=" navbar navbar-inverse navbar-fixed-top">
                <div class="container-fluid">
                    <div id="header-logo" class="navbar-header">
                        <a href="<?=  Yii::$app->homeUrl ?>" class="navbar-brand">
                            <?=
                                Html::img(Yii::getAlias('@web/images/dashboard/header-logo.png'), [
                                    'alt'    => Yii::$app->name,
                                    'title'  => Yii::$app->name,
                                ]);
                            ?>
                        </a>
                    </div>

                    <a href="#" id="button-menu" class="hidden-md hidden-lg">
                        <?= Fa::icon('bars') ?>
                    </a>
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <?php
                                $label = Fa::icon('sign-out')->fw();
                                $label.= sprintf('<span class="hidden-xs hidden-sm hidden-md">%s</span>', Yii::t('app', 'Salir'));
                                echo Html::a($label, Url::toRoute(['/site/logout']), [
                                    'data-pjax'             => 0,
                                    'data-title-confirm'    => Yii::t('app', 'Confirmación'),
                                    'data-text-confirm'     => Yii::t('app', '¿Está seguro que desea salir?'),
                                    'data-runtime'          => 'ajax-confirm',
                                    'data-label-btn-cancel' => Yii::t('yii', 'No'),
                                    'data-label-btn-ok'     => Yii::t('yii', 'Yes'),
                                ]);
                            ?>
                        </li>
                    </ul>
                </div>
            </nav>

            <nav id="column-left">
                <?php
                    echo Nav::widget([
                        'id'            => 'menu',
                        'dropDownCaret' => '',
                        'items' => [
                           $this->render('partial/profile'),
                           $this->render('partial/menu'),
                        ]
                    ]);
                ?>
            </nav>
                <div id="content">
                    <div class="page-header">
                        <div class="container-fluid">
                            <div style="padding-top:6px; margin-bottom:-7px; padding-left:7px;">
                                <h1 id="header-title"><?= Html::encode($this->H1); ?></h1>
                                <div>
                                    <?=
                                        Breadcrumbs::widget([
                                            'homeLink'  => Yii::$app->defaultRoute == $this->context->id  ? false : null,
                                            'links'     => isset($this->breadcrumbs) ? $this->breadcrumbs : [],
                                        ]);
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12" id="flash">
                                <?php echo Alert::widget(); ?>
                            </div>
                        </div>
                    </div>

                    <div class="container-fluid">
                        <?php echo $content ?>
                    </div>
                </div>
            <?php $this->endBody(); ?>
        <div>
    </body>
</html>
<?php $this->endPage() ?>
