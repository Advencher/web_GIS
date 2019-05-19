function checkFullStack(del, cancel, rowsOnPage, changedRows, variable){
    if(cancel.length === 10) {//Ограничение в десять записей
        var p = -1, find = 0;
        if (!del) {//ДЛЯ УДАЛЕНИЯ НЕ НАДО, Т.К. ОБНОВЛЯЕТСЯ СТРАНИЦА
            if (cancel[0].do === 'update') {//только если нижняя запись update
                for (var i = 0; i < rowsOnPage.length; i++) {
                    if (rowsOnPage[i].ID === cancel[0].data.ID) {
                        p = i;
                        break;
                    }
                }
            }
        }
        cancel.shift();//Удаляем нижнюю запись
        if (cancel[0].do === 'update') {//только если нижняя запись update
            for (i = 0; i < cancel.length; i++)// Проверяем есть ли в *cancel*  запись  с ID *changedRows[0]*
            {
                if (cancel[i].data.ID === changedRows[0].ID && cancel[i].do === 'update') {
                    find = 1;
                    break;
                }
            }
            if (find === 0) {//Если нет, значит удаляем запись из *changedRows*
                if (!del) {//ДЛЯ УДАЛЕНИЯ НЕ НАДО, Т.К. ОБНОВЛЯЕТСЯ СТРАНИЦА
                    if (p !== -1)
                        rowsOnPage[p] = $.extend(true, {}, changedRows[0]);
                }
                changedRows.shift();
                variable.z = variable.z - 1;
            }
        }
    }
}