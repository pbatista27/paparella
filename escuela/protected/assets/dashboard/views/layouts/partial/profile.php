<?php
	use yii\helpers\Html;
	use yii\widgets\Pjax;
	use yii\helpers\Url;
	use base\widgets\faicons\Fa;

	$username = Html::encode(Yii::$app->user->identity->getUsername());
	$image    = Yii::$app->user->identity->getAvatar();
?>
<li id="profile">
    <?php
        Pjax::begin([
            'id' => 'menu-item-avatar-content',
            'enablePushState' => false,
        ]);
    ?>
    <img id="img-menu-avatar" src="<?= $image ?>" alt="<?= $username ?>" data-role="open-modal" data-href="<?= Url::toRoute(['/account/datos-basicos']); ?>">
    <span class="username">
    	<?= $username ?>
    </span>
    <a data-role="open-modal" href="<?= Url::toRoute(['/account/index']); ?>" class="avatar-link-edit">
        <i class="fa fa-edit"></i>
    </a>
    <?php Pjax::end() ?>
</li>

