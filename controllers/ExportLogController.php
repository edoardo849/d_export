<?php
/**
 * @author edoardo849 <edoardo.s@daviom.com>
 * @copyright Copyright &copy; Daviom 2011-2013
 * Date: 2/20/13 - 10:37 PM
 */
class ExportLogController extends Controller
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

            'ajaxView'=>array(
                'class'=>'application.controllers.services.LoadAjaxViewAction',
                'model'=>'ExportLog', //My model's class name
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

            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {

        $model=new ExportLog('search');
        $model->unsetAttributes();  // clear any default values


        if(isset($_GET['ExportLog']))
            $model->attributes=$_GET['ExportLog'];

        $this->render('index',array(
            'model'=>$model,
        ));
    }





}
