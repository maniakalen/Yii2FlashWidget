<?php
/**
 * @package maniakalen\widgets
 * @category widgets
 * @version 1.1.12
 */

namespace maniakalen\widgets;

/**
 * Class ActiveField
 *
 * ActiveField model class to provide the funcionality to filter fields by permission.
 *
 * In order to use in active form you need to define the field like this:
 *
 * $form->field($model, 'attr', [..., 'permission' => 'required-permission'])->...
 */
class ActiveField extends \yii\widgets\ActiveField
{
    public $permission;
    public function render($content = null)
    {
        if (!$this->permission || \Yii::$app->user->can($this->permission)) {
            return parent::render($content);
        }

        return '';
    }
}