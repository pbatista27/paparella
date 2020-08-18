<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sucursal_estadistica".
 *
 * @property int $id
 * @property int $id_sucursal
 * @property int $nro_admin_totales
 * @property int $nro_admin_activos
 * @property int $nro_admin_inactivos
 * @property int $nro_docentes_totales
 * @property int $nro_docentes_activos
 * @property int $nro_docentes_inactivos
 * @property int $nro_estudiantes_totales
 * @property int $nro_estudiantes_activos
 * @property int $nro_estudiantes_inactivos
 * @property int $nro_estudiantes_nuevo_ingreso
 * @property int $nro_estudiantes_preinscripcion
 * @property int $nro_estudiantes_sincurso
 * @property int $nro_estudiantes_pagos_al_dia
 * @property int $nro_estudiantes_pagos_moroso
 * @property int $nro_estudiantes_cursada_cancelacion
 * @property int $nro_estudiantes_graduado
 * @property int $nro_cursos_activos
 * @property int $nro_cursos_inactivos
 * @property int $nro_cursos_sinsucursal
 * @property int $nro_nuevo_curso
 * @property int $nro_cursadas_sininiciar
 * @property int $nro_cursadas_activas
 * @property int $nro_cursadas_finalizada
 * @property string $total_pagos_realizado
 * @property string $total_pagos_vencido
 * @property string $total_pagos_devolucion
 * @property string $fecha
 *
 * @property Sucursal $sucursal
 */
class SucursalEstadistica extends \base\models\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sucursal_estadistica';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_sucursal', 'fecha'], 'required'],
            [['id_sucursal', 'nro_admin_totales', 'nro_admin_activos', 'nro_admin_inactivos', 'nro_docentes_totales', 'nro_docentes_activos', 'nro_docentes_inactivos', 'nro_estudiantes_totales', 'nro_estudiantes_activos', 'nro_estudiantes_inactivos', 'nro_estudiantes_nuevo_ingreso', 'nro_estudiantes_preinscripcion', 'nro_estudiantes_sincurso', 'nro_estudiantes_pagos_al_dia', 'nro_estudiantes_pagos_moroso', 'nro_estudiantes_cursada_cancelacion', 'nro_estudiantes_graduado', 'nro_cursos_activos', 'nro_cursos_inactivos', 'nro_cursos_sinsucursal', 'nro_nuevo_curso', 'nro_cursadas_sininiciar', 'nro_cursadas_activas', 'nro_cursadas_finalizada'], 'integer'],
            [['total_pagos_realizado', 'total_pagos_vencido', 'total_pagos_devolucion'], 'number'],
            [['fecha'], 'safe'],
            [['id_sucursal'], 'exist', 'skipOnError' => true, 'targetClass' => Sucursal::className(), 'targetAttribute' => ['id_sucursal' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_sucursal' => Yii::t('app', 'Id Sucursal'),
            'nro_admin_totales' => Yii::t('app', 'Nro Admin Totales'),
            'nro_admin_activos' => Yii::t('app', 'Nro Admin Activos'),
            'nro_admin_inactivos' => Yii::t('app', 'Nro Admin Inactivos'),
            'nro_docentes_totales' => Yii::t('app', 'Nro Docentes Totales'),
            'nro_docentes_activos' => Yii::t('app', 'Nro Docentes Activos'),
            'nro_docentes_inactivos' => Yii::t('app', 'Nro Docentes Inactivos'),
            'nro_estudiantes_totales' => Yii::t('app', 'Nro Estudiantes Totales'),
            'nro_estudiantes_activos' => Yii::t('app', 'Nro Estudiantes Activos'),
            'nro_estudiantes_inactivos' => Yii::t('app', 'Nro Estudiantes Inactivos'),
            'nro_estudiantes_nuevo_ingreso' => Yii::t('app', 'Nro Estudiantes Nuevo Ingreso'),
            'nro_estudiantes_preinscripcion' => Yii::t('app', 'Nro Estudiantes Preinscripcion'),
            'nro_estudiantes_sincurso' => Yii::t('app', 'Nro Estudiantes Sincurso'),
            'nro_estudiantes_pagos_al_dia' => Yii::t('app', 'Nro Estudiantes Pagos Al Dia'),
            'nro_estudiantes_pagos_moroso' => Yii::t('app', 'Nro Estudiantes Pagos Moroso'),
            'nro_estudiantes_cursada_cancelacion' => Yii::t('app', 'Nro Estudiantes Cursada Cancelacion'),
            'nro_estudiantes_graduado' => Yii::t('app', 'Nro Estudiantes Graduado'),
            'nro_cursos_activos' => Yii::t('app', 'Nro Cursos Activos'),
            'nro_cursos_inactivos' => Yii::t('app', 'Nro Cursos Inactivos'),
            'nro_cursos_sinsucursal' => Yii::t('app', 'Nro Cursos Sinsucursal'),
            'nro_nuevo_curso' => Yii::t('app', 'Nro Nuevo Curso'),
            'nro_cursadas_sininiciar' => Yii::t('app', 'Nro Cursadas Sininiciar'),
            'nro_cursadas_activas' => Yii::t('app', 'Nro Cursadas Activas'),
            'nro_cursadas_finalizada' => Yii::t('app', 'Nro Cursadas Finalizada'),
            'total_pagos_realizado' => Yii::t('app', 'Total Pagos Realizado'),
            'total_pagos_vencido' => Yii::t('app', 'Total Pagos Vencido'),
            'total_pagos_devolucion' => Yii::t('app', 'Total Pagos Devolucion'),
            'fecha' => Yii::t('app', 'Fecha'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSucursal()
    {
        return $this->hasOne(Sucursal::className(), ['id' => 'id_sucursal']);
    }
}
