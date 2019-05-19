function select2editorHorizon($editorContainer, value, record) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({ url: '/horizonsCB', method: 'GET' ,async:false})
        .done(function (data) {
            var select = $( data );
            $editorContainer.append(select);
            //select.select2({ width: '100%'}).val(record.HorizonID).trigger('change');//чтобы фокус на текущую станцию был
        })
        .fail(function () {
            alert('Не удалось получить список станций! Обратитесь к администратору!');
        });

}