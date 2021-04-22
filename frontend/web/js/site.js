// Скрипт для обработки Графика отпусков

function showMessage(message, type, target) {
    var target = 'messages' + target;
    var classes = type == 'error' ? 'alert alert-danger' : 'alert alert-success';
    $('#'+target).attr("class", classes).html(message);
    $('#'+target).slideDown(1000).slideUp(3000);
}

function fixVacation($url, $id) {
    var data = {'Vacation': {'id': $id}};
    $.ajax({
        url: $url,
        type: 'POST',
        data: data,
        success: function(response){
            if (response.error) {
                showMessage('Не удалось сохранить данные', 'error', 2);
            } else {
                showMessage('Данные успешно сохранены', 'success', 2);
                $.pjax.reload({container:"#gridv"});  //Reload GridView
            }
        },
        error: function(){
            showMessage('В процессе выполнения запроса произошла ошибка!', 'error', 2);
        }
    });
    return false;
}

$(document).ready(function () {
    $('#form-vacation').on('beforeSubmit', function(){
        var data = $(this).serialize();
        $.ajax({
            url: $('#form-vacation').attr('action'),
            type: 'POST',
            data: data,
            success: function(response){
                if (response.error) {
                    showMessage('Не удалось сохранить данные', 'error', 1);
                } else {
                    showMessage('Данные успешно сохранены', 'success', 1);
                }
            },
            error: function(){
                // это ошибка 500 и т.п.
                showMessage('В процессе выполнения запроса произошла ошибка!', 'error', 1);
            }
        });
        return false;
    });
});