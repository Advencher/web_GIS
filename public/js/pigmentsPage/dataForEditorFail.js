function dataForEditorFail(rowsOnPage, record) {//зависит от положения comboBox в таблице(для разных разная)
    var pos;//если не соед, то в CB значение hidden становится поч
    for(var i = 0; i < rowsOnPage.length; i++){
        if (rowsOnPage[i].ID === record.ID){
            pos = i + 1;
            break;
        }
    }
    if ($('#grid').find('[data-position=' + pos + ']').eq(0).children().eq(1).find('[data-role="display"]').eq(0))
        $('#grid').find('[data-position=' + pos + ']').eq(0).children().eq(1).find('[data-role="display"]').eq(0).removeAttr('style');//.toString() - Не обязательно
    alert('Не удалось получить список станций! Обратитесь к администратору!');
}