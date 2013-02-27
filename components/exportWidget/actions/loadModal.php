<?php
/**
 * @author edoardo849 <edoardo.s@daviom.com>
 * @copyright Copyright &copy; Daviom 2011-2013
 * Date: 1/22/13 - 9:44 PM
 */
class loadModal extends CAction
{
    public function run()
    {
        if(Yii::app()->request->isAjaxRequest)
        {

            $data = Yii::app()->getRequest();
            $modelName = $data->getParam('ModelName');

            $parameters = $data->getParam($modelName);
            $model = new DownloadForm;
                $model->report_name = $modelName.'_report_'.date('Y-m-d_H-m');
            $model->search_parameters = CJSON::encode($parameters);

            $this->controller->renderPartial('application.modules.d_export.components.exportWidget.views._downloadModalForm',array(
                'modelName'=>$modelName,
                'model'=>$model
            ));

        }

    }

}
