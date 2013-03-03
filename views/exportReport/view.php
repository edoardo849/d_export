<?php
/* @var $this OrganizationController */
/* @var $model Organization */

$this->breadcrumbs=array(
    'Reports'=>array('index'),
    'Create',
);

$this->menu=array(
    array('label'=>'List Reports', 'url'=>array('index')),
    array('label'=>'Delete Report', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<h1>View Report "<?php echo $model->name?>"</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>