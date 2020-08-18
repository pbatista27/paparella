<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cursada_chat_mensaje".
 *
 * @property int $id
 * @property int $id_cursada
 * @property int $id_usuario_envia
 * @property int $id_usuario_destino usuario recibe, si es nulo  y nombre_usuario_destino es nulo entonces es un mensaje publico
 * @property string $nombre_usuario_envia nombre de participante - registro nulo hasta que se elimine un usuario
 * @property string $nombre_usuario_destino nombre de participante - registro nulo hasta que se elimine un usuario
 * @property string $tipo_mensaje T : text; para futuro A : audio, V = video ; F archivo : I Imagen
 * @property string $mensaje
 * @property int $leido
 * @property string $fecha_envio
 * @property string $hora_envio
 *
 * @property Cursada $cursada
 * @property Usuario $usuarioEnvia
 * @property Usuario $usuarioDestino
 */
class CursadaChatMensaje extends \base\models\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cursada_chat_mensaje';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_cursada'], 'required'],
            [['id', 'id_cursada', 'id_usuario_envia', 'id_usuario_destino', 'leido'], 'integer'],
            [['mensaje'], 'string'],
            [['fecha_envio', 'hora_envio'], 'safe'],
            [['nombre_usuario_envia', 'nombre_usuario_destino'], 'string', 'max' => 50],
            [['tipo_mensaje'], 'string', 'max' => 1],
            [['id'], 'unique'],
            [['id_cursada'], 'exist', 'skipOnError' => true, 'targetClass' => Cursada::className(), 'targetAttribute' => ['id_cursada' => 'id']],
            [['id_usuario_envia'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['id_usuario_envia' => 'id']],
            [['id_usuario_destino'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['id_usuario_destino' => 'id']],
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
            'id_usuario_envia' => Yii::t('app', 'Id Usuario Envia'),
            'id_usuario_destino' => Yii::t('app', 'usuario recibe, si es nulo  y nombre_usuario_destino es nulo entonces es un mensaje publico'),
            'nombre_usuario_envia' => Yii::t('app', 'nombre de participante - registro nulo hasta que se elimine un usuario'),
            'nombre_usuario_destino' => Yii::t('app', 'nombre de participante - registro nulo hasta que se elimine un usuario'),
            'tipo_mensaje' => Yii::t('app', 'T : text; para futuro A : audio, V = video ; F archivo : I Imagen'),
            'mensaje' => Yii::t('app', 'Mensaje'),
            'leido' => Yii::t('app', 'Leido'),
            'fecha_envio' => Yii::t('app', 'Fecha Envio'),
            'hora_envio' => Yii::t('app', 'Hora Envio'),
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
    public function getUsuarioEnvia()
    {
        return $this->hasOne(Usuario::className(), ['id' => 'id_usuario_envia']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarioDestino()
    {
        return $this->hasOne(Usuario::className(), ['id' => 'id_usuario_destino']);
    }
}
