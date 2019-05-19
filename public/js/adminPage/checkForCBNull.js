function checkForCBNull(record, changedRows, variable,onPage){
    if (record.RightID == null && !onPage) {
        record.RightID = changedRows[variable.z].RightID;
        record.Right = changedRows[variable.z].Right;
        return true;
    }
    if (record.RightID == null && onPage) {
        record.RightID = changedRows[variable.z].RightID;
        record.Right = changedRows[variable.z].Right;
        return true;
    }
    return false;
}