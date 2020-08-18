<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "estudiante_preinscripcion".
 *
 * @property int $id
 * @property int $id_curso
 * @property int $id_sucursal
 * @property int $id_estudiante
 * @property string $fecha_registro
 *
 * @property Curso $curso
 * @property Sucursal $sucursal
 * @property Usuario $estudiante
 */
class EstudiantePreinscripcion extends \base\models\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'estudiante_preinscripcion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_curso', 'id_sucursal', 'id_estudiante'], 'required'],
            [['id_curso', 'id_sucursal', 'id_estudiante'], 'integer'],
            [['fecha_registro'], 'safe'],
            [['id_curso'], 'exist', 'skipOnError' => true, 'targetClass' => Curso::className(), 'targetAttribute' => ['id_curso' => 'id']],
            [['id_sucursal'], 'exist', 'skipOnError' => true, 'targetClass' => Sucursal::className(), 'targetAttribute' => ['id_sucursal' => 'id']],
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
            'id_curso' => Yii::t('app', 'Id Curso'),
            'id_sucursal' => Yii::t('app', 'Id Sucursal'),
            'id_estudiante' => Yii::t('app', 'Id Estudiante'),
            'fecha_registro' => Yii::t('app', 'Fecha Registro'),
        ];
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstudiante()
    {
        return $this->hasOne(Usuario::className(), ['id' => 'id_estudiante']);
    }
}
