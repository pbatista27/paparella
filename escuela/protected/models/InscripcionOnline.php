<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "inscripcion_online".
 *
 * @property int $id
 * @property int $id_curso
 * @property int $id_localidad
 * @property int $id_sucursal
 * @property string $nombres
 * @property string $apellidos
 * @property string $dni
 * @property string $email
 * @property string $direccion
 * @property string $telefono
 *
 * @property Curso $curso
 * @property Localidad $localidad
 * @property Sucursal $sucursal
 */
class InscripcionOnline extends \base\models\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'inscripcion_online';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_curso', 'id_localidad', 'id_sucursal', 'nombres', 'apellidos', 'dni', 'email', 'direccion', 'telefono'], 'required'],
            [['id_curso', 'id_localidad', 'id_sucursal'], 'integer'],
            [['nombres', 'apellidos', 'email'], 'string', 'max' => 50],
            [['dni', 'telefono'], 'string', 'max' => 20],
            [['direccion'], 'string', 'max' => 255],
            [['id_curso'], 'exist', 'skipOnError' => true, 'targetClass' => Curso::className(), 'targetAttribute' => ['id_curso' => 'id']],
            [['id_localidad'], 'exist', 'skipOnError' => true, 'targetClass' => Localidad::className(), 'targetAttribute' => ['id_localidad' => 'id']],
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
            'id_curso' => Yii::t('app', 'Id Curso'),
            'id_localidad' => Yii::t('app', 'Id Localidad'),
            'id_sucursal' => Yii::t('app', 'Id Sucursal'),
            'nombres' => Yii::t('app', 'Nombres'),
            'apellidos' => Yii::t('app', 'Apellidos'),
            'dni' => Yii::t('app', 'Dni'),
            'email' => Yii::t('app', 'Email'),
            'direccion' => Yii::t('app', 'Direccion'),
            'telefono' => Yii::t('app', 'Telefono'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurso()
    {
        return $this->hasOne(Curso::className(), ['id' => 'id_curso']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocalidad()
    {
        return $this->hasOne(Localidad::className(), ['id' => 'id_localidad']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSucursal()
    {
        return $this->hasOne(Sucursal::className(), ['id' => 'id_sucursal']);
    }
}
