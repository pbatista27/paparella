<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "curso_programacion".
 *
 * @property int $id
 * @property int $id_curso Curso
 * @property string $titulo Titulo de objetivo
 * @property string $descripcion Descripción
 * @property int $nro_dias
 *
 * @property Curso $curso
 */
class CursoProgramacion extends \base\models\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'curso_programacion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_curso', 'titulo', 'descripcion'], 'required'],
            [['id_curso', 'nro_dias'], 'integer'],
            [['descripcion'], 'string'],
            [['titulo'], 'string', 'max' => 50],
            [['id_curso'], 'exist', 'skipOnError' => true, 'targetClass' => Curso::className(), 'targetAttribute' => ['id_curso' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_curso' => Yii::t('app', 'Curso'),
            'titulo' => Yii::t('app', 'Titulo de objetivo'),
            'descripcion' => Yii::t('app', 'Descripción'),
            'nro_dias' => Yii::t('app', 'Nro Dias'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurso()
    {
        return $this->hasOne(Curso::className(), ['id' => 'id_curso']);
    }
}
