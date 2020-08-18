<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usuario_contacto".
 *
 * @property int $id
 * @property int $id_localidad Localidad
 * @property string $nombres Nombres
 * @property string $apellidos Apellidos
 * @property string $relacion Profesión u ocupación
 * @property string $codigo_postal Cogido Postal
 * @property string $direccion Dirección
 * @property string $telefono_celular teléfono celular
 * @property string $telefono_habitacion teléfono de habitación
 * @property string $fecha_nacimiento Fecha de nacimiento
 *
 * @property Usuario $id0
 * @property Localidad $localidad
 */
class UsuarioContacto extends \base\models\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usuario_contacto';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_localidad'], 'integer'],
            [['direccion'], 'string'],
            [['fecha_nacimiento'], 'safe'],
            [['nombres', 'apellidos', 'relacion', 'telefono_celular', 'telefono_habitacion'], 'string', 'max' => 50],
            [['codigo_postal'], 'string', 'max' => 10],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['id' => 'id']],
            [['id_localidad'], 'exist', 'skipOnError' => true, 'targetClass' => Localidad::className(), 'targetAttribute' => ['id_localidad' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_localidad' => Yii::t('app', 'Localidad'),
            'nombres' => Yii::t('app', 'Nombres'),
            'apellidos' => Yii::t('app', 'Apellidos'),
            'relacion' => Yii::t('app', 'Profesión u ocupación'),
            'codigo_postal' => Yii::t('app', 'Cogido Postal'),
            'direccion' => Yii::t('app', 'Dirección'),
            'telefono_celular' => Yii::t('app', 'teléfono celular'),
            'telefono_habitacion' => Yii::t('app', 'teléfono de habitación'),
            'fecha_nacimiento' => Yii::t('app', 'Fecha de nacimiento'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getId0()
    {
        return $this->hasOne(Usuario::className(), ['id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocalidad()
    {
        return $this->hasOne(Localidad::className(), ['id' => 'id_localidad']);
    }
}
