<?php
# siteController
$rules['']															= '/site/index';
$rules['salir']														= '/site/logout';
$rules['recobrar-credenciales']										= '/site/recovery';
#accountController
$rules['mi-cuenta']													= '/account/index';
$rules['mi-cuenta/datos-basicos']									= '/account/datos-basicos';
$rules['mi-cuenta/persona-de-contacto'] 							= '/account/persona-contacto';
$rules['mi-cuenta/redes-sociales']									= '/account/redes-sociales';
$rules['mi-cuenta/cambiar-clave']									= '/account/cambiar-password';
$rules['mi-cuenta/datos-de-contacto']								= '/account/datos-contacto';
#modules profiles
$rules['/root/estadisticas']										= '/root/estadisticas/index';
$rules['/admin/estadisticas']										= '/admin/estadisticas/index';
$rules['/docentes/estadisticas']									= '/docentes/estadisticas/index';
$rules['/estudiantes/estadisticas']									= '/estudiantes/estadisticas/index';
$rules['/leo-paparella/estadisticas']								= '/leo-paparella/estadisticas/index';
#modulo personal:
$rules['/root/personal-administrativo']								= '/root/personal-administrativo/index';
#cursos
$rules['root/cursos']												= '/cursos/default/index';
$rules['root/cursos/<id:\d+>/datos-basicos']						= '/cursos/default/update';
$rules['root/cursos/<id:\d+>/programacion']							= '/cursos/default/programacion';
$rules['root/cursos/<id:\d+>/examenes']								= '/cursos/default/examenes';
$rules['root/cursos/<id:\d+>/material/programa']					= '/cursos/default/material-programa';
$rules['root/cursos/<id:\d+>/material/docentes']					= '/cursos/default/material-docentes';
$rules['root/cursos/<id:\d+>/material/estudiantes']					= '/cursos/default/material-estudiantes';
$rules['root/cursos/<id:\d+>/sucursales-activas']					= '/cursos/default/sucursales-activas';
$rules['root/cursos/<id:\d+>/status-sucursal']						= '/cursos/default/status-sucursal';
$rules['root/cursos/nuevo']											= '/cursos/create/index';
$rules['root/cursos/nuevo/programacion']							= '/cursos/create/programacion';
$rules['root/cursos/nuevo/examenes']								= '/cursos/create/examenes';
$rules['root/cursos/nuevo/material/programa']						= '/cursos/create/material-programa';
$rules['root/cursos/nuevo/material/docentes']						= '/cursos/create/material-docente';
$rules['root/cursos/nuevo/material/estudiantes']					= '/cursos/create/material-estudiante';
$rules['root/cursos/nuevo/sucursales-activas']						= '/cursos/create/sucursales';
$rules['root/cursos/nuevo/cancelar']								= '/cursos/create/cancel';
$rules['root/cursos/descargar-material/<id:\d+>']					= '/cursos/download/index';
#cursadas
$rules['cursadas/<idSucursal:\d+>/por-iniciar']						= '/cursadas/default/por-iniciar';
$rules['cursadas/<idSucursal:\d+>/en-curso']						= '/cursadas/default/en-curso';
$rules['cursadas/<idSucursal:\d+>/finalizas']						= '/cursadas/default/finalizadas';
$rules['cursadas/<idSucursal:\d+>/canceladas']						= '/cursadas/default/canceladas';
$rules['cursadas/<idSucursal:\d+>/nueva']							= '/cursadas/create/index';
$rules['cursadas/<idSucursal:\d+>/nueva/horarios']					= '/cursadas/create/horarios';
$rules['cursadas/<idSucursal:\d+>/nueva/evaluacion']				= '/cursadas/create/evaluacion';
return $rules;
