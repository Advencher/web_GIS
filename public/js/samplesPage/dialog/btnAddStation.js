function btnAddStation(){
    $.ajax({
        url: "/waterAreasCB",
        cache: false
    })
        .done(function (data) {
            $("#mydropdown").html(data);
            console.log(data);
            dialog.open();
        })
        .fail(function (data){
            alert('Что-то пошло не так. Обратитесь к администратору');
        });
}