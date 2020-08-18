<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "curso".
 *
 * @property int $id
 * @property string $foto_promocional Foto promocional
 * @property string $nombre Nombre
 * @property int $cantidad_meses Cantidad de meses
 * @property int $cantidad_clases Cantidad de clases
 * @property string $precio_cuota Precio de cuotas
 * @property string $precio_matricula Precio de matricula
 * @property int $is_tmp registro temporal
 * @property string $fecha_registro Fecha de registro
 * @property string $fecha_edicion Fecha de ultima actualización
 * @property int $activo ¿Curso activo?
 *
 * @property CursoContenido[] $cursoContenidos
 * @property CursoProgramacion[] $cursoProgramacions
 * @property CursoSucursal[] $cursoSucursals
 * @property Sucursal[] $sucursals
 * @property EstudiantePreinscripcion[] $estudiantePreinscripcions
 * @property InscripcionOnline[] $inscripcionOnlines
 */
class Curso extends \base\models\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'curso';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'cantidad_meses', 'cantidad_clases', 'precio_cuota'], 'required'],
            [['cantidad_meses', 'cantidad_clases', 'is_tmp', 'activo'], 'integer'],
            [['precio_cuota', 'precio_matricula'], 'number'],
            [['fecha_registro', 'fecha_edicion'], 'safe'],
            [['foto_promocional', 'nombre'], 'string', 'max' => 255],
            [['nombre'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'foto_promocional' => Yii::t('app', 'Foto promocional'),
            'nombre' => Yii::t('app', 'Nombre'),
            'cantidad_meses' => Yii::t('app', 'Cantidad de meses'),
            'cantidad_clases' => Yii::t('app', 'Cantidad de clases'),
            'precio_cuota' => Yii::t('app', 'Precio de cuotas'),
            'precio_matricula' => Yii::t('app', 'Precio de matricula'),
            'is_tmp' => Yii::t('app', 'registro temporal'),
            'fecha_registro' => Yii::t('app', 'Fecha de registro'),
            'fecha_edicion' => Yii::t('app', 'Fecha de ultima actualización'),
            'activo' => Yii::t('app', '¿Curso activo?'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCursoContenidos()
    {
        return $this->hasMany(CursoContenido::className(), ['id_curso' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCursoProgramacions()
    {
        return $this->hasMany(CursoProgramacion::className(), ['id_curso' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCursoSucursals()
    {
        return $this->hasMany(CursoSucursal::className(), ['id_curso' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSucursals()
    {
        return $this->hasMany(Sucursal::className(), ['id' => 'id_sucursal'])->viaTable('curso_sucursal', ['id_curso' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstudiantePreinscripcions()
    {
        return $this->hasMany(EstudiantePreinscripcion::className(), ['id_curso' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInscripcionOnlines()
    {
        return $this->hasMany(InscripcionOnline::className(), ['id_curso' => 'id']);
    }
}
