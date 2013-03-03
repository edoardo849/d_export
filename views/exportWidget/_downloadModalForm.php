<?php
/**
 * @author edoardo849 <edoardo.s@daviom.com>
 * @copyright Copyright &copy; Daviom 2011-2013
 * Date: 1/22/13 - 4:43 PM
 */
?>

<div class="wide form" style="background-color: #d3d3d3; padding:5px;">
    <?php $form=$this->beginWidget('CActiveForm',array(
    'id'=>'download-form',
    'action'=>array('/d_export/download/exportReport'),
    'htmlOptions'=>array(
        'target'=>'_blank'
    )
)); ?>

    <div class="row">
        <?php echo $form->label($model,'report_id'); ?>
        <?php echo $form->dropDownList($model,'report_id',CHtml::listData(ExportReport::model()->forModel($modelName)->findAll(), 'id', 'name'),array('class'=>'span12', 'empty'=>'---')); ?>
        <?php echo $form->hiddenField($model,'search_parameters'); ?>
    </div>
    <div class="row">
        <?php echo $form->label($model,'report_name'); ?>
        <?php echo $form->textField($model,'report_name',array('class'=>'span12')); ?>
    </div>
    <div class="row buttons">
        <?php echo CHtml::htmlButton('<i class="icon-download"></i> Download', array('class'=>'btn','type'=>'submit')); ?>
    </div>

    <?php $this->endWidget(); ?>
</div>