<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cursada".
 *
 * @property int $id
 * @property int $id_curso_sucursal
 * @property string $periodo Período electivo
 * @property string $seccion Sección
 * @property string $horario Horario
 * @property int $cantidad_meses Cantidad de meses
 * @property int $cantidad_clases Cantidad de clases
 * @property string $precio_cuota Precio de cuotas
 * @property string $precio_matricula Precio de matricula
 * @property int $nro_cupos cupos totales
 * @property int $nro_disponibles disponibles totales
 * @property string $examen Archivo
 * @property string $fecha_inicio Fecha de inicio
 * @property string $fecha_inicio_evaluacion Fecha de evaluacion
 * @property string $fecha_fin_evaluacion Fecha maxima para entrega de evaluación
 * @property string $fecha_fin Fecha de finalización
 * @property int $status 0 no inciada | 1 inciada (en curso) | 2 finalizada | 3 cancelada
 *
 * @property CursoSucursal $cursoSucursal
 * @property CursadaAsistencia[] $cursadaAsistencias
 * @property Usuario[] $estudiantes
 * @property CursadaCalificacion[] $cursadaCalificacions
 * @property Usuario[] $estudiantes0
 * @property CursadaChatMensaje[] $cursadaChatMensajes
 * @property CursadaChatParticipante[] $cursadaChatParticipantes
 * @property CursadaDocente[] $cursadaDocentes
 * @property Usuario[] $docentes
 * @property CursadaEncusta[] $cursadaEncustas
 * @property CursadaEstudiante[] $cursadaEstudiantes
 * @property Usuario[] $estudiantes1
 * @property CursadaGraduado[] $cursadaGraduados
 * @property Usuario[] $estudiantes2
 * @property CursadaHorario $cursadaHorario
 * @property CursadaPago[] $cursadaPagos
 */
class Cursada extends \base\models\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cursada';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_curso_sucursal', 'periodo', 'seccion', 'cantidad_meses', 'cantidad_clases', 'precio_cuota', 'precio_matricula', 'nro_cupos', 'fecha_inicio', 'fecha_inicio_evaluacion', 'fecha_fin_evaluacion', 'fecha_fin'], 'required'],
            [['id_curso_sucursal', 'cantidad_meses', 'cantidad_clases', 'nro_cupos', 'nro_disponibles', 'status'], 'integer'],
            [['horario'], 'string'],
            [['precio_cuota', 'precio_matricula'], 'number'],
            [['fecha_inicio', 'fecha_inicio_evaluacion', 'fecha_fin_evaluacion', 'fecha_fin'], 'safe'],
            [['periodo', 'seccion'], 'string', 'max' => 50],
            [['examen'], 'string', 'max' => 255],
            [['id_curso_sucursal', 'periodo', 'seccion'], 'unique', 'targetAttribute' => ['id_curso_sucursal', 'periodo', 'seccion']],
            [['id_curso_sucursal'], 'exist', 'skipOnError' => true, 'targetClass' => CursoSucursal::className(), 'targetAttribute' => ['id_curso_sucursal' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_curso_sucursal' => Yii::t('app', 'Id Curso Sucursal'),
            'periodo' => Yii::t('app', 'Período electivo'),
            'seccion' => Yii::t('app', 'Sección'),
            'horario' => Yii::t('app', 'Horario'),
            'cantidad_meses' => Yii::t('app', 'Cantidad de meses'),
            'cantidad_clases' => Yii::t('app', 'Cantidad de clases'),
            'precio_cuota' => Yii::t('app', 'Precio de cuotas'),
            'precio_matricula' => Yii::t('app', 'Precio de matricula'),
            'nro_cupos' => Yii::t('app', 'cupos totales'),
            'nro_disponibles' => Yii::t('app', 'disponibles totales'),
            'examen' => Yii::t('app', 'Archivo'),
            'fecha_inicio' => Yii::t('app', 'Fecha de inicio'),
            'fecha_inicio_evaluacion' => Yii::t('app', 'Fecha de evaluacion'),
            'fecha_fin_evaluacion' => Yii::t('app', 'Fecha maxima para entrega de evaluación'),
            'fecha_fin' => Yii::t('app', 'Fecha de finalización'),
            'status' => Yii::t('app', '0 no inciada | 1 inciada (en curso) | 2 finalizada | 3 cancelada'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCursoSucursal()
    {
        return $this->hasOne(CursoSucursal::className(), ['id' => 'id_curso_sucursal']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCursadaAsistencias()
    {
        return $this->hasMany(CursadaAsistencia::className(), ['id_cursada' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstudiantes()
    {
        return $this->hasMany(Usuario::className(), ['id' => 'id_estudiante'])->viaTable('cursada_asistencia', ['id_cursada' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCursadaCalificacions()
    {
        return $this->hasMany(CursadaCalificacion::className(), ['id_cursada' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstudiantes0()
    {
        return $this->hasMany(Usuario::className(), ['id' => 'id_estudiante'])->viaTable('cursada_calificacion', ['id_cursada' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCursadaChatMensajes()
    {
        return $this->hasMany(CursadaChatMensaje::className(), ['id_cursada' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCursadaChatParticipantes()
    {
        return $this->hasMany(CursadaChatParticipante::className(), ['id_cursada' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCursadaDocentes()
    {
        return $this->hasMany(CursadaDocente::className(), ['id_cursada' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocentes()
    {
        return $this->hasMany(Usuario::className(), ['id' => 'id_docente'])->viaTable('cursada_docente', ['id_cursada' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCursadaEncustas()
    {
        return $this->hasMany(CursadaEncusta::className(), ['id_cursada' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCursadaEstudiantes()
    {
        return $this->hasMany(CursadaEstudiante::className(), ['id_cursada' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstudiantes1()
    {
        return $this->hasMany(Usuario::className(), ['id' => 'id_estudiante'])->viaTable('cursada_estudiante', ['id_cursada' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCursadaGraduados()
    {
        return $this->hasMany(CursadaGraduado::className(), ['id_cursada' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstudiantes2()
    {
        return $this->hasMany(Usuario::className(), ['id' => 'id_estudiante'])->viaTable('cursada_graduado', ['id_cursada' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCursadaHorario()
    {
        return $this->hasOne(CursadaHorario::className(), ['id_cursada' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCursadaPagos()
    {
        return $this->hasMany(CursadaPago::className(), ['id_cursada' => 'id']);
    }
}
