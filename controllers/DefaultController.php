<?php

class DefaultController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout='//layouts/column1';

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    public function actions()
    {
        return array(
            'export.'=>'application.modules.d_export.components.exportWidget.ExportWidget',
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow',  // allow all users to perform 'index' and 'view' actions
                'roles'=>Yii::app()->getModule('d_export')->accessPermissionRoles,
            ),

            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

    public function actionIndex()
	{
		$this->render('index');
	}

    public function actionExport()
    {
        if(isset($_POST['D_export']))
        {
            //$parameters = $_POST['D_export'];
            $modelName = $_POST['D_export']['model_name'];
            $modelAttributes = urldecode($_POST['D_export']['model_attributes']);
            $model = new $modelName('search');
            $model->unsetAttributes();

            $attributes = explode('&', $modelAttributes);
            $values = array();
            $search = array($modelName, '[',']');
            foreach($attributes as $attribute)
            {
                $attribute = explode('=',$attribute);
                $attribute[0] = str_replace($search,'',$attribute[0] );

                $values[$attribute[0]] = $attribute[1];
            }

            $model->attributes = $values;

            $this->render('export', array('model'=>$model,'modelAttributes'=>$modelAttributes, 'modelName'=>$modelName));
        }

    }

    public function actionDownload()
    {
        if(isset($_POST['Export']))
        {
            $exportAttributes = $_POST['Export'];


            $modelAttributes = urldecode($exportAttributes['model_attributes']);
            //$parameters = $_POST['D_export'];
            $modelName = $exportAttributes['model_name'];

            $model = new $modelName('search');
            $model->unsetAttributes();

            $attributes = explode('&', $modelAttributes);
            $values = array();
            $search = array($modelName, '[',']');
            foreach($attributes as $attribute)
            {
                $attribute = explode('=',$attribute);
                $attribute[0] = str_replace($search,'',$attribute[0] );

                $values[$attribute[0]] = $attribute[1];
            }

            $model->attributes = $values;
            $dataProvider = $model->search()->getData();

            //$user = User::model()->findAllByAttributes(array('email'=>'edoardo.s@daviom.com'));

            $csvData = array();
            foreach($exportAttributes['include_value'] as $i=>$value)
            {
                if($value==='include')
                {
                    $headers[] = $exportAttributes['header'][$i];
                    //$csvData[] = $data->{$modelAttributes['attribute'][$i]};
                }
            }
            /**
             * Workflow : 1) Select export from the DB (previously setted), then continue:::
             */
            $database = array('$data->username', '$data->email', '$data->mainAddress->city');

            foreach($dataProvider as $data)
            {
                $row = array();

                foreach($database as $value)
                {
                    $row[] = $this->evaluateExpression($value, array('data'=>$data));
                }
                array_push($csvData, $row);

            }


            $this->renderPartial('csv', array('csvData'=>$csvData, 'headers'=>$headers));

        }




    }

    public static function generateCsv($rows, $coldefs, $boolPrintRows=true, $csvFileName=null, $separator=';')
    {
        $endLine = '\r\n';
        $returnVal = '';

        if($csvFileName != null)
        {
            header("Cache-Control: public");
            header("Content-Description: File Transfer");
            header("Content-Disposition: attachment; filename=".$csvFileName);
            header("Content-Type: application/octet-stream");
            header("Content-Transfer-Encoding: binary");
        }

        if($boolPrintRows == true){
            $names = '';
            foreach($coldefs as $col=>$config){
                $names .= $col.$separator;
            }
            $names = rtrim($names,$separator);
            if($csvFileName != null){
                echo $names.$endLine;
            }else
                $returnVal .= $names.$endLine;
        }

        foreach($rows as $row){
            $r = '';
            foreach($coldefs as $col=>$config){

                if(isset($row[$col])){

                    $val = $row[$col];

                    foreach($config as $conf)
                        if(!empty($conf))
                            $val = Yii::app()->format->format($val,$conf);

                    $r .= $val.$separator;
                }
            }
            $item = trim(rtrim($r,$separator)).$endLine;
            if($csvFileName != null){
                echo $item;
            }else{
                $returnVal .= $item;
            }
        }
        return $returnVal;
    }



}