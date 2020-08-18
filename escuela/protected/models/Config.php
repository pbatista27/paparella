<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "config".
 *
 * @property int $id
 * @property string $nombre
 * @property string $facebook
 * @property string $youtube
 * @property string $instagram
 * @property string $quienes_somos
 * @property int $en_mantenimiento
 */
class Config extends \base\models\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'config';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'facebook', 'youtube', 'instagram', 'quienes_somos'], 'required'],
            [['quienes_somos'], 'string'],
            [['en_mantenimiento'], 'integer'],
            [['nombre', 'facebook', 'youtube', 'instagram'], 'string', 'max' => 255],
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
            'facebook' => Yii::t('app', 'Facebook'),
            'youtube' => Yii::t('app', 'Youtube'),
            'instagram' => Yii::t('app', 'Instagram'),
            'quienes_somos' => Yii::t('app', 'Quienes Somos'),
            'en_mantenimiento' => Yii::t('app', 'En Mantenimiento'),
        ];
    }
}
