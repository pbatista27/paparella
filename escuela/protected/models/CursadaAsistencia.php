<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cursada_asistencia".
 *
 * @property int $id
 * @property int $id_cursada
 * @property int $id_estudiante
 * @property int $c1 C1
 * @property int $c2 C2
 * @property int $c3 C3
 * @property int $c4 C4
 * @property int $c5 C5
 * @property int $c6 C6
 * @property int $c7 C7
 * @property int $c8 C8
 * @property int $c9 C9
 * @property int $c10 C10
 * @property int $c11 C11
 * @property int $c12 C12
 * @property int $c13 C13
 * @property int $c14 C14
 * @property int $c15 C15
 * @property int $c16 C16
 * @property int $c17 C17
 * @property int $c18 C18
 * @property int $c19 C19
 * @property int $c20 C20
 * @property int $c21 C21
 * @property int $c22 C22
 * @property int $c23 C23
 * @property int $c24 C24
 * @property int $c25 C25
 * @property int $c26 C26
 * @property int $c27 C27
 * @property int $c28 C28
 * @property int $c29 C29
 * @property int $c30 C30
 * @property int $c31 C31
 * @property int $c32 C32
 * @property int $c33 C33
 * @property int $c34 C34
 * @property int $c35 C35
 * @property int $c36 C36
 *
 * @property Cursada $cursada
 * @property Usuario $estudiante
 */
class CursadaAsistencia extends \base\models\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cursada_asistencia';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_cursada', 'id_estudiante'], 'required'],
            [['id_cursada', 'id_estudiante', 'c1', 'c2', 'c3', 'c4', 'c5', 'c6', 'c7', 'c8', 'c9', 'c10', 'c11', 'c12', 'c13', 'c14', 'c15', 'c16', 'c17', 'c18', 'c19', 'c20', 'c21', 'c22', 'c23', 'c24', 'c25', 'c26', 'c27', 'c28', 'c29', 'c30', 'c31', 'c32', 'c33', 'c34', 'c35', 'c36'], 'integer'],
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
            'id_cursada' => Yii::t('app', 'Id Cursada'),
            'id_estudiante' => Yii::t('app', 'Id Estudiante'),
            'c1' => Yii::t('app', 'C1'),
            'c2' => Yii::t('app', 'C2'),
            'c3' => Yii::t('app', 'C3'),
            'c4' => Yii::t('app', 'C4'),
            'c5' => Yii::t('app', 'C5'),
            'c6' => Yii::t('app', 'C6'),
            'c7' => Yii::t('app', 'C7'),
            'c8' => Yii::t('app', 'C8'),
            'c9' => Yii::t('app', 'C9'),
            'c10' => Yii::t('app', 'C10'),
            'c11' => Yii::t('app', 'C11'),
            'c12' => Yii::t('app', 'C12'),
            'c13' => Yii::t('app', 'C13'),
            'c14' => Yii::t('app', 'C14'),
            'c15' => Yii::t('app', 'C15'),
            'c16' => Yii::t('app', 'C16'),
            'c17' => Yii::t('app', 'C17'),
            'c18' => Yii::t('app', 'C18'),
            'c19' => Yii::t('app', 'C19'),
            'c20' => Yii::t('app', 'C20'),
            'c21' => Yii::t('app', 'C21'),
            'c22' => Yii::t('app', 'C22'),
            'c23' => Yii::t('app', 'C23'),
            'c24' => Yii::t('app', 'C24'),
            'c25' => Yii::t('app', 'C25'),
            'c26' => Yii::t('app', 'C26'),
            'c27' => Yii::t('app', 'C27'),
            'c28' => Yii::t('app', 'C28'),
            'c29' => Yii::t('app', 'C29'),
            'c30' => Yii::t('app', 'C30'),
            'c31' => Yii::t('app', 'C31'),
            'c32' => Yii::t('app', 'C32'),
            'c33' => Yii::t('app', 'C33'),
            'c34' => Yii::t('app', 'C34'),
            'c35' => Yii::t('app', 'C35'),
            'c36' => Yii::t('app', 'C36'),
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
