<?php
/**
 * Created by PhpStorm.
 * User: peter.georgiev
 * Date: 27/02/2018
 * Time: 9:24
 */

namespace maniakalen\widgets;


use maniakalen\widgets\interfaces\ActiveFormModel;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class ActiveForm extends \yii\widgets\ActiveForm
{
    const FIELD_TYPE_TEXTAREA = 'textarea';
    const FIELD_TYPE_TEXT = 'text';
    const FIELD_TYPE_HIDDEN = 'hidden';
    const FIELD_TYPE_PASSWORD = 'password';
    const FIELD_TYPE_FILE = 'file';
    const FIELD_TYPE_DROPDOWN = 'dropDown';
    const FIELD_TYPE_CHECKBOX = 'checkbox';
    const FIELD_TYPE_CHECKBOX_LIST = 'checkboxList';
    const FIELD_TYPE_RADIO = 'radio';
    const FIELD_TYPE_RADIO_GROUP = 'radioGroup';
    /** @var Model $model */
    public $model;

    /**
     * @return string
     * @throws \ErrorException
     */
    public function run()
    {
        if (!($this->model instanceof ActiveFormModel) || !($this->model instanceof Model)) {
            throw new \InvalidArgumentException("Model object invalid");
        }

        $fields = $this->model->getFieldsSignature();
        foreach ($fields as $attr => $signature) {
            if (($type = ArrayHelper::remove($signature, 'type', false)) === false) {
                throw new \InvalidArgumentException("Invalid signature config for attr: $attr");
            }
            $options = ArrayHelper::remove($signature, 'options', []);
            $fieldOptions = ArrayHelper::remove($signature, 'fieldOptions', []);
            switch ($type) {
                case static::FIELD_TYPE_TEXTAREA:
                    echo $this->field($this->model, $attr, $fieldOptions)->textarea($options);
                    break;
                case static::FIELD_TYPE_DROPDOWN:
                    $list = ArrayHelper::remove($signature, 'items', []);
                    echo $this->field($this->model, $attr, $fieldOptions)->dropDownList($list, $options);
                    break;
                case static::FIELD_TYPE_CHECKBOX_LIST:
                    $list = ArrayHelper::remove($signature, 'items', []);
                    echo $this->field($this->model, $attr, $fieldOptions)->checkboxList($list, $options);
                    break;
                case static::FIELD_TYPE_CHECKBOX:
                    echo $this->field($this->model, $attr, $fieldOptions)->checkbox($options);
                    break;
                case static::FIELD_TYPE_RADIO:
                    echo $this->field($this->model, $attr, $fieldOptions)->radio($options);
                    break;
                case static::FIELD_TYPE_RADIO_GROUP:
                    $list = ArrayHelper::remove($signature, 'items', []);
                    echo $this->field($this->model, $attr, $fieldOptions)->radioList($list, $options);
                    break;
                case static::FIELD_TYPE_TEXT:
                case static::FIELD_TYPE_FILE:
                case static::FIELD_TYPE_PASSWORD:
                case static::FIELD_TYPE_HIDDEN:
                    echo $this->field($this->model, $attr, $fieldOptions)->input($type, $options);
                    break;
                default:
                    throw new \ErrorException("Unsupported field type");
            }
        }

        return parent::run();
    }
}