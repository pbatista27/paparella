<?php
namespace base\widgets\faicons;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
/*
    example
    echo Fa::icon('user')
        ->inverse()
        ->size('2x');

*/
class Fa extends \Yii\base\Component
{
    public $options;
    public $name;
    public $content;
    public $tagName = 'i';

    public function init()
    {
        Html::addCssClass($this->options, 'fa');
        Html::addCssClass($this->options, 'fa-' . $this->name);
    }

    public function __toString()
    {
        return Html::tag($this->tagName, $this->content, $this->options);
    }

    public function size($value)
    {
        $value = strtolower($value);
        $list  = [ '2x', '3x', '4x', '5x', 'lg'];

        if(in_array($value, $list))
            Html::addCssClass($this->options, 'fa-' . $value);

        return $this;
    }

    public function inverse()
    {
        Html::addCssClass($this->options, 'fa-inverse');
        return $this;
    }

    public function spin()
    {
        Html::addCssClass($this->options, 'fa-spin');
        return $this;
    }

    public function pulse()
    {
        Html::addCssClass($this->options, 'fa-pulse');
        return $this;
    }

    public function fw()
    {
        Html::addCssClass($this->options, 'fa-fw');
        return $this;
    }

    public function border()
    {
        Html::addCssClass($this->options, 'fa-border');
        return $this;
    }

    public function pullLeft()
    {
        Html::addCssClass($this->options, 'fa-pull-left');
        return $this;
    }

    public function pullRight()
    {
        Html::addCssClass($this->options, 'fa-pull-right');
        return $this;
    }

    public function rotate($value)
    {
        $list = [90,180,270];

        if(in_array($value, $list))
            Html::addCssClass($this->options, 'fa-rotate-' . $value);

        return $this;
    }

    public function flipHorizontal()
    {
        Html::addCssClass($this->options, 'fa-flip-horizontal');
        return $this;
    }

    public function flipVertical()
    {
        Html::addCssClass($this->options, 'fa-flip-vertical');
        return $this;
    }

    public static function icon($name, $options = [], $tagName = 'i', $content = '')
    {
        return Yii::createObject([
            'class'   => static::className(),
            'name'    => $name,
            'options' => $options,
            'tagName' => $tagName,
            'content' => null,
        ]);
    }
}
