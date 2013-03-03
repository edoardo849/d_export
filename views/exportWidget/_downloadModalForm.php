<?php
/**
 * @author edoardo849 <edoardo.s@daviom.com>
 * @copyright Copyright &copy; Daviom 2011-2013
 * Date: 1/22/13 - 4:43 PM
 */
?>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'download-form',
    'action'=>array('/d_export/download/exportReport'),
    'htmlOptions'=>array(
        'target'=>'_blank'
    )
)); ?>
<div class="modal-header">
    <button data-dismiss="modal" class="close" type="button">×</button>
    <h3>Download for <?php  echo $modelName?></h3>
</div>

<div class="modal-body">
        <div class="row-fluid">
            <div class="span6">
                <?php echo $form->label($model,'report_id'); ?>
                <?php echo $form->dropDownList($model,'report_id',CHtml::listData(ExportReport::model()->forModel($modelName)->findAll(), 'id', 'name'),array('class'=>'span12', 'empty'=>'---')); ?>
                <?php echo $form->hiddenField($model,'search_parameters'); ?>
            </div>
            <div class="span6">
                <?php echo $form->label($model,'report_name'); ?>
                <?php echo $form->textField($model,'report_name',array('class'=>'span12')); ?>
            </div>
        </div>
</div>

<div class="modal-footer">
    <?php echo CHtml::htmlButton('<i class="icon-download"></i> Download', array('class'=>'btn','type'=>'submit')); ?>
    <a data-dismiss="modal" class="btn" href="#">Cancel</a>
</div>
<?php $this->endWidget(); ?>
