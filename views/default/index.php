<?php
/**
 * @author edoardo849 <edoardo.s@daviom.com>
 * @copyright Copyright &copy; Daviom 2011-2013
 * Date: 2/19/13 - 11:52 AM
 */


$this->widget('application.modules.d_export.components.exportWidget.ExportWidget',
array(
    'searchFormId'=>'test',
    'model'=>User::model()
)
);
?>
