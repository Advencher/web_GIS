function dataForUpdateSpecie(record){

    var rowForUpdate = {};
    rowForUpdate.id_specie_in_phyto = record.ID;
    rowForUpdate.id_species = record.IDSpecies;
    rowForUpdate.percentage_of_total = record.PercentageOfTotal;
    rowForUpdate.percentage_of_the_total_biomass = record.PercentageOfTheTotalBiomass;
    rowForUpdate.number = record.Number;
    rowForUpdate.biomass = record.Biomass;
    return rowForUpdate;
}

