# yii2-widgets
PHP yii2 widgets

A small (at the moment) set of widgets for yii2 UI build


### Modal confirm Bootstrap dialog

To invoke the modal confirm dialog use:

    confirmModal({json config}).done(&lt;done callback&gt;).fail(&lt;fail callback&gt;);

possible config json params are:
   
    - id - This one is mandatory
    - title - optional - default: Confirm an action
    - content - optional - default: Are you sure you want to proceed with this action?
    - titleOk - optional - default: Yes
    - titleCancel - optional - default: No