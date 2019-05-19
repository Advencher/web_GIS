function dataForEditor($editorContainer, value, record, CBURL, focusField, rowsOnPage){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({ url: CBURL, method: 'GET' , async:false})
        .done(function (data) {
            console.log('111111111');
            console.log(record);
            var select = $( data );
            $editorContainer.append(select);
            select.select2({ width: '100%', height: '100%'}).val(focusField).trigger('change');//чтобы фокус на текущую станцию был
        })
        .fail(function () {
            dataForEditorFail(rowsOnPage, record);
        });
}