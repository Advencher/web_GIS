//$(document).ready(function () {
    var gridFT, rowsOnPageFT = [], changedRowsFT = [],
        cancelFT = [], variableFT = [];
    variableFT.z = -1;
    variableFT.pressedUndoButton = false;
    variableFT.rowAdded = false;
    variableFT.pageChanged = true;
    variableFT.pageSize = 20;
    var
        dataSource = '/samples_grid',
        updateURLFT = '/update_sample',
        CBURLFT = '/stationsCB';

    function select2editor($editorContainer, value, record) {
        dataForEditor($editorContainer, value, record, CBURLFT, record.StationID, rowsOnPageFT);
    }

    gridFT = $('#grid').grid({

        dataSource: dataSource,
        uiLibrary: 'bootstrap4',
        headerRowHeight: 'fixed',
        bodyRowHeight: 'fixed',
        fontSize: '12px',
        primaryKey: 'ID',
        inlineEditing: { mode: 'command' },
        columns: [
            { field: 'ID', width: 44, sortable: true },
            { field: 'Station', title:'Станция', type: 'dropdown', editField: 'StationID',  editor: select2editor, sortable: true, width: 200},//{ dataSource: '/stationsCB', valueField: 'id' }
            { field: 'Date', title:'Дата', type: 'date', editor: true , sortable: true, format: 'dd/mm/yyyy', width: 110},
            { field: 'Time', title:'Время', editor: true , width: 70},
            { field: 'UTC' , width: 40},
            { field: 'Longitude', title:'Долгота' , width: 60},
            { field: 'Latitude', title:'Широта' , width: 60},
            { field: 'SerialNumber', title:'Серийный номер', editor: true, sortable: true, width: 150},
            { field: 'Comment', title:'Комментарий', editor: true, width: 150 },
            { field: 'Info', title: 'П',  width: 32, type: 'icon', icon: 'fa fa-envira',
                events: {'click': function (e) {
                        $("#tab a").eq(2).tab('show');
						download('/pigments_tab', {'sid':e.data.id});
                    }
                }
            },
            { field: 'InfoPhyto', title: 'Ф',  width: 40, type: 'icon', icon: 'fa fa-tencent-weibo fa-2x',
                events: {'click': function (e) {
                        window.open('/onePhytoMain?id_sample='+e.data.record.ID+'&station='+e.data.record.Station + '&id_station='+e.data.record.StationID + '&date='+ e.data.record.Date + '&time=' + e.data.record.Time + '&utc=' + e.data.record.UTC  )

                    }
                }
            },
            { field: 'CountPho', hidden : true},
            { field: 'CountPhy', hidden : true}

        ],
        //autoBind: false,
        pager: { limit: 20 }
    });

    gridFT.on('dataBound', function (e, records, totalRecords) {//@@
        dataBound(rowsOnPageFT, variableFT, gridFT, records);
        $('#grid').find(('[role=delete]')).attr('hidden', '')//Только Edit
        // var deleteBtn = $('[role=delete]');
        // for (var i = 0; i < deleteBtn.length; i++) {
        //     deleteBtn[i].setAttribute('hidden', '');
        // }
    });

    gridFT.on('rowCancelChanged', function (e, id, record) {//После отмены изменения строки //@@
        deleteCBData(id, rowsOnPageFT, '#grid', 1);
    });

    gridFT.on('rowDataChanged', function (e, id, record) {//После изменения строки //@@
        console.log('@@rowDataChanged@@');
        deleteCBData(id, rowsOnPageFT, '#grid', 1);
        update(record, updateURLFT, gridFT, rowsOnPageFT, changedRowsFT, cancelFT, variableFT);
    });

    $('#btnUndo').click(function() {
        btnUndo(updateURLFT, null, gridFT, rowsOnPageFT, changedRowsFT, cancelFT, variableFT)
    });

//});