function select2editorSpecies($editorContainer, value, record) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({ url: '/speciesCB', method: 'GET' ,async:false})
        .done(function (data) {
            var select = $( data );
            $editorContainer.append(select);
            select.select2({ width: '100%'}).val(record.IDSpecies).trigger('change');
        })
        .fail(function () {
            alert('Не удалось получить список станций! Обратитесь к администратору!');
        });

}