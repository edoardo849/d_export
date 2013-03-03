<?php
/**
 * @author edoardo849 <edoardo.s@daviom.com>
 * @copyright Copyright &copy; Daviom 2011-2013
 * Date: 1/22/13 - 3:46 PM
 */
class ExportWidget extends CWidget
{
    /**
     * @var $searchFormId string
     */
    public $searchFormId;
    /**
     * @var $action string the action URL
    */
    public $action;

    /**
     * @var $model object The Model CActiveRecord
     */
    public $model;

    /**
     * @var $exportParameters array() List of 'columns'=>'values' availables for export
     */
    public $exportParameters;

    public static function actions(){

        return array(
            'GetData'=>'application.modules.d_export.components.exportWidget.actions.getData',
            'LoadModal'=>array(
                'class'=>'application.modules.d_export.components.exportWidget.actions.loadModal',
            )
        );
    }

    public function run()
    {
        $assets = Yii::app()->getAssetManager()->publish( Yii::getPathOfAlias(
            'application.modules.d_export.components.exportWidget' ) . '/assets' );
        $cs = Yii::app()->clientScript;
        $cs->registerScriptFile( $assets . '/js/exportWidget.js');


        if($cs->getPackageBaseUrl('jquery.ui') === false) {
            if($cs->getPackageBaseUrl('jquery.ui.min')===false)
                $cs->registerCoreScript('jquery.ui.min');
        }


        $this->render('exportButton', array(
            'searchFormId'=>$this->searchFormId,
            'modelName'=>get_class($this->model),
            'actionUrl'=>$this->controller->createUrl('/d_export/download/export.LoadModal'),
        ));
    }
}



