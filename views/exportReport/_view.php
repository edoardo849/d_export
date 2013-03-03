<?php
/* @var $this OrganizationController */
/* @var $data Organization */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->name), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('type_id')); ?>:</b>
	<?php echo (isset($data->type->name))?$data->type->name:''; ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sector_id')); ?>:</b>
    <?php echo (isset($data->sector->name))?$data->sector->name:''; ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('website_url')); ?>:</b>
	<?php echo CHtml::encode($data->website_url); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('domain')); ?>:</b>
	<?php echo CHtml::encode($data->domain); ?>
	<br />


	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('update_user_id')); ?>:</b>
	<?php echo CHtml::encode($data->update_user_id); ?>
	<br />

	*/ ?>

</div>