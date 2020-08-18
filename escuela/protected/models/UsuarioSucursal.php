<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usuario_sucursal".
 *
 * @property int $id
 * @property int $id_usuario  pointer to usuario
 * @property int $id_sucursal  pointer to Sucursal
 *
 * @property Usuario $usuario
 * @property Sucursal $sucursal
 */
class UsuarioSucursal extends \base\models\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usuario_sucursal';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_usuario', 'id_sucursal'], 'required'],
            [['id_usuario', 'id_sucursal'], 'integer'],
            [['id_usuario', 'id_sucursal'], 'unique', 'targetAttribute' => ['id_usuario', 'id_sucursal']],
            [['id_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['id_usuario' => 'id']],
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
            'id_usuario' => Yii::t('app', ' pointer to usuario'),
            'id_sucursal' => Yii::t('app', ' pointer to Sucursal'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuario::className(), ['id' => 'id_usuario']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSucursal()
    {
        return $this->hasOne(Sucursal::className(), ['id' => 'id_sucursal']);
    }
}
