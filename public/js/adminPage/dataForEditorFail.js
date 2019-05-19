function dataForEditorFail(rowsOnPage, record) {//зависит от положения comboBox в таблице(для разных разная)
    var pos;//если не соед, то в CB значение hidden становится поч
    for(var i = 0; i < rowsOnPage.length; i++){
        if (rowsOnPage[i].ID === record.ID){
            pos = i + 1;
            break;
        }
    }
    var tds = $('#grid').find('[data-position=' + pos + ']').eq(0).children();
                                                                    //ПОЗИЦИЯ
    //if (tds.eq(3).find('[data-role="display"]').eq(0))
    tds.eq(3).find('[data-role="display"]').eq(0).removeAttr('style');//.toString() - Не обязательно
    tds.eq(4).find('[role="cancel"]').eq(0).click();//.toString() - Не обязательно
    alert('Не удалось получить список прав! Попробуйте позже!');
}