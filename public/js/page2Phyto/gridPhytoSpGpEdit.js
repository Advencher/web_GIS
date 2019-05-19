var gridFT1, rowsOnPageFT1 = [], changedRowsFT1 = [],
    cancelFT1 = [], k = -1, variableFT1 = [];
variableFT1.z = -1;
variableFT1.pressedUndoButton = false;
variableFT1.rowAdded = false;
variableFT1.pageChanged = false;
variableFT1.pageSize = 5;
var updateURLFT1 = '/update_species';


var gridSD, rowsOnPageSD = [], changedRowsSD = [],
    cancelSD = [], k2 = -1, variableSD = [];
variableSD.z = -1;
variableSD.pressedUndoButton = false;
variableSD.rowAdded = false;
variableSD.pageChanged = false;
variableSD.pageSize = 5;
var updateURLSD = '/update_groups';


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



$('#btnUndoSpecieSample').click(function() {
    btnUndoSpecie(updateURLFT1, null, gridFT1, rowsOnPageFT1, changedRowsFT1, cancelFT1, variableFT1);
});


gridFT1.on('dataBound', function (e, records, totalRecords) {
    dataBoundSpecie(rowsOnPageFT1, variableFT1, gridFT1, records);
    $('#gridFT1').find(('[role=delete]')).attr('hidden', '');
});


gridFT1.on('rowCancelChanged', function (e, id, record) {//После отмены изменения строки
    deleteCBData(id, rowsOnPageFT1, '#gridFT1', 1);
});

gridFT1.on('rowDataChanged', function (e, id, record) {//После изменения строки
    console.log('@@rowDataChanged@@');
    updateSpecie(record, updateURLFT1, gridFT1, rowsOnPageFT1, changedRowsFT1, cancelFT1, variableFT1);
    deleteCBData(id, rowsOnPageFT1, '#gridFT1', 1);

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

$('#btnUndoGroup').click(function() {
    btnUndoGroup(updateURLSD, null, gridSD, rowsOnPageSD, changedRowsSD, cancelSD, variableSD);
});


gridSD.on('dataBound', function (e, records, totalRecords) {
    dataBoundGroup(rowsOnPageSD, variableSD, gridSD, records);
    $('#gridSD').find(('[role=delete]')).attr('hidden', '');
});


gridSD.on('rowCancelChanged', function (e, id, record) {//После отмены изменения строки
    deleteCBData(id, rowsOnPageSD, '#gridSD', 1);
});

gridSD.on('rowDataChanged', function (e, id, record) {//После изменения строки
    console.log('@@rowDataChanged@@');
    updateGroup(record, updateURLSD, gridSD, rowsOnPageSD, changedRowsSD, cancelSD, variableSD);
    deleteCBData(id, rowsOnPageSD, '#gridSD', 1);

});
