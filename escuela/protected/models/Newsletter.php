<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "newsletter".
 *
 * @property int $id ID
 * @property string $nombre Nombres
 * @property string $apellido Apellidos
 * @property string $email Correo eléctronico
 * @property string $telefono Telefono
 * @property string $fecha_registro
 */
class Newsletter extends \base\models\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'newsletter';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email'], 'required'],
            [['fecha_registro'], 'safe'],
            [['nombre', 'apellido', 'email', 'telefono'], 'string', 'max' => 50],
            [['email'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'nombre' => Yii::t('app', 'Nombres'),
            'apellido' => Yii::t('app', 'Apellidos'),
            'email' => Yii::t('app', 'Correo eléctronico'),
            'telefono' => Yii::t('app', 'Telefono'),
            'fecha_registro' => Yii::t('app', 'Fecha Registro'),
        ];
    }
}
