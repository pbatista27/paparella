<?php

return [
	'mailer' => [
		'host'			=> 'mail.paparella.tk',
		'usernameSend'	=> Yii::t('app','Escuela Leo Paparella'),
		'username'		=> 'soporte@paparella.tk',
		'password'		=> 'XaXsCdVf.88',
		'port'			=> '465',
		'encryption'	=> 'tls',
	],
	'httpErrors' => [
		'400' => \Yii::t('app', 'Petición invalida.'),
		'403' => \Yii::t('app', 'Sin permisos para visualizar este contenido.'),
		'404' => \Yii::t('app', 'Contenido no existe ó previamente ha sido elimindo.'),
		'500' => \Yii::t('app', 'Contenido no disponible.'),
	],
];


