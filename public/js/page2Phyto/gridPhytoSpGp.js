//$(document).ready(function () {
    //Учитываем, что на одной странице несколько таблиц
    var gridFT1, rowsOnPageFT1 = [], changedRowsFT1 = [],
        cancelFT1 = [], k = -1, variableFT1 = [];
    variableFT1.z = -1;
    variableFT1.pressedUndoButton = false;
    variableFT1.rowAdded = false;
    variableFT1.pageChanged = false;
    variableFT1.pageSize = 5;
    var
        insertURLFT1 = '/insert_species',
        deleteURLFT1 = '/delete_species',
        updateURLFT1 = '/update_species',
        maxIDspecieURL = '/maxIDSpecie';

    var gridSD, rowsOnPageSD = [], changedRowsSD = [],
        cancelSD = [], k2 = -1, variableSD = [];
    variableSD.z = -1;
    variableSD.pressedUndoButton = false;
    variableSD.rowAdded = false;
    variableSD.pageChanged = false;
    variableSD.pageSize = 5;
    var
        insertURLSD = '/insert_groups',
        deleteURLSD = '/delete_groups',
        updateURLSD = '/update_groups',
        maxIDGroupURL = '/maxIDGroup';

    var result_id = document.getElementById('IDphyto').value;

    gridFT1 = $('#gridFT1').grid({

        dataSource: '/phytosSP?id_phyto=' + result_id,
        uiLibrary: 'bootstrap4',
        headerRowHeight: 'fixed',
        bodyRowHeight: 'fixed',
        fontSize: '12px',
        primaryKey: 'ID',
        inlineEditing: { mode: 'command' },
        columns: [
            { field: 'ID', hidden: true},
            { field: 'IDphyto', hidden: true},
            { field: 'SpecieName', title:'Вид фитопланктона', type: 'dropdown', editField: 'IDSpecies',  editor: select2editorSpecies, sortable: true, width: 150},
            { field: 'PercentageOfTotal', title:'% от общей численности',  editor: true },
            { field: 'PercentageOfTheTotalBiomass', title:'% от общей биомассы', editor: true },
            { field: 'Number' , title:'Численность вида в пробе', editor: true},
            { field: 'Biomass' , title:'Биомасса', editor: true},
            { field: 'GroupName', title:'Группа фитопланктона', editor: false, sortable: true}
        ],
        //autoBind: false,
        pager: { limit: 5 }
    });
    //добавление вида фитопланктона

    $('#btnAddSpecie').on('click', function () {
        goToAddSpecie();
    });

    $('#btnAddNewSpecie').on('click', function () {
        insertNewSpecie();
    });
    //конец


    $('#btnAddSpecieSample').click(function() {
        addRowPhytoSpecie( '#gridFT1', result_id, insertURLFT1, gridFT1, cancelFT1, rowsOnPageFT1, changedRowsFT1, variableFT1, maxIDspecieURL);
    });

    $('#btnUndoSpecieSample').click(function() {
        btnUndoSpecie(updateURLFT1, insertURLFT1, gridFT1, rowsOnPageFT1, changedRowsFT1, cancelFT1, variableFT1);
    });


    gridFT1.on('dataBound', function (e, records, totalRecords) {
        dataBoundSpecie(rowsOnPageFT1, variableFT1, gridFT1, records);
    });


    gridFT1.on('rowCancelChanged', function (e, id, record) {//После отмены изменения строки
        deleteCBData(id, rowsOnPageFT1, '#gridFT1', 1);
    });

    gridFT1.on('rowDataChanged', function (e, id, record) {//После изменения строки
        console.log('@@rowDataChanged@@');
        updateSpecie(record, updateURLFT1, gridFT1, rowsOnPageFT1, changedRowsFT1, cancelFT1, variableFT1);
        deleteCBData(id, rowsOnPageFT1, '#gridFT1', 1);

    });

    gridFT1.on('rowRemoving', function (e, $row, id, record) {
        rowRemowingSpecie(record, deleteURLFT1, cancelFT1, rowsOnPageFT1, changedRowsFT1, variableFT1)
    });


    gridFT1.on('pageSizeChange', function (e, newSize) {
        pageSizeChange(variableFT1, newSize);
    });



    gridSD = $('#gridSD').grid({

        dataSource: '/phytosGP?id_phyto=' + result_id,
        uiLibrary: 'bootstrap4',
        headerRowHeight: 'fixed',
        bodyRowHeight: 'fixed',
        fontSize: '12px',
        primaryKey: 'ID',
        inlineEditing: { mode: 'command' },
        columns: [
            { field: 'ID', hidden: true},
            { field: 'IDphyto', hidden: true},
            { field: 'IDGroup', hidden: true},
            { field: 'GroupName', title:'Группа фитопланктона', type: 'dropdown', editField: 'IDGroup',  editor: select2editorGroups, sortable: true, width: 150},
            { field: 'TotalSpecies', title:'Всего видов группе',  editor: true },
            { field: 'TotalPercent', title:'Процент группы в пробе', editor: true },
            { field: 'BiomassPercent', title:'Процент биомассы', editor: true },
            { field: 'Number' , title:'Численность в пробе', editor: true},
            { field: 'Biomass' , title:'Биомасса', editor: true}
        ],
        //autoBind: false,
        pager: { limit: 5 }
    });

    //update phyto samples for dialog window



    $('#btnAddGroup').click(function() {
        addRowPhytoGroup( '#gridSD', result_id, insertURLSD, gridSD, cancelSD, rowsOnPageSD, changedRowsSD, variableSD, maxIDGroupURL);
    });

    $('#btnUndoGroup').click(function() {
        btnUndoGroup(updateURLSD, insertURLSD, gridSD, rowsOnPageSD, changedRowsSD, cancelSD, variableSD);
    });


    gridSD.on('dataBound', function (e, records, totalRecords) {
        dataBoundGroup(rowsOnPageSD, variableSD, gridSD, records);
    });


    gridSD.on('rowCancelChanged', function (e, id, record) {//После отмены изменения строки
        deleteCBData(id, rowsOnPageSD, '#gridSD', 1);
    });

    gridSD.on('rowDataChanged', function (e, id, record) {//После изменения строки
        console.log('@@rowDataChanged@@');
        updateGroup(record, updateURLSD, gridSD, rowsOnPageSD, changedRowsSD, cancelSD, variableSD);
        deleteCBData(id, rowsOnPageSD, '#gridSD', 1);

    });

    gridSD.on('rowRemoving', function (e, $row, id, record) {
        rowRemowingGroup(record, deleteURLSD, cancelSD, rowsOnPageSD, changedRowsSD, variableSD)
    });


    gridSD.on('pageSizeChange', function (e, newSize) {
        pageSizeChange(variableSD, newSize);
    });


//});