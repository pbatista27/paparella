<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tipo_curso_contenido".
 *
 * @property int $id
 * @property string $codigo
 * @property string $icon_class
 *
 * @property CursoContenido[] $cursoContenidos
 */
class TipoCursoContenido extends \base\models\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tipo_curso_contenido';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codigo'], 'required'],
            [['codigo', 'icon_class'], 'string', 'max' => 50],
            [['codigo'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'codigo' => Yii::t('app', 'Codigo'),
            'icon_class' => Yii::t('app', 'Icon Class'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCursoContenidos()
    {
        return $this->hasMany(CursoContenido::className(), ['id_tipo_contenido' => 'id']);
    }
}
