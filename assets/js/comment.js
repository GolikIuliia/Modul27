function isJson(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}
$('.comment').submit(function(e){
    e.preventDefault();
    var data = new FormData(this);
    $.ajax({
        type:'POST',
        url: 'galery/comment_add',
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        success: function(response){
            console.log (response);
            if(response === 'true'){
                swal({
                    title: "Отлично!",
                    text: "Комментарий отправлен!",
                    icon: "success",
                }).then(() => {
                    location.reload();
                }); 
                
            } else {
                swal({
                    title: "Плохо!",
                    text: "Комментарий не отправлен!",
                    icon: "failed",
                }).then(() => {
                    location.reload();
                });
            }
            // console.log (obj);
            
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

$('#deleteComment').submit(function(e){
    e.preventDefault();
    var data = new FormData(this);
    $.ajax({
        type:'POST',
        url: 'galery/comment_remove',
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        success: function(response){
            console.log (response);
            if(response === 'true'){
                swal({
                    title: "Отлично!",
                    text: "Комментарий удалён!",
                    icon: "success",
                }).then(() => {
                    location.reload();
                }); 
                
            } else {
                swal({
                    title: "Плохо!",
                    text: "Комментарий не удалён!",
                    icon: "failed",
                }).then(() => {
                    location.reload();
                });
            }
            // console.log (obj);
            
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