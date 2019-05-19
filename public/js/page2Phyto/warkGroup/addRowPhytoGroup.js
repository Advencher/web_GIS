function addRowPhytoGroup(gridName, id_phyto, insertURL, grid, cancel, rowsOnPage, changedRows, variable, maxIDgroupURL){
    console.log('addRowPhytoGroup called');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

            $.ajax({ url: insertURL, data: {'dataRow': dataForInsertGroup(id_phyto)}, method: 'POST' })
                .done(function () {
                    $.ajax({ url: maxIDgroupURL, method: 'GET' })
                        .done(function (data) {
                            var id_group_in_phyto = parseInt(data).toString();
                            var row;
                            console.log();
                            checkFullStack(false, cancel, rowsOnPage, changedRows, variable);
                            row = dataForInsertDGGroup(id_phyto, id_group_in_phyto);
                            cancel.push({do:'insert', data: $.extend(true, {}, row)});
                            //rowsOnPage.push($.extend(true, {}, row));//не надо, т.к. добавится( след командой выполнится событие dataBound)
                            if(grid.count(true)%variable.pageSize !== 0){
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
                            }
                        })
                        .fail(function () {
                            alert('Не найден макс id!');
                        });
                })
                .fail(function () {
                    alert('Не добавлено в БД! Обратитесь к администратору!');
                });
}



