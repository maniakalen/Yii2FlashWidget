<?php
/**
 * PHP Version 5.5
 *
 *  DESCRIPTION
 *
 * @category Category
 * @package  Package
 * @author   Peter Georgiev <peter.georgiev@concatel.com>
 * @license  GNU GENERAL PUBLIC LICENSE https://www.gnu.org/licenses/gpl.html
 * @link     LINK
 */

namespace maniakalen\widgets;

use yii\web\AssetBundle;

/**
 * Class ConfirmModalAsset
 *
 *  CLASSDESCRIPTION
 *
 * @category CATEGORY
 * @package  PACKAGE
 * @author   Peter Georgiev <peter.georgiev@concatel.com>
 * @license  GNU GENERAL PUBLIC LICENSE https://www.gnu.org/licenses/gpl.html
 * @link     -
 */
class ConfirmModalAsset extends AssetBundle
{
    public function init()
    {
        \Yii::setAlias('maniakalen\widgets', __DIR__);
        parent::init();
    }

    public $sourcePath = '@maniakalen\widgets/resources';

    public $js = [
        'js/confirm_modal.js',
    ];
    public $css = [
        'css/confirm_modal.css',
    ];
}