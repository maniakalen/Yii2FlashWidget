<?php
/**
 * Created by PhpStorm.
 * User: peter.georgiev
 * Date: 19/04/2018
 * Time: 10:02
 */

namespace maniakalen\widgets\interfaces;


use yii\widgets\ActiveForm;

interface ActiveFormModelBlock
{
    public function render(ActiveForm $form);
    public function process(array $data);
}