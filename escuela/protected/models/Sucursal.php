<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sucursal".
 *
 * @property int $id Identificador unico - (valor secuencial)
 * @property int $id_localidad
 * @property int $id_tipo_num1 Tipo de num. teléfonico
 * @property int $id_tipo_num2 Tipo de num. teléfonico
 * @property string $numero1 num. teléfonico
 * @property string $extension1 num. extensión
 * @property string $numero2 num. teléfonico
 * @property string $extension2 num. extensión
 * @property string $nombre Sucursal -- (debe ser unico en toda la columna)
 * @property string $direccion
 * @property string $codigo_postal Cogido Postal
 * @property string $email
 * @property string $fecha_registro Fecha de registro
 * @property string $fecha_edicion Fecha de ultima actualización
 * @property int $activo ¿Sucursal activa?
 *
 * @property CursoSucursal[] $cursoSucursals
 * @property Curso[] $cursos
 * @property EstudiantePreinscripcion[] $estudiantePreinscripcions
 * @property InscripcionOnline[] $inscripcionOnlines
 * @property Localidad $localidad
 * @property TipoNumeroTelefonico $tipoNum1
 * @property TipoNumeroTelefonico $tipoNum2
 * @property SucursalEstadistica[] $sucursalEstadisticas
 * @property UsuarioSucursal[] $usuarioSucursals
 * @property Usuario[] $usuarios
 */
class Sucursal extends \base\models\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sucursal';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_localidad', 'nombre', 'direccion'], 'required'],
            [['id_localidad', 'id_tipo_num1', 'id_tipo_num2', 'activo'], 'integer'],
            [['direccion'], 'string'],
            [['fecha_registro', 'fecha_edicion'], 'safe'],
            [['numero1', 'numero2'], 'string', 'max' => 20],
            [['extension1', 'extension2'], 'string', 'max' => 5],
            [['nombre', 'email'], 'string', 'max' => 50],
            [['codigo_postal'], 'string', 'max' => 10],
            [['nombre'], 'unique'],
            [['id_localidad'], 'exist', 'skipOnError' => true, 'targetClass' => Localidad::className(), 'targetAttribute' => ['id_localidad' => 'id']],
            [['id_tipo_num1'], 'exist', 'skipOnError' => true, 'targetClass' => TipoNumeroTelefonico::className(), 'targetAttribute' => ['id_tipo_num1' => 'id']],
            [['id_tipo_num2'], 'exist', 'skipOnError' => true, 'targetClass' => TipoNumeroTelefonico::className(), 'targetAttribute' => ['id_tipo_num2' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Id'),
            'id_localidad' => Yii::t('app', 'Localidad'),
            'id_tipo_num1' => Yii::t('app', 'Tipo de num. teléfonico'),
            'id_tipo_num2' => Yii::t('app', 'Tipo de num. teléfonico'),
            'numero1' => Yii::t('app', 'Num. teléfonico'),
            'extension1' => Yii::t('app', 'Num. extensión'),
            'numero2' => Yii::t('app', 'Num. teléfonico'),
            'extension2' => Yii::t('app', 'Num. extensión'),
            'nombre' => Yii::t('app', 'Nombre'),
            'direccion' => Yii::t('app', 'Direccion'),
            'codigo_postal' => Yii::t('app', 'Cógido Postal'),
            'email' => Yii::t('app', 'Email'),
            'fecha_registro' => Yii::t('app', 'Fecha de registro'),
            'fecha_edicion' => Yii::t('app', 'Fecha de ultima actualización'),
            'activo' => Yii::t('app', '¿Sucursal activa?'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCursoSucursals()
    {
        return $this->hasMany(CursoSucursal::className(), ['id_sucursal' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCursos()
    {
        return $this->hasMany(Curso::className(), ['id' => 'id_curso'])->viaTable('curso_sucursal', ['id_sucursal' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstudiantePreinscripcions()
    {
        return $this->hasMany(EstudiantePreinscripcion::className(), ['id_sucursal' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInscripcionOnlines()
    {
        return $this->hasMany(InscripcionOnline::className(), ['id_sucursal' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocalidad()
    {
        return $this->hasOne(Localidad::className(), ['id' => 'id_localidad']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipoNum1()
    {
        return $this->hasOne(TipoNumeroTelefonico::className(), ['id' => 'id_tipo_num1']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipoNum2()
    {
        return $this->hasOne(TipoNumeroTelefonico::className(), ['id' => 'id_tipo_num2']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSucursalEstadisticas()
    {
        return $this->hasMany(SucursalEstadistica::className(), ['id_sucursal' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarioSucursals()
    {
        return $this->hasMany(UsuarioSucursal::className(), ['id_sucursal' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarios()
    {
        return $this->hasMany(Usuario::className(), ['id' => 'id_usuario'])->viaTable('usuario_sucursal', ['id_sucursal' => 'id']);
    }
}
