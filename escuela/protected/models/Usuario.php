<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usuario".
 *
 * @property int $id
 * @property int $id_perfil Perfil de usuario
 * @property int $id_nivel_instruccion Nivel de instrucción
 * @property int $id_tipo_doc Documento Legal
 * @property int $id_localidad Localidad
 * @property string $nro_documento Documento Legal
 * @property string $email Correo eléctronico
 * @property string $password Contraseña de acceso
 * @property string $auth_key Código privado de identidad
 * @property string $token Código de acceso temporal
 * @property string $imagen_personal Imagen personal
 * @property string $nombres Nombres
 * @property string $apellidos Apellidos
 * @property string $profesion Profesión u ocupación
 * @property string $codigo_postal Cogido Postal
 * @property string $direccion Dirección
 * @property string $telefono_celular teléfono celular
 * @property string $telefono_habitacion teléfono de habitación
 * @property string $facebook Facebook
 * @property string $twitter Twitter
 * @property string $instagram Instagram
 * @property string $fecha_nacimiento Fecha de nacimiento
 * @property string $fecha_registro Fecha de registro
 * @property string $fecha_edicion Fecha de ultima actualización
 * @property int $requiere_cambio_pass ¿Forzar cambio de contraseña?
 * @property int $activo ¿Usuario activo?
 *
 * @property CursadaAsistencia[] $cursadaAsistencias
 * @property Cursada[] $cursadas
 * @property CursadaCalificacion[] $cursadaCalificacions
 * @property CursadaCalificacion[] $cursadaCalificacions0
 * @property Cursada[] $cursadas0
 * @property CursadaChatMensaje[] $cursadaChatMensajes
 * @property CursadaChatMensaje[] $cursadaChatMensajes0
 * @property CursadaChatParticipante[] $cursadaChatParticipantes
 * @property CursadaDocente[] $cursadaDocentes
 * @property Cursada[] $cursadas1
 * @property CursadaEstudiante[] $cursadaEstudiantes
 * @property Cursada[] $cursadas2
 * @property CursadaGraduado[] $cursadaGraduados
 * @property Cursada[] $cursadas3
 * @property CursadaPago[] $cursadaPagos
 * @property EstudiantePreinscripcion[] $estudiantePreinscripcions
 * @property Perfil $perfil
 * @property TipoDocumentoIdentidad $tipoDoc
 * @property Localidad $localidad
 * @property UsuarioContacto $usuarioContacto
 * @property UsuarioSucursal[] $usuarioSucursals
 * @property Sucursal[] $sucursals
 */
