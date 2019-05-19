
var gridFT, dataSource = '/phytos1';

var changeColorStyle = $('#UNUSED_HTML_ID');

gridFT = $('#grid').grid({

    dataSource: dataSource,
    headerRowHeight: 'fixed',
    bodyRowHeight: 'fixed',
    fontSize: '12px',
    uiLibrary: 'bootstrap4',
    primaryKey: 'ID',
    columns: [
        { field: 'ID', sortable: true},
        { field: 'Station', title:'Станция', type: 'dropdown', editField: 'StationID', sortable: true, width: 200},//{ dataSource: '/stationsCB', valueField: 'id' }
        { field: 'Date', title:'Дата', type: 'date', sortable: true},
        { field: 'Time', title:'Время'},
        { field: 'UTC' },
        { field: 'Horizon', title:'Горизонт', type: 'dropdown', editField: 'HorizonID',  editor: false},
        { field: 'Total', title:'Численность т/л' },
        { field: 'TotalSpecies', title:'Всего видов'},
        { field: 'TotalBiomass', title:'Общая биомасса мг/л'},
        { field: 'TotalPercent', title:'% от общей численности'},
        { field: 'BiomassPercent', title:'% от общей массы' },
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

gridFT.on('dataBound', function (e, records, totalRecords) {
    changeColorStyle.css('color', '#000000');
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