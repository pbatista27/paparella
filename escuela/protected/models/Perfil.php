<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "perfil".
 *
 * @property int $id Identificador unico - (valor secuencial)
 * @property string $codigo Perfil -- (debe ser unico en toda la columna)
 *
 * @property Usuario[] $usuarios
 */
class Perfil extends \base\models\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'perfil';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codigo'], 'required'],
            [['codigo'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Identificador unico - (valor secuencial)'),
            'codigo' => Yii::t('app', 'Perfil -- (debe ser unico en toda la columna)'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarios()
    {
        return $this->hasMany(Usuario::className(), ['id_perfil' => 'id']);
    }
}
