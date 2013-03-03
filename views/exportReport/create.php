<?php
//Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/formDuplicate.js', CClientScript::POS_HEAD);
$this->portletsTop['PageTitle'] = array('text'=>Yii::t('app', 'New Report'), 'icon'=>'glyphicons_181_download_alt');


$this->breadcrumbs=array(
    Yii::t('app', 'Reports')=>array('inboundDuration/index'),
    Yii::t('app', 'New Report')

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
                    <?php echo Yii::t('app', 'New Report') ?>
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


