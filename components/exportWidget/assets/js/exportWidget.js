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
            $this.action = $triggerButton.data('action');
            $this.modelName = $triggerButton.data('model-name');
            $this.modal = $triggerButton.parent().next();
            $data = $data+'&'+'ModelName='+$this.modelName;
            $this.submit($data);
        });
    };
    this.submit = function($data){
        if($this.devMode)console.log('Submitting Data: '+$data);
        $.ajax({
            url:$this.action,
            type : 'POST',
            dataType : 'html',
            data : $data,
            beforeSend : function(){
                console.log('Sending: '+decodeURI($data));
            },
            success : function($data){
                if($this.devMode){
                    console.log('Data Received');
                    console.log($data);
                }
                $this.showModal($data);
                //eval($this.callBackFunction);
            },
            'error':function(xhr, ajaxOptions, thrownError){
                console.log(xhr.status);
                console.log(thrownError);
                console.log(xhr.responseText);
                $this.showError(xhr.status, thrownError, xhr.responseText);
            }
        });
    };
    this.showModal = function($data){
        if($this.devMode) console.log('Showing View: ');
        var $modal = $this.modal.html('').html($data);
        if(typeof $modal.modal('show') != 'undefined')
            $modal.modal('show');
    };

    this.showError = function(status, thrownError, responseText){
        if($this.devMode) console.log('Show Error');
        var errorContent = $('<div/>',{
            class : 'alert alert-error',
            html:
                '<ul>' +
                    '<li>' +
                    'Status: <strong>'+status+'</strong>'+
                    '</li>'+
                    '<li>' +
                    'Message: '+thrownError+
                    '</li>'+
                    '</ul><hr>'+responseText
        });
        errorContent.appendTo($this.errorModal+' .modal-body');
        $($this.errorModal).modal('show');
    }





}
$(function(){
    var $exportWidget = new ExportWidget;
    $exportWidget.init();
});