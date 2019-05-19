//$(document).ready(function () {
    var gridFT,
		dataSource = '/pigmentsview';
	
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
        columns: [
            { field: 'ID', width: 44, sortable: true },
			{ field: 'Station', title:'Станция', sortable: true, width: 120},
			{ field: 'Date', title:'Дата', type: 'date', sortable: true, format: 'yyyy/dd/mm', width: 90 },
			{ field: 'SerialNumber', title:'С. №', width: 55},
			{ field: 'ChlA', title:'Хлор. A', tooltip: 'Хлорофил A', width: 55},
			{ field: 'ChlB', title:'Хлор. B', tooltip: 'Хлорофил B', width: 55},
			{ field: 'ChlC', title:'Хлор. C', tooltip: 'Хлорофил C', width: 55},
			{ field: 'TropCh', title:'ТХ', type: 'dropdown', editField: 'TropId', width: 40},
			{ field: 'VolumeOfPW', title:'ОПВ', tooltip: 'Объем профильтрованной воды', width: 55},
			{ field: 'A665k', title:'A(665k)', tooltip: 'A(665k)', width: 55},
			{ field: 'Pigmentindex', title:'ПИ', tooltip: 'Пигментный индекс', width: 55},
			{ field: 'Pheopigments', title:'ФП', tooltip: 'Феопигменты', width: 55},
			{ field: 'Comment', title:'Коммент.', tooltip: 'Комментарий', width: 120}
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
	