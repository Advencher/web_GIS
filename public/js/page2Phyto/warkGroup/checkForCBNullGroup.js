function checkForCBNullGroup(record, changedRows, variable,onPage){
    if (record.IDGroup == null && !onPage) {
        record.IDGroup = changedRows[variable.z].IDGroup;
        record.GroupName = changedRows[variable.z].IDGroup;
        return true;
    }
    if (record.IDGroup  == null && onPage) {
        record.IDGroup  = changedRows[variable.z].IDGroup;
        record.IDGroup = changedRows[variable.z].GroupName;
        return true;
    }
    return false;
}