class Usuario extends \base\models\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usuario';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_perfil', 'email', 'password', 'auth_key', 'token', 'nombres', 'apellidos'], 'required'],
            [['id_perfil', 'id_nivel_instruccion', 'id_tipo_doc', 'id_localidad', 'requiere_cambio_pass', 'activo'], 'integer'],
            [['direccion'], 'string'],
            [['fecha_nacimiento', 'fecha_registro', 'fecha_edicion'], 'safe'],
            [['nro_documento'], 'string', 'max' => 20],
            [['email'], 'string', 'max' => 100],
            [['password', 'auth_key', 'token', 'imagen_personal'], 'string', 'max' => 255],
            [['nombres', 'apellidos', 'profesion', 'telefono_celular', 'telefono_habitacion', 'facebook', 'twitter', 'instagram'], 'string', 'max' => 50],
            [['codigo_postal'], 'string', 'max' => 10],
            [['email'], 'unique'],
            [['auth_key'], 'unique'],
            [['token'], 'unique'],
            [['id_perfil'], 'exist', 'skipOnError' => true, 'targetClass' => Perfil::className(), 'targetAttribute' => ['id_perfil' => 'id']],
            [['id_tipo_doc'], 'exist', 'skipOnError' => true, 'targetClass' => TipoDocumentoIdentidad::className(), 'targetAttribute' => ['id_tipo_doc' => 'id']],
            [['id_localidad'], 'exist', 'skipOnError' => true, 'targetClass' => Localidad::className(), 'targetAttribute' => ['id_localidad' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_perfil' => Yii::t('app', 'Perfil de usuario'),
            'id_nivel_instruccion' => Yii::t('app', 'Nivel de instrucción'),
            'id_tipo_doc' => Yii::t('app', 'Documento Legal'),
            'id_localidad' => Yii::t('app', 'Localidad'),
            'nro_documento' => Yii::t('app', 'Documento Legal'),
            'email' => Yii::t('app', 'Correo eléctronico'),
            'password' => Yii::t('app', 'Contraseña de acceso'),
            'auth_key' => Yii::t('app', 'Código privado de identidad'),
            'token' => Yii::t('app', 'Código de acceso temporal'),
            'imagen_personal' => Yii::t('app', 'Imagen personal'),
            'nombres' => Yii::t('app', 'Nombres'),
            'apellidos' => Yii::t('app', 'Apellidos'),
            'profesion' => Yii::t('app', 'Profesión u ocupación'),
            'codigo_postal' => Yii::t('app', 'Cogido Postal'),
            'direccion' => Yii::t('app', 'Dirección'),
            'telefono_celular' => Yii::t('app', 'teléfono celular'),
            'telefono_habitacion' => Yii::t('app', 'teléfono de habitación'),
            'facebook' => Yii::t('app', 'Facebook'),
            'twitter' => Yii::t('app', 'Twitter'),
            'instagram' => Yii::t('app', 'Instagram'),
            'fecha_nacimiento' => Yii::t('app', 'Fecha de nacimiento'),
            'fecha_registro' => Yii::t('app', 'Fecha de registro'),
            'fecha_edicion' => Yii::t('app', 'Fecha de ultima actualización'),
            'requiere_cambio_pass' => Yii::t('app', '¿Forzar cambio de contraseña?'),
            'activo' => Yii::t('app', '¿Usuario activo?'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCursadaAsistencias()
    {
        return $this->hasMany(CursadaAsistencia::className(), ['id_estudiante' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCursadas()
    {
        return $this->hasMany(Cursada::className(), ['id' => 'id_cursada'])->viaTable('cursada_asistencia', ['id_estudiante' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCursadaCalificacions()
    {
        return $this->hasMany(CursadaCalificacion::className(), ['id_docente' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCursadaCalificacions0()
    {
        return $this->hasMany(CursadaCalificacion::className(), ['id_estudiante' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCursadas0()
    {
        return $this->hasMany(Cursada::className(), ['id' => 'id_cursada'])->viaTable('cursada_calificacion', ['id_estudiante' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCursadaChatMensajes()
    {
        return $this->hasMany(CursadaChatMensaje::className(), ['id_usuario_envia' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCursadaChatMensajes0()
    {
        return $this->hasMany(CursadaChatMensaje::className(), ['id_usuario_destino' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCursadaChatParticipantes()
    {
        return $this->hasMany(CursadaChatParticipante::className(), ['id_usuario' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCursadaDocentes()
    {
        return $this->hasMany(CursadaDocente::className(), ['id_docente' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCursadas1()
    {
        return $this->hasMany(Cursada::className(), ['id' => 'id_cursada'])->viaTable('cursada_docente', ['id_docente' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCursadaEstudiantes()
    {
        return $this->hasMany(CursadaEstudiante::className(), ['id_estudiante' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCursadas2()
    {
        return $this->hasMany(Cursada::className(), ['id' => 'id_cursada'])->viaTable('cursada_estudiante', ['id_estudiante' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCursadaGraduados()
    {
        return $this->hasMany(CursadaGraduado::className(), ['id_estudiante' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCursadas3()
    {
        return $this->hasMany(Cursada::className(), ['id' => 'id_cursada'])->viaTable('cursada_graduado', ['id_estudiante' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCursadaPagos()
    {
        return $this->hasMany(CursadaPago::className(), ['id_estudiante' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstudiantePreinscripcions()
    {
        return $this->hasMany(EstudiantePreinscripcion::className(), ['id_estudiante' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerfil()
    {
        return $this->hasOne(Perfil::className(), ['id' => 'id_perfil']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipoDoc()
    {
        return $this->hasOne(TipoDocumentoIdentidad::className(), ['id' => 'id_tipo_doc']);
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
    public function getUsuarioContacto()
    {
        return $this->hasOne(UsuarioContacto::className(), ['id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarioSucursals()
    {
        return $this->hasMany(UsuarioSucursal::className(), ['id_usuario' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSucursals()
    {
        return $this->hasMany(Sucursal::className(), ['id' => 'id_sucursal'])->viaTable('usuario_sucursal', ['id_usuario' => 'id']);
    }
}
