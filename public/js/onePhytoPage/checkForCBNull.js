function checkForCBNull(record, changedRows, variable,onPage){
    if (record.HorizonID == null && !onPage) {
        record.HorizonID = changedRows[variable.z].HorizonID;
        record.Horizon = changedRows[variable.z].HorizonID;
        return true;
    }
    if (record.HorizonID  == null && onPage) {
        record.HorizonID  = changedRows[variable.z].HorizonID;
        record.HorizonID  = changedRows[variable.z].Horizon;
        return true;
    }
    return false;
}