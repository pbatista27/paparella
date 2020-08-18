<?php
namespace controllers\configuracion\models;

use Yii;
use yii\base\Model;

class VideoPromocional extends \app\models\Config
{
    public function rules()
    {
        return [
            [['youtube'], 'required'],
            [['youtube'], 'url'],
            ['youtube',   'match','pattern'=>'/^(https?:\/\/)?(www\.)?(youtube.com)\/?(watch\?)?v=[a-zA-Z0-9(\.\?)?]/'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'youtube' => Yii::t('app', 'Youtube'),
        ];
    }

    public function delete()
    {
        return false;
    }

    public function save($validate = false, $attributes =  [])
    {
        if($this->isNewRecord)
            return false;

        return parent::update($validate, ['youtube']);
    }
}
