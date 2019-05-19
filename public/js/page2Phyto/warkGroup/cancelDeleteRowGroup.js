function cancelDeleteRowGroup(row, insertURL, grid, cancel, variable){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({ url: insertURL, data: {'dataRow': dataForCancelDeleteGroup(row)}, method: 'POST' })
        .done(function () {
            cancel.pop();
            console.log('USPEH! ');
            console.log('row');
            console.log(row);
            variable.pageChanged = false;
            //Проверка о соотв текущей выборке??
            grid.addRow($.extend(true, {}, row));//строка сама доб в rowsOnPage, т.к. сработает событие dataBound
            //if($('[data-role="page-last"]')[0].hasAttribute('disabled') === false)//Не известно куда добавится
            //$('[data-role="page-last"]')[0].click(); //если страница последняя, не переходим
        })
        .fail(function () {
            alert('Не добавлено в БД! Обратитесь к администратору!');
        });
}