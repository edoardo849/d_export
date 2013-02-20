<?php
/**
 * @author edoardo849 <edoardo.s@daviom.com>
 * @copyright Copyright &copy; Daviom 2011-2013
 * Date: 2/19/13 - 2:05 PM
 */
?>


<?php

$this->portletsTop['PageTitle']=array('text'=>Yii::t('app','Export '.$modelName) );

?>
<div class="row-fluid">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-briefcase"></i>
                </span>
                <h5>
                    <?php echo $model->search()->itemCount;?> result(s) in your search
                </h5>

            </div>
            <div class="widget-content" id="inbound-request-list">
                <div class="page-header">
                    <h3>Export</h3>
                </div>



                <?php echo CHtml::beginForm(array('/d_export/default/download'), 'POST'); ?>


                    <?php echo CHtml::hiddenField('Export[model_attributes]',$modelAttributes)?>
                    <?php echo CHtml::hiddenField('Export[model_name]',$modelName)?>

                <div class="row-fluid">
                        <ul class="unstyled">
                        <?php
                            $i=0;
                            foreach($model->tableSchema->columns as $column): ?>
                            <li>
                                <?php echo CHtml::checkBox('Export[include_value][]', 1, array('id'=>false, 'value'=>'include')); ?>
                                <?php echo CHtml::textField('Export[header][]',$column->name, array('id'=>false)); ?>
                                <?php echo CHtml::hiddenField('Export[attribute][]',$column->name,array('id'=>false)); ?>
                            </li>
                            <?php $i++; endforeach; ?>
                        </ul>
                    </div>
                    <div class="page-header">
                        <h3><?php echo $modelName; ?> relations: </h3>
                    </div>
                    <?php foreach($model->relations() as $name => $relation): ?>

                        <?php if($relation[0] == CActiveRecord::BELONGS_TO || $relation[0] == CActiveRecord::HAS_ONE):?>
                        <div class="row-fluid">
                            <h4><?php echo $name; ?> </h4>
                            <ul class="unstyled">
                                <?php foreach($relation[1]::model()->tableSchema->columns as $column): ?>
                                <li>
                                    <?php echo CHtml::checkBox('Export[include_value][]', 1, array('id'=>false, 'value'=>'exclude'));?>
                                    <?php echo CHtml::textField('Export[header][]',$column->name,array('id'=>false)); ?>
                                    <?php echo CHtml::hiddenField('Export[attribute][]',$name.'->'.$column->name,array('id'=>false)); ?>
                                </li>
                                <?php
                                $i++;
                            endforeach; ?>
                            </ul>
                        </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <div class="form-actions">
                    <button class="btn btn-large"><i class="icon icon-download-alt"></i> Download</button>
                </div>
                <?php echo CHtml::endForm(); ?>
            </div>
        </div>
    </div>

</div>
    <script type="text/javascript">
        $('input[type=checkbox]').on('click', function(){
            var $this = $(this);
            if($this.is(':checked'))
                $this.val('include');
            else
                $this.val('exclude');

        })
    </script>