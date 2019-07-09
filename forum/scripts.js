$( document ).ready(function() {
    $('#show_password').click(function(){
        var type = $('#password_of_user').attr('type') == "password" ? "text" : 'password',
            c = $(this).text() == "Скрыть пароль" ? "Показать пароль" : "Скрыть пароль";
        $(this).text(c);
        $('#password_of_user').prop('type', type);
    });
});