function updateGroup(record, updateURL, grid, rowsOnPage, changedRows, cancel, variable){
    //if (confirm('Send to server?')) {
    if (!variable.pressedUndoButton) {
        var temp = variable.z,
        k = -1;
        variable.z = -1;
        var  i;
        for (i = 0; i < changedRows.length; i++)//Есть ли уже запись о изменениях строки с индентификатором id
        {
            if (record.ID === changedRows[i].ID) {
                variable.z = i;
                break;
            }
        }

        if (variable.z === -1) {//нет
            for (i = 0; i < rowsOnPage.length; i++) {
                if (rowsOnPage[i].ID === record.ID) {//Значит ищем по записям на текущей странице
                    k = i;
                    break;
                }
            }
        }

        if (variable.z !== -1)//Есть
        {
            if (checkForCBNullGroup(record, changedRows, variable, false))
                grid.updateRow(record.ID, record);
        }

        else {
            if (checkForCBNullGroup(record, changedRows, variable, true))
                grid.updateRow(record.ID, record);
        }
    }
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({ url:  updateURL, data: {'dataRow': dataForUpdateGroup(record) }, method: 'POST' })
        .done(function (data) {
            if(!variable.pressedUndoButton) {
                checkFullStack(false, cancel, rowsOnPage, changedRows, variable);
                if (variable.z !== -1)//Есть
                {
                    //if (checkForCBNull(record, changedRows, variable, false))
                        //grid.updateRow(record.ID, record);
                    cancel.push({
                        do: "update",
                        data: $.extend(true, {}, $.extend(true, {}, changedRows[variable.z]))
                    });//Вставляем предыдущее значение
                    changedRows[variable.z] = $.extend(true, {}, record);//Обновляем текущее значение
                }
                else {
                    //if (checkForCBNull(record, changedRows, variable, true))
                        //grid.updateRow(record.ID, record);
                    cancel.push({
                        do: "update",
                        data: $.extend(true, {}, $.extend(true, {}, rowsOnPage[k]))
                    });//Вставляем найденное значение
                    changedRows.push($.extend(true, {}, record));//Вставляем текущее значение
                    variable.z = changedRows.length - 1;
                }
                //console.log(data);
                //$('#response').json(data);
                //grid.reload();
            }
            else{
                variable.pressedUndoButton = false;
                var find = 0;
                var n = -1;
                for (var i = 0; i < rowsOnPage.length; i++) {
                    if (rowsOnPage[i].ID === cancel[cancel.length - 1].data.ID) {//Если данная запись есть на странице, то изменяем ее еще и на странице. Ну или обновляем страницу. Как пойдет
                        changedRows[variable.z] = $.extend(true, {}, cancel[cancel.length - 1].data);
                        grid.updateRow(cancel[cancel.length - 1].data.ID, changedRows[variable.z]);
                        n = i;
                        break;
                    }
                }
                cancel.pop();//Удаляем запись из *cancel*
                for (i = 0; i < cancel.length; i++)// Проверяем есть ли в *cancel*  запись  с ID *changedRows[changedRows.length - 1]*
                {
                    if (cancel[i].data.ID === changedRows[changedRows.length - 1].ID && cancel[i].do === 'update') {
                        find = 1;
                        break;
                    }
                }
                if (find === 0) {//Если нет, значит удаляем запись из *changedRows*
                    if (n !== -1)
                        rowsOnPage[n] = $.extend(true, {}, changedRows[changedRows.length - 1]);
                    changedRows.pop();
                    console.log("Я тут");
                }

                console.log("ОТМЕНА ИЗМЕНЕНИЯ updateGroup");
                console.log("Значение строки стало");
                console.log(changedRows);
                console.log("cancel");
                console.log(cancel);
                for (i = 0; i < changedRows.length; i++)//Новое значение z
                {
                    if (changedRows[i].ID === cancel[cancel.length - 1].data.ID) {
                        variable.z = i;
                        break;
                    }
                }
               //variable.pressedUndoButton = false;
            }
        })
        .fail(function () {
            if (!variable.pressedUndoButton){
                if (variable.z === -1) {
                    grid.updateRow(record.ID, $.extend(true, {}, rowsOnPage[k]));//Если не удачно, то возвращаем, что было
                }
                else {
                    grid.updateRow(record.ID, $.extend(true, {}, changedRows[variable.z]));//Если не удачно, то возвращаем, что было
                }
                variable.z = temp;//восстанавливаем значение z
            }
            alert('Данные не обновлены.');
            // console.log(data);
            // $('#response').json(data);
        });
    //}
}