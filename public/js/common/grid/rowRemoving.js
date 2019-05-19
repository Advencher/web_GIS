function rowRemowing(record, deleteURL, cancel, rowsOnPage, changedRows, variable){
    if (confirm('Вы уверены?')) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({ url: deleteURL, data: { 'dataRow': dataForDelete(record) }, method: 'POST' })
            .done(function (data) {
                if(data === 'success') {
                    if (!variable.pressedUndoButton) {
						console.log('!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!');
                        checkFullStack(true, cancel, rowsOnPage, changedRows, variable);
                        cancel.push({do: 'delete', data: $.extend(true, {}, record)});
                    }
                    else {
                        cancel.pop();
                        variable.pressedUndoButton = false;
                    }
                    console.log('cancel');
                    console.log(cancel);
                    alert('Успешно удалено.');
                }
                else
                    alert(data);
            })
            .fail(function () {
                alert('Запись не удалена!\nОбратитесь к администратору');
            });
    }
}