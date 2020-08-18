<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tipo_documento_identidad".
 *
 * @property int $id
 * @property string $codigo
 * @property string $descripcion
 *
 * @property Usuario[] $usuarios
 */
class TipoDocumentoIdentidad extends \base\models\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tipo_documento_identidad';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codigo'], 'required'],
            [['codigo', 'descripcion'], 'string', 'max' => 50],
            [['codigo'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'codigo' => Yii::t('app', 'Codigo'),
            'descripcion' => Yii::t('app', 'Descripcion'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarios()
    {
        return $this->hasMany(Usuario::className(), ['id_tipo_doc' => 'id']);
    }
}
