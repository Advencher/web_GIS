//$(document).ready(function () {
    //Учитываем, что на одной странице несколько таблиц
    var gridFT, rowsOnPageFT = [], changedRowsFT = [],
        cancelFT = [], k = -1, variableFT = [];
    variableFT.z = -1;
    variableFT.pressedUndoButton = false;
    variableFT.rowAdded = false;
    variableFT.pageChanged = false;
    variableFT.pageSize = 20;
    var dataSource = '/phytos1',
        insertURLFT = '/insert_phyto1',
        deleteURLFT = '/delete_phyto1',
        updateURLFT = '/update_phyto1',
        maxIdURLFT = '/maxIDPhyto';

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
            { field: 'Info', title: 'Еще', type: 'icon',width: 55, icon: 'fa fa-paperclip fa-2x',
                events: {'click': function (e) {
                        goToExtraDialog(e);
                    }
                }
            },
            { field: 'GroupsAndSpecies', title: 'Группы Виды', width: 70, type: 'icon', icon: 'fa fa-caret-square-o-down fa-2x',
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


    $('#btn1').on('click', function () {//для изменения dataSource. Если фильтр будет
        //function setDataSource() {
        console.log(gridFT.data().dataSource);
        gridFT.data().dataSource = 'daddas';
        console.log(gridFT.data().dataSource);
        //grid.data().dataSource;
        //}
    });



    $('#btnUndo').click(function() {
        btnUndo(updateURLFT, insertURLFT, gridFT, rowsOnPageFT, changedRowsFT, cancelFT, variableFT);
    });


    $('#btnAdd').click(function() {
        dialog.open();
    });

    gridFT.on('dataBound', function (e, records, totalRecords) {
        dataBound(rowsOnPageFT, variableFT, gridFT, records);
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

    gridFT.on('rowRemoving', function (e, $row, id, record) {
        rowRemowing(record, deleteURLFT, cancelFT, rowsOnPageFT, changedRowsFT, variableFT)
    });


    gridFT.on('pageSizeChange', function (e, newSize) {
        pageSizeChange(variableFT, newSize);
    });

    var SearchGrid;

    $('#SubmitSearch').on('click', function () {

        SearchGrid = $('#searchGrid').grid({
            dataSource: '/search1',
            headerRowHeight: 'fixed',
            bodyRowHeight: 'fixed',
            fontSize: '12px',
            uiLibrary: 'bootstrap4',
            primaryKey: 'ID',
            autoLoad: true,
            columns: [
                {field: 'ID', width: 44},
                {field: 'Station', title: 'Станция', type: 'dropdown', sortable: true},
                {field: 'Date', title: 'Дата', type: 'date', sortable: true},
                {field: 'Time', title: 'Время', width: 80},
                {field: 'UTC', width: 80},
                {field: 'SerialNumber', title: 'Серийный номер'}
            ],
            pager: {limit: 20}
        });
        SearchGrid.reload({page: 1, search: $('#search').val()});


        //, from: $('#dateFrom').val(), to: $('#dateTo')

        $('#btnClear').on('click', function () {
            $('#search').val('');
            $('#searchGrid').grid('clear', true, true);
        });
    });

    $('#searchGrid').on('rowSelect', function (e, $row, id, record) {
        dialog.close();
        var gridName = '#grid';
        var station = record.Station;
        var id_station = record.StationID;
        var date = record.Date;
        var time = record.Time;
        var utc = record.UTC;
        addRowPhytoGlobal(gridName, maxIdURLFT, id, station, id_station, date, time, utc, insertURLFT, gridFT, cancelFT, rowsOnPageFT, changedRowsFT, variableFT);
        //$('#searchGrid').grid('clear', true, true);
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
//});