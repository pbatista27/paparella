<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "localidad".
 *
 * @property int $id Identificador unico - (valor secuencial)
 * @property int $id_provincia Provincia
 * @property string $nombre Localidad
 * @property string $keyword Busqueda
 *
 * @property InscripcionOnline[] $inscripcionOnlines
 * @property Provincia $provincia
 * @property Sucursal[] $sucursals
 * @property Usuario[] $usuarios
 * @property UsuarioContacto[] $usuarioContactos
 */
class Localidad extends \base\models\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'localidad';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_provincia', 'nombre'], 'required'],
            [['id_provincia'], 'integer'],
            [['nombre'], 'string', 'max' => 50],
            [['keyword'], 'string', 'max' => 255],
            [['id_provincia'], 'exist', 'skipOnError' => true, 'targetClass' => Provincia::className(), 'targetAttribute' => ['id_provincia' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Identificador unico - (valor secuencial)'),
            'id_provincia' => Yii::t('app', 'Provincia'),
            'nombre' => Yii::t('app', 'Localidad'),
            'keyword' => Yii::t('app', 'Busqueda'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInscripcionOnlines()
    {
        return $this->hasMany(InscripcionOnline::className(), ['id_localidad' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProvincia()
    {
        return $this->hasOne(Provincia::className(), ['id' => 'id_provincia']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSucursals()
    {
        return $this->hasMany(Sucursal::className(), ['id_localidad' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarios()
    {
        return $this->hasMany(Usuario::className(), ['id_localidad' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarioContactos()
    {
        return $this->hasMany(UsuarioContacto::className(), ['id_localidad' => 'id']);
    }
}
