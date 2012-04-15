$(document).ready(function() {
    
    function uploadSuccess(file, serverData) {
        $('#images').html($(serverData));
    }
    
    function uploadComplete(file) {
        //$('#status').html($('<p>Загрузка ' + file.name + ' завершена</p>'));
        $('#status').html($(''));
        //alert(file.id);
        //ajaxFileUpload(file.id);
    }
    
    function uploadStart(file) {
        $('#status').append($('<p>Начата загрузка файла ' + file.name + '</p>'));
        return true;
    }
    
    function uploadProgress(file, bytesLoaded, bytesTotal) {
        $('#status').html($('<p>Загружено ' + Math.round(bytesLoaded/bytesTotal*100) + '% файла ' + file.name + '</p>'));
    }

    function fileDialogComplete(numFilesSelected, numFilesQueued) {
        if(numFilesSelected > 0){/*$('#status').html($('<p>Выбрано ' + numFilesSelected + ' файл(ов), начинаем загрузку</p>'));*/
        this.startUpload(); }
    }
    
pos = $('input[name="pos"]').val();
if(!pos) pos=0;
    var swfu = new SWFUpload(
        {
            upload_url : "/ajax/upload_avatar/"+rand,
            flash_url : "/js/swfupload.swf",
            wmode: 'opaque',
            button_placeholder_id : "uploadButton",
            
            file_size_limit : "10 MB",
            file_types : "*.jpg; *.png; *.jpeg; *.gif",
            file_types_description : "Images",
            file_upload_limit : "0",
            debug: false,
            post_params: {'pos':pos, 'type':'avatar'},

            button_image_url: "/img/button.png",
            button_width : 120,
            button_height : 30,
            button_text_left_padding: 15,
            button_text_top_padding: 2, 
            button_text : "<span class=\"uploadBtn\">&nbsp;&nbsp;Выбрать</span>",
            button_text_style : ".uploadBtn { font-size: 14px; font-family: Verdana; background-color: #FFFFFF;z-index:-100; color:#EEEEEE;}",
            
            file_dialog_complete_handler : fileDialogComplete,

            upload_success_handler : uploadSuccess,
            upload_complete_handler : uploadComplete,
            upload_start_handler : uploadStart,
            upload_progress_handler : uploadProgress
        }
    );  
});