<?php
//Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/formDuplicate.js', CClientScript::POS_HEAD);
$this->portletsTop['PageTitle'] = array('text'=>$model->name, 'icon'=>'glyphicons_181_download_alt');


$this->breadcrumbs=array(
    Yii::t('app', 'Export Report')=>array('d_export/exportReport/index'),
    $model->name

);

?>
<div class="row-fluid">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-cog"></i>
                </span>
                <h5>
                    <?php echo $model->name; ?>
                </h5>

            </div>
            <div class="widget-content">
                <?php  $this->renderPartial('_form',array(
                'model'=>$model,
            )); ?>

            </div>
        </div>
    </div>

</div>


