function rowRemowingGroup(record, deleteURL, cancel, rowsOnPage, changedRows, variable){
    if (confirm('Вы уверены?')) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({ url: deleteURL, data: { 'dataRow': dataForDeleteGroup(record) }, method: 'POST' })
            .done(function () {
                if(!variable.pressedUndoButton) {
                    checkFullStack(true, cancel, rowsOnPage, changedRows, variable);
                    cancel.push({do: 'delete', data: $.extend(true, {}, record)});
                }
                else{
                    cancel.pop();
                    variable.pressedUndoButton = false;
                }
                console.log('cancel');
                console.log(cancel);
                alert('Успешно удалено.');
                console.log('rowRemoving Group');
            })
            .fail(function () {
                alert('Запись не удалена!');
            });
    }
}