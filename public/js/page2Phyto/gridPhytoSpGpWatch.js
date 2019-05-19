var gridFT1, gridSD;

var result_id = document.getElementById('IDphyto').value;

gridFT1 = $('#gridFT1').grid({

    dataSource: '/phytosSP?id_phyto=' + result_id,
    uiLibrary: 'bootstrap4',
    headerRowHeight: 'fixed',
    bodyRowHeight: 'fixed',
    fontSize: '12px',
    primaryKey: 'ID',
    columns: [
        { field: 'ID', hidden: true},
        { field: 'IDphyto', hidden: true},
        { field: 'SpecieName', title:'Вид фитопланктона', type: 'dropdown', editField: 'IDSpecies', sortable: true, width: 160},
        { field: 'PercentageOfTotal', title:'% от общей численности'},
        { field: 'PercentageOfTheTotalBiomass', title:'% от общей биомассы' },
        { field: 'Number' , title:'Численность вида в пробе'},
        { field: 'Biomass' , title:'Биомасса'},
        { field: 'GroupName', title:'Группа фитопланктона', editor: false, sortable: true}
    ],
    //autoBind: false,
    pager: { limit: 5 }
});

gridSD = $('#gridSD').grid({

    dataSource: '/phytosGP?id_phyto=' + result_id,
    uiLibrary: 'bootstrap4',
    headerRowHeight: 'fixed',
    bodyRowHeight: 'fixed',
    fontSize: '12px',
    primaryKey: 'ID',
    columns: [
        { field: 'ID', hidden: true},
        { field: 'IDphyto', hidden: true},
        { field: 'IDGroup', hidden: true},
        { field: 'GroupName', title:'Группа фитопланктона', type: 'dropdown', editField: 'IDGroup', sortable: true, width: 160},
        { field: 'TotalSpecies', title:'Всего видов группе'},
        { field: 'TotalPercent', title:'Процент группы в пробе'},
        { field: 'BiomassPercent', title:'Процент биомассы' },
        { field: 'Number' , title:'Численность в пробе'},
        { field: 'Biomass' , title:'Биомасса'}
    ],
    //autoBind: false,
    pager: { limit: 5 }
});