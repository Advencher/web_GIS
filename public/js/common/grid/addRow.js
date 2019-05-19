function addRow(gridName, insertURL, grid, cancel, rowsOnPage, changedRows, variable, x){
	console.log(insertURL);
    console.log('DASDAS');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // $.ajax({ url: maxIdURL, method: 'GET' })
    //     .done(function (data) {
    //         data = (parseInt(data)+1).toString(); //максимальный айдишник
            $.ajax({ url: insertURL, data: {'dataRow': dataForInsert(x)}, method: 'POST' })
                .done(function (data) {
                    var row;
                    checkFullStack(false, cancel, rowsOnPage, changedRows, variable);
                    row = dataForInsertDG(data);
                    cancel.push({do:'insert', data: $.extend(true, {}, row)});
                    console.log('cancel');
                    console.log(cancel);
                    console.log('USPEH! ');
                    //rowsOnPage.push($.extend(true, {}, row));//не надо, т.к. добавится( след командой выполнится событие dataBound)
                    console.log(grid.count(true));
                    if(grid.count(true)% variable.pageSize !== 0){
                        variable.pageChanged = false;
                        variable.rowAdded = true;
                    }
                    else if (grid.count(true) === 0){
                        variable.pageChanged = false;
                        variable.rowAdded = true;
                    }

                    grid.addRow($.extend(true, {}, row));
                    var lastPage = $(gridName).find('[data-role="page-last"]').eq(0);
                    if(typeof lastPage.attr('disabled') === typeof undefined || lastPage.attr('disabled') === false) {
                        variable.rowAdded = true;
                        lastPage.click();

                    } //если страница последняя, не переходим
                    console.log(row);

                })
                .fail(function () {
                    alert('Не добавлено в БД! Обратитесь к администратору!');
                });
        // })
        // .fail(function () {
        //     alert('Не найден максимальный ID! Обратитесь к администратору!');
        // });
}