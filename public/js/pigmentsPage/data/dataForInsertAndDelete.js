function dataForInsert(data){
    var rowForInsert = {};
    rowForInsert.id_sample = data;
    return rowForInsert;
}

function dataForDelete(data){
    var rowForDelete = {};
    rowForDelete.id_pps = data.ID;
    return rowForDelete;
}

function dataForInsertDG(data){
    var rowForInsert = {};
	rowForInsert.ID = data;
	$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
	});
        $.ajax({ url: '/pigmentsview', data: {'sid': pigment_sid}, dataType: "json", async: false, method: 'GET' })
            .done(function (data) {
                console.log(data.records[0]);
				console.log(data.records[0].ID);
				rowForInsert.Station = data.records[0].Station;
				rowForInsert.Date = data.records[0].Date;
				rowForInsert.Latitude = data.records[0].Latitude;
				rowForInsert.Longitude = data.records[0].Longitude;
            })
            .fail(function () {
                 alert('Не получены данные базы! Обратитесь к администратору!');
            });
    rowForInsert.SerialNumber = '';
	rowForInsert.ChlA = '0';
	rowForInsert.ChlB = '0';
	rowForInsert.ChlC = '0';
	rowForInsert.TropId = '0';
	rowForInsert.TropCh = '';
	rowForInsert.VolumeOfPW = '0';
	rowForInsert.A665k = '0';
	rowForInsert.Pigmentindex = '0';
	rowForInsert.Pheopigments = '0';
	rowForInsert.Comment = '';
    return rowForInsert;
}

function dataForCancelDelete(row){
    var rowForInsert = {};
    rowForInsert.id_pps = row.ID;
	rowForInsert.id_sample = pigment_sid;
    rowForInsert.comment = row.Comment;
    rowForInsert.serial_number = row.SerialNumber;
	rowForInsert.chla = row.ChlA;
	rowForInsert.chla = row.ChlB;
	rowForInsert.chla = row.ChlC;
	rowForInsert.volumeoffilteredwater = row.VolumeOfPW;
	rowForInsert.trop_id = row.TropId;
	rowForInsert.a665k = row.A665k;
	rowForInsert.pigmentindex = row.Pigmentindex;
	rowForInsert.pheopigments = row.Pheopigments;
    return rowForInsert;
}