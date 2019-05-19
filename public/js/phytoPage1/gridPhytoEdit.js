var gridFT, rowsOnPageFT = [], changedRowsFT = [],
    cancelFT = [], k = -1, variableFT = [];
variableFT.z = -1;
variableFT.pressedUndoButton = false;
variableFT.rowAdded = false;
variableFT.pageChanged = false;
variableFT.pageSize = 20;
    var dataSource = '/phytos1',
    updateURLFT = '/update_phyto1';

var changeColorStyle = $('#UNUSED_HTML_ID');

gridFT = $('#grid').grid({

    dataSource: dataSource,
    headerRowHeight: 'fixed',
    bodyRowHeight: 'fixed',
    fontSize: '12px',
    uiLibrary: 'bootstrap4',
    primaryKey: 'ID',
    inlineEditing: { mode: 'command' },
    columns: [
        { field: 'ID', sortable: true},
        { field: 'Station', title:'Станция', type: 'dropdown', editField: 'StationID',editor: false, sortable: true, width: 200},//{ dataSource: '/stationsCB', valueField: 'id' }
        { field: 'Date', title:'Дата', type: 'date', editor: false , sortable: true},
        { field: 'Time', title:'Время', editor: false },
        { field: 'UTC' },
        { field: 'Horizon', title:'Горизонт', type: 'dropdown', editField: 'HorizonID',  editor: select2editorHorizon},
        { field: 'Total', title:'Численность т/л' , editor: true},
        { field: 'TotalSpecies', title:'Всего видов' , editor: true},
        { field: 'TotalBiomass', title:'Общая биомасса мг/л', editor: true },
        { field: 'TotalPercent', title:'% от общей численности', editor: true },
        { field: 'BiomassPercent', title:'% от общей массы', editor: true },
        { field: 'IDSample', hidden:true},
        { field: 'SaprobityID', hidden:true},
        { field: 'WaterPurityID', hidden:true},
        { field: 'UpholdingTime', hidden:true},
        { field: 'ConcentratedSampleVolume', hidden:true},
        { field: 'CamerasViewedNumber', hidden:true},
        { field: 'Latitude', hidden:true},
        { field: 'Longitude', hidden:true},
        { field: 'Info', title: 'Далее', type: 'icon',width: 60, icon: 'fa fa-paperclip fa-2x',
            events: {'click': function (e) {
                    goToExtraDialog(e);
                }
            }
        },
        { field: 'GroupsAndSpecies', title: 'Группы и Виды', type: 'icon',width: 60, icon: 'fa fa-caret-square-o-down fa-2x',
            events: {'click': function (e) {
                    changeColorStyle.css('color', '#000000');
                    changeColorStyle = $(e.target);
                    downloadPhyto('/showPageSpGp', e.data.record.ID);
                    changeColorStyle.css('color', '#3fc925');

                }
            }
        }
    ],
    //autoBind: false,
    pager: { limit: 20 }
});

//update phyto samples for dialog window
$('#btnChangePhytoExtra').on('click', function () {
    updateExtraDialog();
});


$('#btnUndo').click(function() {
    btnUndo(updateURLFT, null, gridFT, rowsOnPageFT, changedRowsFT, cancelFT, variableFT);
});


gridFT.on('dataBound', function (e, records, totalRecords) {
    dataBound(rowsOnPageFT, variableFT, gridFT, records);
    $('#grid').find(('[role=delete]')).attr('hidden', '');
    changeColorStyle.css('color', '#000000');
});


gridFT.on('rowCancelChanged', function (e, id, record) {//После отмены изменения строки
    deleteCBData(id, rowsOnPageFT, '#grid', 1);
});

gridFT.on('rowDataChanged', function (e, id, record) {//После изменения строки
    console.log('@@rowDataChanged@@');
    update(record, updateURLFT, gridFT, rowsOnPageFT, changedRowsFT, cancelFT, variableFT);
    deleteCBData(id, rowsOnPageFT, '#grid', 1);

});

function downloadPhyto(URL, data){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: URL,
        data: {'id_phyto': data},
        method: 'POST'
        // async: false
    })
        .done(function (html) {
            $('#contentPhyto').html(html);
        })
        .fail(function (answer){
            console.log(  answer );
            alert('Что-то пошло не так. Обратитесь к администратору');
        });
}