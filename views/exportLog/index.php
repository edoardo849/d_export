<?php
/* @var $this OrganizationController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
    'Report Log',
);


?>

<h1>Report Log</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
    <?php $this->renderPartial('_search',array(
    'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'export-log-grid',
    'dataProvider'=>$model->search(),
    'columns'=>array(
        array(
            'name'=>'export_id',
            'value'=>'CHtml::link($data->report->name, array("exportReport/view", "id"=>$data->export_id))',
            'type'=>'raw'
        ),
        'user_id',
        array(
            'name'=>'export_filter',
            'value'=>array($model, 'renderFilter'),
            'type'=>'raw'
        ),
        'timestamp',
        array(
            'name'=>'ip_address',
            'value'=>'$data->ipLink',
            'type'=>'raw'
        ),
    ),
)); ?>
<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	console.log('click')
	return false;
});
$('#export-log-search').on('keyup', function(){
    $.fn.yiiGridView.update('export-log-grid', {
        data: $(this).serialize()
    });
    return false;
});
$('#export-log-search').submit(function(){
    $.fn.yiiGridView.update('export-log-grid', {
        data: $(this).serialize()
    });
    return false;
});
");
?>