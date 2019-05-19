function dataForUpdate(record){
    var rowForUpdate = {};
    rowForUpdate.id = record.ID;
    rowForUpdate.name = record.Name;
    rowForUpdate.email = record.Email;
    rowForUpdate.id_right  = record.RightID;
    return rowForUpdate;
}