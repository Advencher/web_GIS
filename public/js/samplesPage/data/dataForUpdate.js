function dataForUpdate(record){


    var rowForUpdate = {};
    rowForUpdate.id_sample = record.ID;
    //!!!!!!!!!!!!!!!!!
    //rowForInsert.id_station = '1';
    rowForUpdate.name = record.Station;
    rowForUpdate.id_station = record.StationID;
    rowForUpdate.date =  dateToDBFormat(record);
    rowForUpdate.comment = record.Comment;
    rowForUpdate.serial_number = record.SerialNumber;
    return rowForUpdate;
}