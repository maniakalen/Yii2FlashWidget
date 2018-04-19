<?php
/**
 * Created by PhpStorm.
 * User: peter.georgiev
 * Date: 19/04/2018
 * Time: 15:37
 */

namespace maniakalen\widgets\blocks;


use yii\base\Component;
use yii\base\Model;
use maniakalen\widgets\interfaces\ActiveFormModelBlock;

abstract class ActiveFormBlockAbstract extends Component implements ActiveFormModelBlock
{
    private $owner;
    public function __construct(Model $owner)
    {
        parent::__construct();
        $this->owner = $owner;
    }
}