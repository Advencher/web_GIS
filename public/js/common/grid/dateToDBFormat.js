function dateToDBFormat(record){
    var reorder = splitString(record.Date, '/');
    var day = reorder[0];
    var month = reorder [1];
    var year = reorder [2];
    var date = year + '-' + month + '-' + day + ' ' + record.Time;//+ record.UTC
    return date;
}