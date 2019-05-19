function checkForCBNullSpecie(record, changedRows, variable,onPage){
    if (record.IDSpecies == null && !onPage) {
        record.IDSpecies = changedRows[variable.z].IDSpecies;
        record.SpecieName = changedRows[variable.z].IDSpecies;
        return true;
    }
    if (record.IDSpecies  == null && onPage) {
        record.IDSpecies  = changedRows[variable.z].IDSpecies;
        record.IDSpecies = changedRows[variable.z].SpecieName;
        return true;
    }
    return false;
}