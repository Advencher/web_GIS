var gridFT, rowsOnPageFT = [], changedRowsFT = [],
    cancelFT = [], k = -1, variableFT = [];
variableFT.z = -1;
variableFT.pressedUndoButton = false;
variableFT.rowAdded = false;
variableFT.pageChanged = false;
variableFT.pageSize = 20;


var GET = {};
var query = window.location.search.substring(1).split("&");
for (var i = 0, max = query.length; i < max; i++)
{
    if (query[i] === "") // check for trailing & with no param
        continue;

    var param = query[i].split("=");
    GET[decodeURIComponent(param[0])] = decodeURIComponent(param[1] || "");
}

var id_sample = GET.id_sample;
var station = GET.station;
var id_station = GET.id_station;
var date = GET.date;
var time = GET.time;
var utc = GET.utc;

var text =  document.getElementById('globalID').textContent;
document.getElementById('globalID').innerHTML = text + GET.id_sample;

var dataSource = '/showOnePhytoSample?id_sample=' + id_sample;



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
        { field: 'Station', title:'Станция', sortable: true, width: 200},//{ dataSource: '/stationsCB', valueField: 'id' }
        { field: 'Date', title:'Дата', type: 'date', editor: false , sortable: true},
        { field: 'Time', title:'Время', editor: false },
        { field: 'UTC' },
        { field: 'Horizon', title:'Горизонт', type: 'dropdown', editField: 'HorizonID'},
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
        { field: 'Info', title: 'Еще', type: 'icon',width: 60, icon: 'fa fa-paperclip fa-2x',
            events: {'click': function (e) {
                    goToExtraDialog(e);
                }
            }
        },
        { field: 'GroupsAndSpecies', title: 'Группы Виды', width: 60, type: 'icon', icon: 'fa fa-caret-square-o-down fa-2x',
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

//update phyto samples for dialog window
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
