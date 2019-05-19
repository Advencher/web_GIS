function dataBound(rowsOnPage, variable, grid, records){

    if (variable.pageChanged === true) {
        deleteCBDataDataBound(rowsOnPage, '#grid', 1); //Если из edit не вышел, но обновил страницу, изменил число строк на странице, перешел на другую страницу
        rowsOnPage.length = 0;
    }
    else variable.pageChanged = true;


    for (var i = 0; i < records.length; i++) {
        rowsOnPage.push($.extend(true, {}, records[i]));
        colorImage(records, i);
    }
    if (variable.rowAdded === true){
        grid.edit(records[records.length - 1].ID);
        variable.rowAdded = false;
    }

    console.log(rowsOnPage);
}