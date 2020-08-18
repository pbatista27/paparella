<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tipo_numero_telefonico".
 *
 * @property int $id
 * @property string $nombre
 * @property int $tiene_extension
 *
 * @property Sucursal[] $sucursals
 * @property Sucursal[] $sucursals0
 */
class TipoNumeroTelefonico extends \base\models\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tipo_numero_telefonico';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['tiene_extension'], 'integer'],
            [['nombre'], 'string', 'max' => 50],
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
            'nombre' => Yii::t('app', 'Nombre'),
            'tiene_extension' => Yii::t('app', 'Tiene Extension'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSucursals()
    {
        return $this->hasMany(Sucursal::className(), ['id_tipo_num1' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSucursals0()
    {
        return $this->hasMany(Sucursal::className(), ['id_tipo_num2' => 'id']);
    }
}
