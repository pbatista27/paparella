<?php

namespace controllers\configuracion\models;

use Yii;
use yii\base\Model;

class RedesSociales extends \app\models\Config
{
    public function rules()
    {
        return [
            [['facebook', 'instagram'], 'required'],
            [['facebook', 'instagram'], 'url'],
            ['facebook','match','pattern'=>'/^(https?:\/\/)?(www\.)?facebook.com\/[a-zA-Z0-9(\.\?)?]/'],
            ['instagram','match','pattern'=>'/^(https?:\/\/)?(www\.)?instagram.com\/[a-zA-Z0-9(\.\?)?]/'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'facebook' => Yii::t('app', 'Facebook'),
            'instagram' => Yii::t('app', 'Instagram'),
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

        return parent::update($validate, ['facebook', 'instagram']);
    }
}
