
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/loadView-min.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/gridRefresh-min.js', CClientScript::POS_HEAD);


$this->portletsTop['PageTitle'] = array('text'=>Yii::t('app', 'Export Reports'), 'icon'=>'glyphicons_181_download_alt');

$this->portletsTop['TopButtons'] = array('buttons'=>array(
    array('label'=>'New Report', 'url'=>array('create'), 'icon'=>'plus-sign white','size'=>'large', 'type'=>'success'),
));

$this->breadcrumbs=array(
    Yii::t('app', 'Export Report')
);
?>

<div class="row-fluid">
    <div class="span4">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-search"></i>
                </span>
                <h5><?php echo Yii::t('app', 'Search')?></h5>

            </div>
            <div class="widget-content">

                <?php  $this->renderPartial('_search',array(
                'model'=>$model,
            )); ?>
            </div>

        </div>
    </div>
    <div class="span8">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-cog"></i>
                </span>
                <h5>
                    <a class="loadView defaultLoad" href="#" data-container="#export-report-list" id="defaultLoad" data-action="<?php echo CController::createUrl('exportReport/ajaxView');?>" >
                        <?php echo Yii::t('app', 'Reports');?>
                    </a>
                </h5>
                <div class="buttons">
                    <a class="btn btn-mini refreshGrid pull-right" data-grid="export-report-grid" href="#"><i class="icon-refresh"></i> <?php echo Yii::t('app', 'Refresh')?></a>
                </div>
                <script type="text/javascript">
                    $('.defaultLoad').trigger('click');
                </script>
            </div>
            <div class="widget-content" id="export-report-list">


            </div>
        </div>
    </div>

</div>
