function goToAddSpecie() {
    var dialogAddSpecie = document.getElementById('addSpecieDialog');
    $.ajax({
        url: "/groupsDialogItems",
        cache: false
    })
        .done(function (data) {

            $("#mydropdownGroup").html(data);
            dialogAddSpecie.toggle();
        })
        .fail(function (data) {
            alert('Что-то пошло не так со списком групп фитопланктона');
        });
}