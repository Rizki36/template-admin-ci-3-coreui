
$(function(){
    var $input = $('input.file[type=file]');
    if ($input.length) {
        $input.fileinput({
            theme: 'fa',
            dropZoneEnabled: false,
            showUpload:false
        });
    }
})