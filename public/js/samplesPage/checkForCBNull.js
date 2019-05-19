function checkForCBNull(record, changedRows, variable,onPage){
    if (record.StationID == null && !onPage) {
        record.StationID = changedRows[variable.z].StationID;
        record.Station = changedRows[variable.z].Station;
        return true;
    }
    if (record.StationID == null && onPage) {
        record.StationID = changedRows[variable.z].StationID;
        record.Station = changedRows[variable.z].Station;
        return true;
    }
    return false;
}