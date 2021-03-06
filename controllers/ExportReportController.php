<?php
/**
 * @author edoardo849 <edoardo.s@daviom.com>
 * @copyright Copyright &copy; Daviom 2011-2013
 * Date: 2/20/13 - 11:00 AM
 */
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 300);
class ExportReportController extends Controller
{

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

            'ajaxView'=>array(
                'class'=>'application.controllers.services.LoadAjaxViewAction',
                'model'=>'ExportReport', //My model's class name
                //'property'=>'publisherId', //The attribute of the model i will search
            ),

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
            array('allow',  // allow all users to perform 'index' and 'view' actions
                'users'=>Yii::app()->getModule('d_export')->accessPermissionUsers,
            ),

            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $model=$this->loadModel($id);
        $model->scenario = 'update';

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if(isset($_POST['ExportReport']))
        {
            $model->attributes=$_POST['ExportReport'];
            $model->parameters = isset($_POST['Parameters'])?$_POST['Parameters']:array();


            if($model->save())
            {
                Yii::app()->user->setFlash('success', '<strong>Well done!</strong> You have successfully updated the report'); //Fill this last string with the wished name
                $this->redirect(array('index'));
            }
        }

        $this->render('view',array(
            'model'=>$model,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model=new ExportReport;
        $model->scenario = 'create';

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if(isset($_POST['ExportReport']))
        {
            $model->attributes=$_POST['ExportReport'];
            $model->parameters = isset($_POST['Parameters'])?$_POST['Parameters']:array();
            if($model->save())
            {
                Yii::app()->user->setFlash('success', '<strong>Well done!</strong>'); //Fill this last string with the wished name
                $this->redirect(array('index'));
            }
        }

        $this->render('create',array(
            'model'=>$model,
        ));
    }



    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        if(Yii::app()->request->isPostRequest)
        {
            // we only allow deletion via POST request
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if(!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {

        $model=new ExportReport('search');
        $model->unsetAttributes();  // clear any default values


        if(isset($_GET['ExportReport']))
            $model->attributes=$_GET['ExportReport'];

        $this->render('index',array(
            'model'=>$model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return ExportReport the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model=ExportReport::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param ExportReport $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='export-report-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }



}
