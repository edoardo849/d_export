

<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/formDuplicate-min.js', CClientScript::POS_HEAD);

$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'export-report-form',
    'enableAjaxValidation'=>true,
)); ?>

<p class="help-block">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>

<div class="row-fluid">
    <div class="span6">
        <?php echo $form->labelEx($model, 'name') ?>
        <?php echo $form->textField($model, 'name', array('class'=>'span12')) ?>
        <?php echo $form->error($model, 'name') ?>
    </div>
    <div class="span4">
        <?php echo $form->labelEx($model, 'model_name') ?>
        <?php echo $form->dropDownList($model, 'model_name',CHtml::listData(ExportReport::getAllModelsList(), 'id', 'name'),array('class'=>'span12', 'empty'=>'---')) ?>
        <?php echo $form->error($model, 'model_name') ?>
    </div>
    <div class="span2">
        <?php echo $form->labelEx($model, 'include_headers') ?>
        <?php echo $form->dropDownList($model, 'include_headers',array(0=>Yii::t('app', 'No'), 1=>Yii::t('app', 'Yes')),array('class'=>'span12', 'empty'=>'---')) ?>
        <?php echo $form->error($model, 'include_headers') ?>
    </div>
</div>
<div class="row-fluid">
    <div class="span12">
        <table id="parametersTable" class="span12">
            <thead>
            <th><?php echo CHtml::label('Header', 'parametersTable')?></th>
            <th><?php echo CHtml::label('Value', 'parametersTable')?></th>

            <th><a data-mode="<?php echo (count($model->parameters == 0))?'new':'update';?>" data-action="duplicate" data-parent = "#parametersTable" href="#" class="btn btn-mini btn-table-duplicate pull-right">+</a></th>
            </thead>
            <tbody>
            <?php if(!is_array($model->parameters) || $model->isNewRecord): ?>
            <tr>
                <td><?php echo CHtml::textField('Parameters[0][header]','',array('class'=>'span12')); ?></td>
                <td><?php echo CHtml::textField('Parameters[0][value]','',array('class'=>'span12')); ?></td>
                <td><a href="#"  data-action="delete" data-parent = "#parametersTable" class="btn btn-mini btn-table-duplicate pull-right">-</a></td>
            </tr>
                <?php else: ?>
                <?php foreach($model->parameters as $id=>$parameter): ?>
                    <?php foreach($parameter as $header=>$value):?>
                    <tr>
                        <td><?php echo CHtml::textField("Parameters[{$id}][header]",$header, array('class'=>'span12')); ?></td>
                        <td><?php echo CHtml::textField("Parameters[{$id}][value]", $value); ?></td>
                        <td><a href="#" data-action="delete" data-parent = "#parametersTable" class="btn btn-mini btn-table-duplicate pull-right">-</a></td>
                    </tr>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="span6">

    </div>

</div>
<div class="form-actions">
    <?php $this->widget('bootstrap.widgets.TbButton', array(
    'buttonType'=>'submit',
    'type'=>'primary',
    'label'=>$model->isNewRecord ? 'Create' : 'Save',

)); ?>
</div>

<?php $this->endWidget(); ?>