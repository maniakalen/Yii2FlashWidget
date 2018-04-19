<?php
/**
 * Created by PhpStorm.
 * User: peter.georgiev
 * Date: 27/02/2018
 * Time: 9:24
 */

namespace maniakalen\widgets;


use maniakalen\widgets\interfaces\ActiveFormModel;
use maniakalen\widgets\interfaces\ActiveFormModelBlock;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

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

    public $submitButton = [
        'label' => 'Save',
        'options' => ['class' => 'btn btn-success'],
        'permission' => false,
    ];

    public $resetButton = [
        'label' => 'Cancel',
        'options' => ['class' => 'btn btn-danger'],
        'permission' => false,
    ];
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
        $blocks = $this->model->getFormBlocks();
        if (!empty($blocks)) {
            foreach ($blocks as $block) {
                if ($block instanceof ActiveFormModelBlock) {
                    echo $block->render($this);
                }
            }
        }
        $submitPermission = ArrayHelper::remove($this->submitButton, 'permission', false);
        if (!$submitPermission || \Yii::$app->user->can($submitPermission)) {
            $submitLabel = ArrayHelper::remove($this->submitButton, 'label', 'Save');
            $submitOptions = ArrayHelper::remove($this->submitButton, 'options', ['class' => 'btn btn-primary']);
            echo Html::submitInput($submitLabel, $submitOptions);
        }
        $resetPermission = ArrayHelper::remove($this->resetButton, 'permission', false);
        if (!$resetPermission || \Yii::$app->user->can($resetPermission)) {
            $resetLabel = ArrayHelper::remove($this->resetButton, 'label', 'Save');
            $resetOptions = ArrayHelper::remove($this->resetButton, 'options', ['class' => 'btn btn-danger']);
            echo Html::resetInput($resetLabel, $resetOptions);
        }
        return parent::run();
    }
}