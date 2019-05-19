function dataForUpdate(record){
    var rowForUpdate = {};
    rowForUpdate.id_pps = record.ID;
	rowForUpdate.comment = record.Comment;
	rowForUpdate.serial_number = record.SerialNumber;
	rowForUpdate.trop_id = record.TropId;
	rowForUpdate.volumeoffilteredwater = record.VolumeOfPW;
	rowForUpdate.chla = record.ChlA;
	rowForUpdate.chlb = record.ChlB;
	rowForUpdate.chlc = record.ChlC;
	rowForUpdate.a665k = record.A665k;
	rowForUpdate.pigmentindex = record.Pigmentindex;
	rowForUpdate.pheopigments = record.Pheopigments;
	console.log(rowForUpdate);
    //!!!!!!!!!!!!!!!!!
    //rowForInsert.id_station = '1';
    return rowForUpdate;
}