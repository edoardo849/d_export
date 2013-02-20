<?php
/**
 * @author edoardo849 <edoardo.s@daviom.com>
 * @copyright Copyright &copy; Daviom 2011-2013
 * Date: 2/20/13 - 1:47 PM
 */
ini_set('memory_limit', '-1');

class DownloadController extends Controller
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

    public function actionExportReport()
    {
        $downloadForm = new DownloadForm;
        if(isset($_POST['DownloadForm']))
        {
            $downloadForm->attributes = $_POST['DownloadForm'];
            $searchParameters = CJSON::decode($downloadForm->search_parameters, true);
            $report = ExportReport::model()->findByPk($downloadForm->report_id);

            $model = new $report->model_name('search');
            $model->attributes = $searchParameters;
            $reportName = ($downloadForm->report_name)?$downloadForm->report_name:$report->name;
            $dataProvider = $model->search(false)->getData();

            $headers = array();
            $csvData = array();



            if($report->include_headers)
            {
                foreach($report->parameters as $parameter)
                    foreach($parameter as $header=>$value)
                        $headers[] = $header;

            }



            foreach($dataProvider as $data)
            {
                $row = array();

                foreach($report->parameters as $parameter)
                    foreach($parameter as $header=>$value)
                    {
                        $value = "isset({$value})?{$value}:'  '";
                        $row[] = $this->evaluateExpression($value, array('data'=>$data));
                    }
                array_push($csvData, $row);

            }


            $exportLog = new ExportLog;
            $exportLog->setAttributes(array(
                'export_id'=>$report->id,
                'user_id'=>(Yii::app()->user->isGuest)?Yii::app()->getModule('d_export')->adminUserId:Yii::app()->user->id,
                'timestamp'=>new CDbExpression('NOW()'),
                'ip_address'=>$_SERVER['REMOTE_ADDR']
            ));
            if(!$exportLog->save())
                throw new CHttpException(500,'Not able to save the logger');


            $this->renderPartial('csv', array('csvData'=>$csvData, 'headers'=>$headers, 'fileName'=>$reportName));

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




            $this->renderPartial('csv', array('csvData'=>ob_get_clean(), 'headers'=>$headers));

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