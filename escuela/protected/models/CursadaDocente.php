<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cursada_docente".
 *
 * @property int $id
 * @property int $id_cursada Cursada
 * @property int $id_docente Docente
 *
 * @property Cursada $cursada
 * @property Usuario $docente
 */
class CursadaDocente extends \base\models\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cursada_docente';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_cursada', 'id_docente'], 'required'],
            [['id_cursada', 'id_docente'], 'integer'],
            [['id_cursada', 'id_docente'], 'unique', 'targetAttribute' => ['id_cursada', 'id_docente']],
            [['id_cursada'], 'exist', 'skipOnError' => true, 'targetClass' => Cursada::className(), 'targetAttribute' => ['id_cursada' => 'id']],
            [['id_docente'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['id_docente' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_cursada' => Yii::t('app', 'Cursada'),
            'id_docente' => Yii::t('app', 'Docente'),
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
}
