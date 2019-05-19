$(document).ready(function () {
    //Учитываем, что на одной странице несколько таблиц
    var gridFT, rowsOnPageFT = [], changedRowsFT = [],
        cancelFT = [], variableFT = [];
    variableFT.z = -1;
    variableFT.pressedUndoButton = false;
    variableFT.rowAdded = false;
    variableFT.pageChanged = false;
    var
        deleteURLFT = '/delete_user',
        updateURLFT = '/update_user',
        CBURLFT = '/rightsCB';

    function select2editor($editorContainer, value, record) {
        dataForEditor($editorContainer, value, record, CBURLFT, record.RightID, rowsOnPageFT);
    }

    gridFT = $('#grid').grid({

        dataSource: '/users',
        uiLibrary: 'bootstrap4',
        headerRowHeight: 'fixed',
        bodyRowHeight: 'fixed',
        fontSize: '12px',
        primaryKey: 'ID',
        inlineEditing: {mode: 'command'},
        columns: [
            {field: 'ID', sortable: true, width: 44},
            {field: 'Name', title: 'Имя', editor: true, sortable: true, width: 200},
            {field: 'Email', title: 'Почта', editor: true, sortable: true, width: 200},
            {field: 'Right', title: 'Права', type: 'dropdown', editField: 'RightID', editor: select2editor, sortable: true, width: 400}

        ],
        //autoBind: false,
        pager: {limit: 5}
    });

    gridFT.on('dataBound', function (e, records, totalRecords) {
        dataBound(rowsOnPageFT, variableFT, gridFT, records);
    });

    gridFT.on('rowCancelChanged', function (e, id, record) {//После отмены изменения строки
        deleteCBData(id, rowsOnPageFT, '#grid', 3);
    });

    gridFT.on('rowDataChanged', function (e, id, record) {//После изменения строки
        console.log('@@rowDataChanged@@');
        deleteCBData(id, rowsOnPageFT, '#grid', 3); //Сработает rowCancelChanged 0_0 0_0 0_0 0_0 0_0
        update(record, updateURLFT, gridFT, rowsOnPageFT, changedRowsFT, cancelFT, variableFT);
    });

    gridFT.on('rowRemoving', function (e, $row, id, record) {
        rowRemowing(record, deleteURLFT)
    });

    $('#btnUndo').click(function() {
        btnUndo(updateURLFT, null, gridFT, rowsOnPageFT, changedRowsFT, cancelFT, variableFT)
    });
});