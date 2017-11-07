<?php
/**
 * Class Flash
 *
 *  Module definition for Yii2 framework
 *
 * @category Widgets
 * @package  Manaiaklen_Widgets
 * @author   Peter Georgiev <peter.georgiev@concatel.com>
 * @license  GNU GENERAL PUBLIC LICENSE https://www.gnu.org/licenses/gpl.html
 * @link     -
 */

namespace maniakalen\widgets;

use yii\bootstrap\Html;
use yii\bootstrap\Alert as BsAlert;
use yii\bootstrap\Widget;
/**
 *
 * ```php
 * \Yii::$app->session->setFlash('error', ['Error 1', 'Error 2']);
 * ```
 * Class Flash
 *
 *  Yii2 Flash alert widget with bootstrap
 *
 * @category Widgets
 * @package  Manaiaklen_Widgets
 * @author   Peter Georgiev <peter.georgiev@concatel.com>
 * @license  GNU GENERAL PUBLIC LICENSE https://www.gnu.org/licenses/gpl.html
 * @link     -
 *
 * Based on  Antonio Ramirez Alert widget
 *
 */
class Flash extends Widget
{
    /**
     * This array is setup as $key => $value, where:
     * - $key is the name of the session flash variable
     * - $value is the bootstrap alert type (i.e. danger, success, info, warning)
     *
     * @var array the alert types configuration for the flash messages.
     */
    public $alertTypes = [
        'error'   => 'alert-danger',
        'danger'  => 'alert-danger',
        'success' => 'alert-success',
        'info'    => 'alert-info',
        'warning' => 'alert-warning'
    ];

    public $messageItemTag = 'div';

    /**
     * @var array the options for rendering the close button tag.
     */
    public $closeButton = [];

    /**
     * Alert widget content rendering
     *
     */
    public function run()
    {
        $session = \Yii::$app->session;
        $flashes = $session->getAllFlashes();
        $appendCss = isset($this->options['class']) ? ' ' . $this->options['class'] : '';

        foreach ($flashes as $type => $data) {
            if (isset($this->alertTypes[$type])) {
                $data = (array) $data;
                $this->options['class'] = $this->alertTypes[$type] . $appendCss;
                $this->options['id'] = $this->getId() . '-' . $type;
                $msgs = [];
                $itemOptions = isset($this->options['itemOptions'])?$this->options['itemOptions']:[];
                foreach ($data as $i => $message) {
                    $msgs[] = Html::beginTag($this->messageItemTag, $itemOptions)
                        . $message
                        . Html::endTag($this->messageItemTag);
                }
                echo BsAlert::widget([
                    'body' => implode("\n", $msgs),
                    'closeButton' => $this->closeButton,
                    'options' => $this->options,
                ]);
                $session->removeFlash($type);
            }
        }
    }
}
