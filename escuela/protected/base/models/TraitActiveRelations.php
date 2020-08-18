<?php
namespace base\models;

use app\models\CursadaAsistencia;
use app\models\Cursada;
use app\models\CursadaCalificacion;
use app\models\CursadaChatMensaje;
use app\models\CursadaChatParticipante;
use app\models\CursadaDocente;
use app\models\CursadaEstudiante;
use app\models\CursadaGraduado;
use app\models\CursadaPago;
use app\models\EstudiantePreinscripcion;
use app\models\Perfil;
use app\models\TipoDocumentoIdentidad;
use app\models\Localidad;
use app\models\UsuarioContacto;
use app\models\UsuarioSucursal;
use app\models\Sucursal;

Trait TraitActiveRelations
{
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
