function dataForCancelDeleteGroup(row){
    var rowForInsert = {};
    rowForInsert.id_phyto = row.IDphyto;
    rowForInsert.id_group = row.IDGroup;
    rowForInsert.total_species_in_group = row.TotalSpecies;
    rowForInsert.total_percent = row.TotalPercent;
    rowForInsert.biomass_percent = row.BiomassPercent;
    rowForInsert.number = row.Number;
    rowForInsert.biomass = row.Biomass;
    return rowForInsert;
}

function dataForInsertGroup(id_phyto){
    var rowForInsert = {};
    rowForInsert.id_phyto = id_phyto;
    rowForInsert.id_group = '0';
    rowForInsert.total_species_in_group = '0';
    rowForInsert.total_percent = '0';
    rowForInsert.biomass_percent = '0';
    rowForInsert.number = '0';
    rowForInsert.biomass = '0';
    return rowForInsert;
}

function dataForInsertDGGroup(id_phyto, id_group_in_phyto){
    var rowForInsert = {};
    rowForInsert.ID = id_group_in_phyto;
    rowForInsert.IDphyto = id_phyto;
    rowForInsert.IDGroup = '0';
    rowForInsert.TotalSpecies = '0';
    rowForInsert.TotalPercent = '0';
    rowForInsert.BiomassPercent = '0';
    rowForInsert.Number = '0';
    rowForInsert.Biomass = '0';
    rowForInsert.GroupName = 'Группа не определена';
    return rowForInsert;
}

function dataForDeleteGroup(data){
    var rowForDelete = {};
    rowForDelete.id_group_in_phyto = data.ID;
    return rowForDelete;
}
