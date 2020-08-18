<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cursada_chat_participante".
 *
 * @property int $id
 * @property int $id_cursada
 * @property int $id_usuario
 * @property string $nombres nombre de participante - registro nulo hasta que se elimine un usuario
 * @property int $tipo_usuario Docente | estudiante
 * @property int $usuario_baneado
 * @property int $status 0 no iniciado | 1 activo (en curso) | 2 finalizado (solo de lectura)
 *
 * @property Cursada $cursada
 * @property Usuario $usuario
 */
class CursadaChatParticipante extends \base\models\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cursada_chat_participante';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_cursada', 'tipo_usuario'], 'required'],
            [['id_cursada', 'id_usuario', 'tipo_usuario', 'usuario_baneado', 'status'], 'integer'],
            [['nombres'], 'string', 'max' => 50],
            [['id_cursada'], 'exist', 'skipOnError' => true, 'targetClass' => Cursada::className(), 'targetAttribute' => ['id_cursada' => 'id']],
            [['id_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['id_usuario' => 'id']],
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
            'id_usuario' => Yii::t('app', 'Id Usuario'),
            'nombres' => Yii::t('app', 'nombre de participante - registro nulo hasta que se elimine un usuario'),
            'tipo_usuario' => Yii::t('app', 'Docente | estudiante'),
            'usuario_baneado' => Yii::t('app', 'Usuario Baneado'),
            'status' => Yii::t('app', '0 no iniciado | 1 activo (en curso) | 2 finalizado (solo de lectura)'),
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
    public function getUsuario()
    {
        return $this->hasOne(Usuario::className(), ['id' => 'id_usuario']);
    }
}
