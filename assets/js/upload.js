function isJson(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}
$('#upload').submit(function(e){
    e.preventDefault();
    if (window.FormData === undefined) {
        alert('В вашем браузере FormData не поддерживается')
    } else {
        var formData = new FormData();
        formData.append('file', $("#image")[0].files[0]);
    
        $.ajax({
            type: "POST",
            url: 'app/upload.php',
            cache: false,
            contentType: false,
            processData: false,
            data: formData,
            dataType : 'json',
            success: function(msg){
                console.log($msg);
                if (msg.error == '') {
                    $("#upload").hide();
                    $('#result').html(msg.success);
                    location.reload();
                } else {
                    $('#result').html(msg.error);
                }
                
            }
        });
    }
});

$('.deleteImage').submit(function(e){
    e.preventDefault();
    var data = new FormData(this);
    $.ajax({
        type:'POST',
        url: 'galery/image_delete',
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        success: function(response){
            console.log (response);
            if(!isJson(response)){
                return;
            }
            var obj = jQuery.parseJSON(response);
            //console.log (response);
            if(obj['success']){
                swal({
                    title: "Отлично!",
                    text: "Фотография удалена!",
                    icon: "success",
                }).then(() => {
                    location.reload();
                }); 
                
            } else {
                swal({
                    title: "Плохо!",
                    text: "Ошибка удаления фотографии!",
                    icon: "failed",
                }).then(() => {
                    location.reload();
                });
            }
        },
        error: function(response, status, error){
           var errors = response.responseJSON;
           if (errors.errors) {
               errors.errors.forEach(function(data, index) {
                   var field = Object.getOwnPropertyNames (data);
                   var value = data[field];
                   var div = $("#"+field[0]).closest('div');
                   div.addClass('has-danger');
                   div.children('.form-control-feedback').text(value);
               });
           }
        }
    });
});