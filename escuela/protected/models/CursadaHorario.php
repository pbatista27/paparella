<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cursada_horario".
 *
 * @property int $id_cursada
 * @property string $d1_desde Inicio
 * @property string $d1_hasta Fin
 * @property string $d1_aula Aula (opcional)
 * @property string $d2_desde Inicio
 * @property string $d2_hasta Fin
 * @property string $d2_aula Aula (opcional)
 * @property string $d3_desde Inicio
 * @property string $d3_hasta Fin
 * @property string $d3_aula Aula (opcional)
 * @property string $d4_desde Inicio
 * @property string $d4_hasta Fin
 * @property string $d4_aula Aula (opcional)
 * @property string $d5_desde Inicio
 * @property string $d5_hasta Fin
 * @property string $d5_aula Aula (opcional)
 * @property string $d6_desde Inicio
 * @property string $d6_hasta Fin
 * @property string $d6_aula Aula (opcional)
 * @property string $d7_desde Inicio
 * @property string $d7_hasta Fin
 * @property string $d7_aula Aula (opcional)
 * @property string $fechas_excluidas
 *
 * @property Cursada $cursada
 */
class CursadaHorario extends \base\models\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cursada_horario';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_cursada'], 'required'],
            [['id_cursada'], 'integer'],
            [['d1_desde', 'd1_hasta', 'd2_desde', 'd2_hasta', 'd3_desde', 'd3_hasta', 'd4_desde', 'd4_hasta', 'd5_desde', 'd5_hasta', 'd6_desde', 'd6_hasta', 'd7_desde', 'd7_hasta'], 'safe'],
            [['fechas_excluidas'], 'string'],
            [['d1_aula', 'd2_aula', 'd3_aula', 'd4_aula', 'd5_aula', 'd6_aula', 'd7_aula'], 'string', 'max' => 20],
            [['id_cursada'], 'unique'],
            [['id_cursada'], 'exist', 'skipOnError' => true, 'targetClass' => Cursada::className(), 'targetAttribute' => ['id_cursada' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_cursada' => Yii::t('app', 'Id Cursada'),
            'd1_desde' => Yii::t('app', 'Inicio'),
            'd1_hasta' => Yii::t('app', 'Fin'),
            'd1_aula' => Yii::t('app', 'Aula (opcional)'),
            'd2_desde' => Yii::t('app', 'Inicio'),
            'd2_hasta' => Yii::t('app', 'Fin'),
            'd2_aula' => Yii::t('app', 'Aula (opcional)'),
            'd3_desde' => Yii::t('app', 'Inicio'),
            'd3_hasta' => Yii::t('app', 'Fin'),
            'd3_aula' => Yii::t('app', 'Aula (opcional)'),
            'd4_desde' => Yii::t('app', 'Inicio'),
            'd4_hasta' => Yii::t('app', 'Fin'),
            'd4_aula' => Yii::t('app', 'Aula (opcional)'),
            'd5_desde' => Yii::t('app', 'Inicio'),
            'd5_hasta' => Yii::t('app', 'Fin'),
            'd5_aula' => Yii::t('app', 'Aula (opcional)'),
            'd6_desde' => Yii::t('app', 'Inicio'),
            'd6_hasta' => Yii::t('app', 'Fin'),
            'd6_aula' => Yii::t('app', 'Aula (opcional)'),
            'd7_desde' => Yii::t('app', 'Inicio'),
            'd7_hasta' => Yii::t('app', 'Fin'),
            'd7_aula' => Yii::t('app', 'Aula (opcional)'),
            'fechas_excluidas' => Yii::t('app', 'Fechas Excluidas'),
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
