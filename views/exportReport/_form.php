<?php
/* @var $this ReportController */
/* @var $model Report */
/* @var $form CActiveForm */

//Yii::app()->clientScript->registerScriptFile(Yii::getPathOfAlias('application.modules.d_export.assets.js').'/formDuplicate-min.js');
$assets = Yii::app()->getAssetManager()->publish( Yii::getPathOfAlias(
    'application.modules.d_export' ) . '/assets' );
$cs = Yii::app()->clientScript;
$cs->registerScriptFile( $assets . '/js/formDuplicate-min.js');
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'organization-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>256)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>
    <div class="row">
        <?php echo $form->labelEx($model,'include_headers'); ?>
        <?php echo $form->dropDownList($model,'include_headers',array(0=>'No', 1=>'Yes'),array('empty'=>'---')); ?>
        <?php echo $form->error($model,'include_headers'); ?>
    </div>

	<div class="row">
		<?php echo $form->labelEx($model,'model_name'); ?>
        <?php echo $form->dropDownList($model, 'model_name',CHtml::listData(ExportReport::getAllModelsList(), 'id', 'name'),array('empty'=>'---')) ?>
		<?php echo $form->error($model,'model_name'); ?>
	</div>
    <div class="row">
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

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->