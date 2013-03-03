<?php
/* @var $this OrganizationController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Export Reports',
);

$this->menu=array(
	array('label'=>'Create Report', 'url'=>array('create')),
    array('label'=>'Report Log', 'url'=>array('exportLog/index')),

);
?>

<h1>Reports</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$model->search(),
	'itemView'=>'_view',
)); ?>