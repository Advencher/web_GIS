function addRowPhytoSpecie(gridName, id_phyto, insertURL, grid, cancel, rowsOnPage, changedRows, variable, maxIDspecieURL){
    console.log('addRowPhytoSpecie called');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

            $.ajax({ url: insertURL, data: {'dataRow': dataForInsertSpecie(id_phyto)}, method: 'POST' })
                .done(function () {
                    $.ajax({ url: maxIDspecieURL, method: 'GET' })
                        .done(function (data) {
                            var id_specie_in_phyto = parseInt(data).toString();
                            var row;
                            console.log();
                            checkFullStack(false, cancel, rowsOnPage, changedRows, variable);
                            row = dataForInsertDGSpecie(id_phyto, id_specie_in_phyto);
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



