<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cursada_calificacion".
 *
 * @property int $id
 * @property int $id_cursada
 * @property int $id_docente Docente  que hizo la evaluacion
 * @property string $nombres_docente Docente  que hizo la evaluacion -- solo cuando elimino un registro del tipo docente
 * @property int $id_estudiante Estudiante evaluado
 * @property string $archivo Archivo subido por el estudiante
 * @property string $fecha_subida
 * @property int $aprobado
 * @property int $status 0 no evaludado | 1 evaludado
 *
 * @property Cursada $cursada
 * @property Usuario $docente
 * @property Usuario $estudiante
 */
class CursadaCalificacion extends \base\models\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cursada_calificacion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_cursada', 'id_estudiante'], 'required'],
            [['id_cursada', 'id_docente', 'id_estudiante', 'aprobado', 'status'], 'integer'],
            [['fecha_subida'], 'safe'],
            [['nombres_docente', 'archivo'], 'string', 'max' => 255],
            [['id_cursada', 'id_estudiante'], 'unique', 'targetAttribute' => ['id_cursada', 'id_estudiante']],
            [['id_cursada'], 'exist', 'skipOnError' => true, 'targetClass' => Cursada::className(), 'targetAttribute' => ['id_cursada' => 'id']],
            [['id_docente'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['id_docente' => 'id']],
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
            'id_docente' => Yii::t('app', 'Docente  que hizo la evaluacion'),
            'nombres_docente' => Yii::t('app', 'Docente  que hizo la evaluacion -- solo cuando elimino un registro del tipo docente'),
            'id_estudiante' => Yii::t('app', 'Estudiante evaluado'),
            'archivo' => Yii::t('app', 'Archivo subido por el estudiante'),
            'fecha_subida' => Yii::t('app', 'Fecha Subida'),
            'aprobado' => Yii::t('app', 'Aprobado'),
            'status' => Yii::t('app', '0 no evaludado | 1 evaludado'),
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
    public function getDocente()
    {
        return $this->hasOne(Usuario::className(), ['id' => 'id_docente']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstudiante()
    {
        return $this->hasOne(Usuario::className(), ['id' => 'id_estudiante']);
    }
}
