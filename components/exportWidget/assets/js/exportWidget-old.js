/**
 * Created by edoardo849 - <> on 1/22/13 4:20 PM.
 */

function ExportWidget(){
    this.devMode = true;
    this.triggerClass = '.load-export-widget';
    this.action = null;
    this.modelName = null;
    this.errorModal = '#errorModal';
    this.modal=null;

    this.init = function(){
        $this = this;
        if($this.devMode)console.log('ExportWidget() Loaded');
        $(document).on('click',$this.triggerClass, function(e){
            e.preventDefault();
            if($this.devMode) console.log('action triggered');
            var $triggerButton = $(this),
                $dataFormTargetId = $triggerButton.data('form-target'),
                $data = $($dataFormTargetId).serialize();
            $('#D_export_model_attributes').val($data);
            $(this).closest('form').submit()
        });
    };





}
$(function(){
    var $exportWidget = new ExportWidget;
    $exportWidget.init();
});