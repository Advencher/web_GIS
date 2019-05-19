function dataForUpdateGroup(record){

    var rowForUpdate = {};
    rowForUpdate.id_group_in_phyto = record.ID;
    rowForUpdate.id_group = record.IDGroup;
    rowForUpdate.total_species_in_group = record.TotalSpecies;
    rowForUpdate.total_percent = record.TotalPercent;
    rowForUpdate.biomass_percent = record.BiomassPercent;
    rowForUpdate.number = record.Number;
    rowForUpdate.biomass = record.Biomass;
    return rowForUpdate;
}