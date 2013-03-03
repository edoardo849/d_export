


<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm',array(
	'method'=>'get',
	'id'=>'export-log-search'
)); ?>
    <div class="row">
        <?php echo $form->label($model,'export_id'); ?>
        <?php echo $form->dropDownList($model, 'export_id',CHtml::listData(ExportReport::model()->findAll(), 'id', 'name'),array('class'=>'span12','empty'=>'---')); ?>
    </div>
    <div class="row">
        <?php echo $form->label($model,'reportModelName'); ?>
        <?php echo $form->dropDownList($model, 'reportModelName',ExportReport::getAllModels(),array('class'=>'span12','empty'=>'---')); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'user_id'); ?>
        <?php echo $form->textField($model, 'user_id',array('class'=>'span12',)); ?>
    </div>
    <div class="row">
        <?php echo $form->label($model,'timestamp'); ?>
        <?php echo $form->textField($model, 'timestamp',array('class'=>'span12',)); ?>
    </div>
    <div class="row">
        <?php echo $form->label($model,'ip_address'); ?>
        <?php echo $form->textField($model, 'ip_address',array('class'=>'span12',)); ?>
    </div>

    <div class="form-actions">
        <?php echo CHtml::htmlButton('<i class="icon-search"></i> '.Yii::t('app', 'Search'), array('class'=>'btn','type'=>'submit')); ?>
    </div>

<?php $this->endWidget(); ?>
</div>

