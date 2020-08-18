<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cursada_encusta".
 *
 * @property int $id
 * @property int $id_cursada
 * @property int $id_estudiante
 * @property int $nivel_formacion Nivel de formacion
 * @property int $desempeno_docente Desempeno docente
 * @property int $clima_clase Clima de la clase
 * @property int $instalaciones Instalciones
 * @property string $comentario Comentario
 *
 * @property Cursada $cursada
 */
class CursadaEncusta extends \base\models\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cursada_encusta';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_cursada', 'id_estudiante'], 'required'],
            [['id_cursada', 'id_estudiante', 'nivel_formacion', 'desempeno_docente', 'clima_clase', 'instalaciones'], 'integer'],
            [['comentario'], 'string'],
            [['id_cursada', 'id_estudiante'], 'unique', 'targetAttribute' => ['id_cursada', 'id_estudiante']],
            [['id_cursada'], 'exist', 'skipOnError' => true, 'targetClass' => Cursada::className(), 'targetAttribute' => ['id_cursada' => 'id']],
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
            'nivel_formacion' => Yii::t('app', 'Nivel de formacion'),
            'desempeno_docente' => Yii::t('app', 'Desempeno docente'),
            'clima_clase' => Yii::t('app', 'Clima de la clase'),
            'instalaciones' => Yii::t('app', 'Instalciones'),
            'comentario' => Yii::t('app', 'Comentario'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCursada()
    {
        return $this->hasOne(Cursada::className(), ['id' => 'id_cursada']);
    }
}
