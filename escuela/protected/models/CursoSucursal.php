<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "curso_sucursal".
 *
 * @property int $id
 * @property int $id_curso  pointer to curso
 * @property int $id_sucursal  pointer to Sucursal
 *
 * @property Cursada[] $cursadas
 * @property Curso $curso
 * @property Sucursal $sucursal
 */
class CursoSucursal extends \base\models\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'curso_sucursal';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_curso', 'id_sucursal'], 'required'],
            [['id_curso', 'id_sucursal'], 'integer'],
            [['id_curso', 'id_sucursal'], 'unique', 'targetAttribute' => ['id_curso', 'id_sucursal']],
            [['id_curso'], 'exist', 'skipOnError' => true, 'targetClass' => Curso::className(), 'targetAttribute' => ['id_curso' => 'id']],
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
            'id_curso' => Yii::t('app', ' pointer to curso'),
            'id_sucursal' => Yii::t('app', ' pointer to Sucursal'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCursadas()
    {
        return $this->hasMany(Cursada::className(), ['id_curso_sucursal' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurso()
    {
        return $this->hasOne(Curso::className(), ['id' => 'id_curso']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSucursal()
    {
        return $this->hasOne(Sucursal::className(), ['id' => 'id_sucursal']);
    }
}
