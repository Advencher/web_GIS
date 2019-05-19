//$(document).ready(function () {
    var gridFT, rowsOnPageFT = [], changedRowsFT = [],
        cancelFT = [], variableFT = [];
    variableFT.z = -1;
    variableFT.pressedUndoButton = false;
    variableFT.rowAdded = false;
    variableFT.pageChanged = true;
    variableFT.pageSize = 5;
    var
		dataSource = '/pigmentsview',
        updateURLFT = '/update_pigment',
        CBURLFT = '/tropicCB';

    function select2editor($editorContainer, value, record) {
        dataForEditor($editorContainer, value, record, CBURLFT, record.StationID, rowsOnPageFT);
    }
	
	if (typeof pigment_sid !== 'undefined' && pigment_sid !== -1) {
		console.log('get sample finded');
		dataSource = '/pigmentsview?sid='+pigment_sid;
		console.log(dataSource);
	}
	
    gridFT = $('#grid').grid({

        dataSource: dataSource,
        uiLibrary: 'bootstrap4',
		headerRowHeight: 'fixed',
        bodyRowHeight: 'fixed',
        fontSize: '12px',
        primaryKey: 'ID',
        inlineEditing: { mode: 'command'},
        columns: [
            { field: 'ID', width: 44, sortable: true },
			{ field: 'Station', title:'Станция', sortable: true, width: 120},
			{ field: 'Date', title:'Дата', type: 'date', sortable: true, format: 'yyyy/dd/mm', width: 90 },
			{ field: 'SerialNumber', title:'С. №', editor: true , width: 55},
			{ field: 'ChlA', title:'Хлор. A', tooltip: 'Хлорофил A', editor: true , width: 55},
			{ field: 'ChlB', title:'Хлор. B', tooltip: 'Хлорофил B', editor: true , width: 55},
			{ field: 'ChlC', title:'Хлор. C', tooltip: 'Хлорофил C', editor: true , width: 55},
			{ field: 'TropCh', title:'ТХ', type: 'dropdown', editField: 'TropId',  editor: select2editor , width: 40},
			{ field: 'VolumeOfPW', title:'ОПВ', tooltip: 'Объем профильтрованной воды', editor: true , width: 55},
			{ field: 'A665k', title:'A(665k)', tooltip: 'A(665k)', editor: true , width: 55},
			{ field: 'Pigmentindex', title:'ПИ', tooltip: 'Пигментный индекс', editor: true , width: 55},
			{ field: 'Pheopigments', title:'ФП', tooltip: 'Феопигменты', editor: true , width: 55},
			{ field: 'Comment', title:'Коммент.', tooltip: 'Комментарий', editor: true , width: 120}
			//{ field: 'StationId', hidden: true}
        ],
		detailTemplate: '<div><b>Широта:</b> {Latitude} <b>Долгота:</b> {Longitude}</div>',
        icons: {
            expandRow: '<i class="fa fa-plus" aria-hidden="true"></i>',
            collapseRow: '<i class="fa fa-minus" aria-hidden="true"></i>'
        },
        //autoBind: false,
        pager: { limit: 10, sizes: [5, 10, 15, 20] }
    });

    gridFT.on('dataBound', function (e, records, totalRecords) {
        dataBound(rowsOnPageFT, variableFT, gridFT, records);
		$('#grid').find(('[role=delete]')).attr('hidden', '')//Только Edit
        //deleteCBDataDataBound(rowsOnPageFT, '#grid', 1); //Если из edit не вышел, но обновил страницу, изменил число строк на странице, перешел на другую страницу
    });

    gridFT.on('rowCancelChanged', function (e, id, record) {//После отмены изменения строки
        deleteCBData(id, rowsOnPageFT, '#grid', 1);
    });

    gridFT.on('rowDataChanged', function (e, id, record) {//После изменения строки
        console.log('@@rowDataChanged@@');
        //deleteCBData(id, rowsOnPageFT, '#grid', 1); //Сработает rowCancelChanged 0_0 0_0 0_0 0_0 0_0
        //var tempVariable = [];
        //tempVariable.temp = -1;
        //tempVariable.k = -1;
        //findRecord(rowsOnPageFT, changedRowsFT, record, variableFT, tempVariable);
        //Если прошла проверка
        update(record, updateURLFT, gridFT, rowsOnPageFT, changedRowsFT, cancelFT, variableFT);

        //if(updateValidate(record)){changeChells(); } //разная для разных таблиц


    });

    $('#btnUndo').click(function() {
        btnUndo(updateURLFT, insertURLFT, gridFT, rowsOnPageFT, changedRowsFT, cancelFT, variableFT);
    });

//});