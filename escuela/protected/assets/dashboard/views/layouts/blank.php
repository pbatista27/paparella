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
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="noindex, nofollow">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body style="display:none;">
        <div id="root-app">
            <?php $this->beginBody(); ?>
                <div id="content">

                    <div class="container">
                        <div class="row">
                            <div class="col-md-12" id="flash">
                                <?php echo Alert::widget(); ?>
                            </div>
                        </div>
                    </div>

                    <div class="container">
                        <?php echo $content ?>
                    </div>
                </div>
            <?php $this->endBody(); ?>
        <div>
    </body>
</html>
<?php $this->endPage() ?>
