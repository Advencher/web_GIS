function dataForInsert(data){
    var rowForInsert = {};
    //rowForInsert.id_sample = data;
    rowForInsert.id_station = '1';
    rowForInsert.date = '2015-12-12 00:00:00';
    rowForInsert.comment = '';
    rowForInsert.serial_number = '00/00';
    return rowForInsert;
}

function dataForDelete(data){
    var rowForDelete = {};
    rowForDelete.id_sample = data.ID;
    return rowForDelete;
}

function dataForInsertDG(data){
    var rowForInsert = {};
    rowForInsert.ID = data;
    rowForInsert.StationID = '1';
    rowForInsert.Station = '5, Невская губа';
    rowForInsert.Date = '12/12/2015';
    rowForInsert.Time = '00:00:00';
    rowForInsert.UTC = '+03';
    rowForInsert.Comment = '';
    rowForInsert.SerialNumber = '00/00';
    rowForInsert.Longitude = '30.22';
    rowForInsert.Latitude = '59.89';
    rowForInsert.CountPho = 0;
    rowForInsert.CountPhy = 0;
    return rowForInsert;
}

function dataForCancelDelete(row){
    var rowForInsert = {};
    rowForInsert.id_sample = row.ID;
    rowForInsert.id_station = row.StationID;
    rowForInsert.date = dateToDBFormat(row);
    rowForInsert.comment = row.Comment;
    rowForInsert.serial_number = row.SerialNumber;
    return rowForInsert;
}