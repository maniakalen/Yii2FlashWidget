<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace maniakalen\widgets;

use yii\bootstrap\Html;
use yii\bootstrap\Alert as BsAlert;
use yii\bootstrap\Widget;
/**
 * Alert widget renders a message from session flash. All flash messages are displayed
 * in the sequence they were assigned using setFlash. You can set message as following:
 *
 * ```php
 * \Yii::$app->session->setFlash('error', 'This is the message');
 * \Yii::$app->session->setFlash('success', 'This is the message');
 * \Yii::$app->session->setFlash('info', 'This is the message');
 * ```
 *
 * Multiple messages could be set as follows:
 *
 * ```php
 * \Yii::$app->session->setFlash('error', ['Error 1', 'Error 2']);
 * ```
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @author Alexander Makarov <sam@rmcreative.ru>
 */
class Flash extends Widget
{
    /**
     * @var array the alert types configuration for the flash messages.
     * This array is setup as $key => $value, where:
     * - $key is the name of the session flash variable
     * - $value is the bootstrap alert type (i.e. danger, success, info, warning)
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
