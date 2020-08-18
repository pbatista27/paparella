<?php
    use yii\helpers\Html;
    use yii\helpers\Url;
    use base\widgets\dashboard\BoxNotification;
    use base\widgets\faicons\Fa;
    $module = $this->context->currentController;
?>
<div class="row">
    <?php
        // root only
        echo BoxNotification::widget([
            'icon'          => Fa::icon('check'),
            'headTitle'     => Yii::t('app', 'Administradores activos'),
            'footerTitle'   => Yii::t('app', 'Ver listado'),
            'visibility'    => Yii::$app->user->identity->isAdmin(),
            'link'          => [Url::toRoute([$module . '/admin-active']), $options=[] ],
            'count'         => $data->nro_admin_activos,
        ]);

        echo BoxNotification::widget([
            'icon'          => Fa::icon('times'),
            'headTitle'     => Yii::t('app', 'Administradores inactivos'),
            'footerTitle'   => Yii::t('app', 'Ver listado'),
            'visibility'    => Yii::$app->user->identity->isAdmin(),
            'link'          => [Url::toRoute([$module . '/admin-inactive']), $options=[] ],
            'count'         => $data->nro_admin_inactivos,
        ]);

        echo BoxNotification::widget([
            'icon'          => Fa::icon('code-fork'),
            'headTitle'     => Yii::t('app', 'Administradores sin sucursal'),
            'footerTitle'   => Yii::t('app', 'Ver listado'),
            'visibility'    => Yii::$app->user->identity->isAdmin(),
            'link'          => [Url::toRoute([$module . '/admin-sinsucursal']), $options=[] ],
            'count'         => $data->nro_admin_sinsucursal,
        ]);

        echo BoxNotification::widget([
            'icon'          => Fa::icon('user-plus'),
            'headTitle'     => Yii::t('app', 'Agregar nuevo administrador'),
            'footerTitle'   => Yii::t('app', 'Administrar'),
            'visibility'    => Yii::$app->user->identity->isAdmin(),
            'link'          => [Url::toRoute([$module . '/admin-create']), $options=[] ],
            'count'         => ''
        ]);

        // root + admin only:
        echo BoxNotification::widget([
            'icon'          => Fa::icon('check'),
            'headTitle'     => Yii::t('app', 'Docentes Activos'),
            'footerTitle'   => Yii::t('app', 'Ver listado'),
            'visibility'    => (Yii::$app->user->identity->isAdmin() || Yii::$app->user->identity->isAdminSucursal()),
            'link'          => [Url::toRoute([$module . '/doc-active']), $options=[] ],
            'count'         => $data->nro_docentes_activos,
        ]);

        echo BoxNotification::widget([
            'icon'          => Fa::icon('times'),
            'headTitle'     => Yii::t('app', 'Docentes inactivos'),
            'footerTitle'   => Yii::t('app', 'Ver listado'),
            'visibility'    => (Yii::$app->user->identity->isAdmin() || Yii::$app->user->identity->isAdminSucursal()),
            'link'          => [Url::toRoute([$module . '/doc-inactive']), $options=[] ],
            'count'         => $data->nro_docentes_inactivos,
        ]);

        echo BoxNotification::widget([
            'icon'          => Fa::icon('code-fork'),
            'headTitle'     => Yii::t('app', 'Docentes sin sucursal'),
            'footerTitle'   => Yii::t('app', 'Ver listado'),
            'visibility'    => (Yii::$app->user->identity->isAdmin() || Yii::$app->user->identity->isAdminSucursal()),
            'link'          => [Url::toRoute([$module . '/doc-sinsucursal']), $options=[] ],
            'count'         => $data->nro_docentes_sinsucursal,
        ]);

        echo BoxNotification::widget([
            'icon'          => Fa::icon('user-plus'),
            'headTitle'     => Yii::t('app', 'Agregar nuevo docente'),
            'footerTitle'   => Yii::t('app', 'Administrar'),
            'visibility'    => (Yii::$app->user->identity->isAdmin() || Yii::$app->user->identity->isAdminSucursal()),
            'link'          => [Url::toRoute([$module . '/doc-create']), $options=[] ],
            //'count'         => ''
        ]);
    ?>
</div>
