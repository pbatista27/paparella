<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cursada_pago".
 *
 * @property int $id
 * @property int $id_cursada
 * @property int $id_estudiante
 * @property array $datos_estudiantes datos basicos de un estudiante -- solo cuando se elimina el registro estudiante 
 * @property string $tipo_pago MC:MAtricula + primera cuota, C: cuota
 * @property int $nro_pago
 * @property string $info Información  adicional del pago
 * @property string $motivo_cobro
 * @property string $subtotal
 * @property string $fecha_cobro
 * @property string $fecha_pago
 * @property int $status 0 no pagado | 1 pagado | 2 devolucion | 3 cancelacion
 *
 * @property Cursada $cursada
 * @property Usuario $estudiante
 */
class CursadaPago extends \base\models\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cursada_pago';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_cursada', 'nro_pago', 'subtotal'], 'required'],
            [['id_cursada', 'id_estudiante', 'nro_pago', 'status'], 'integer'],
            [['datos_estudiantes', 'fecha_cobro', 'fecha_pago'], 'safe'],
            [['subtotal'], 'number'],
            [['tipo_pago'], 'string', 'max' => 2],
            [['info'], 'string', 'max' => 255],
            [['motivo_cobro'], 'string', 'max' => 50],
            [['id_cursada', 'id_estudiante', 'nro_pago'], 'unique', 'targetAttribute' => ['id_cursada', 'id_estudiante', 'nro_pago']],
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
            'datos_estudiantes' => Yii::t('app', 'datos basicos de un estudiante -- solo cuando se elimina el registro estudiante '),
            'tipo_pago' => Yii::t('app', 'MC:MAtricula + primera cuota, C: cuota'),
            'nro_pago' => Yii::t('app', 'Nro Pago'),
            'info' => Yii::t('app', 'Información  adicional del pago'),
            'motivo_cobro' => Yii::t('app', 'Motivo Cobro'),
            'subtotal' => Yii::t('app', 'Subtotal'),
            'fecha_cobro' => Yii::t('app', 'Fecha Cobro'),
            'fecha_pago' => Yii::t('app', 'Fecha Pago'),
            'status' => Yii::t('app', '0 no pagado | 1 pagado | 2 devolucion | 3 cancelacion'),
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
