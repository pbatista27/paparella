<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cursada_estudiante".
 *
 * @property int $id
 * @property int $id_cursada Cursada
 * @property int $id_estudiante Estudiante
 *
 * @property Cursada $cursada
 * @property Usuario $estudiante
 */
class CursadaEstudiante extends \base\models\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cursada_estudiante';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_cursada', 'id_estudiante'], 'required'],
            [['id_cursada', 'id_estudiante'], 'integer'],
            [['id_cursada', 'id_estudiante'], 'unique', 'targetAttribute' => ['id_cursada', 'id_estudiante']],
            [['id_cursada'], 'exist', 'skipOnError' => true, 'targetClass' => Cursada::className(), 'targetAttribute' => ['id_cursada' => 'id']],
            [['id_estudiante'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['id_estudiante' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_cursada' => Yii::t('app', 'Cursada'),
            'id_estudiante' => Yii::t('app', 'Estudiante'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCursada()
    {
        return $this->hasOne(Cursada::className(), ['id' => 'id_cursada']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstudiante()
    {
        return $this->hasOne(Usuario::className(), ['id' => 'id_estudiante']);
    }
}
