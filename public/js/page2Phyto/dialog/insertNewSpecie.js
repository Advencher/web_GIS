function insertNewSpecie() {
    if (validateSpecie()) {
        var specie_name = document.getElementById('nameSpecie').value;
        var id_group = $('#mydropdownGroup').find('[aria-selected="true"]')[0].attributes.value.value;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/insertNewSpecie', data: {
                'dataRow': {
                    'id_group': id_group,
                    'specie_name': specie_name
                }
            }, method: 'POST'
        })
            .done(function (data) {
                if (data === 'success') {
                    alert('Новая группа фитопланктона успешно добавлена');
                    document.getElementById('mydropdownGroup').setAttribute('selected', '1');
                    $('#nameSpecie').val('');
                }
                else if (data === 'alreadyExist') {
                    alert('Группа фитопланктона с таким же именем уже существует');
                }

            })
            .fail(function (data) {

                alert('Ошибка - что-то пошло не так c добавлением новой группы фитопланктона!');
            });
    }
}

function validateSpecie(){
    return (document.getElementById('nameSpecie').validate());
}