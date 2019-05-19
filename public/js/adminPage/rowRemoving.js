function rowRemowing(record, deleteURL){
    if (confirm('Отменить удаление невозможно!!!!!\nВы уверены? ')) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({ url: deleteURL, data: { 'dataRow': dataForDelete(record) }, method: 'POST' })
            .done(function () {
                // if(!variable.pressedUndoButton) {
                //     checkFullStack(true, cancel, rowsOnPage, changedRows, variable);
                //     cancel.push({do: 'delete', data: $.extend(true, {}, record)});
                // }
                // else{
                //     cancel.pop();
                //     variable.pressedUndoButton = false;
                // }
                alert('Успешно удалено.');
            })
            .fail(function () {
                alert('Запись не удалена!');
            });
    }
}