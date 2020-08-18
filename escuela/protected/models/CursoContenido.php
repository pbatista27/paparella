<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "curso_contenido".
 *
 * @property int $id
 * @property int $id_curso Curso
 * @property int $id_tipo_contenido Tipo de contenido
 * @property string $archivo Archivo
 * @property string $nombre
 *
 * @property Curso $curso
 * @property TipoCursoContenido $tipoContenido
 */
class CursoContenido extends \base\models\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'curso_contenido';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_curso', 'id_tipo_contenido', 'archivo', 'nombre'], 'required'],
            [['id_curso', 'id_tipo_contenido'], 'integer'],
            [['archivo', 'nombre'], 'string', 'max' => 255],
            [['archivo'], 'unique'],
            [['id_curso'], 'exist', 'skipOnError' => true, 'targetClass' => Curso::className(), 'targetAttribute' => ['id_curso' => 'id']],
            [['id_tipo_contenido'], 'exist', 'skipOnError' => true, 'targetClass' => TipoCursoContenido::className(), 'targetAttribute' => ['id_tipo_contenido' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_curso' => Yii::t('app', 'Curso'),
            'id_tipo_contenido' => Yii::t('app', 'Tipo de contenido'),
            'archivo' => Yii::t('app', 'Archivo'),
            'nombre' => Yii::t('app', 'Nombre'),
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
    public function getTipoContenido()
    {
        return $this->hasOne(TipoCursoContenido::className(), ['id' => 'id_tipo_contenido']);
    }
}
