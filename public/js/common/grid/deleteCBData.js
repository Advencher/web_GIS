function deleteCBData(id, rowsOnPage, gridName, posOfCB){//@@
    var pos = 1;
    for(var i = 0; i < rowsOnPage.length; i++){
        if (rowsOnPage[i].ID === id){
            pos = i + 1;
            break;
        }
    }
    try{
        //grid->tr с data-position [0]->список td->td с comboBox->в нем ищем div с data-role="edit"
        $(gridName).find('[data-position=' + pos + ']').eq(0).children().eq(posOfCB).find('[data-role="edit"]').remove();
    }
    catch(Exception){
        console.log('deleteCBData. Не удалось!');
    }
}