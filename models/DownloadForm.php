<?php
/**
 * @author edoardo849 <edoardo.s@daviom.com>
 * @copyright Copyright &copy; Daviom 2011-2013
 * Date: 2/20/13 - 1:51 PM
 */
class DownloadForm extends CFormModel
{
    public $report_id;
    public $report_name;
    public $search_parameters;

    public function rules()
    {
        return array(
            array('report_id','required'),
            array('search_parameters, report_id, report_name','safe'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'report_id'=>Yii::t('user', 'Available Reports'),
            'report_name'=>Yii::t('user', 'Name of the report'),
        );
    }


}
