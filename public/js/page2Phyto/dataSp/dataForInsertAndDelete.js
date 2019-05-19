function dataForCancelDeleteSpecie(row){
    var rowForInsert = {};
    rowForInsert.id_phyto = row.IDphyto;
    rowForInsert.id_species = row.IDSpecies;
    rowForInsert.percentage_of_total = row.PercentageOfTotal;
    rowForInsert.percentage_of_the_total_biomass = row.PercentageOfTheTotalBiomass;
    rowForInsert.number = row.Number;
    rowForInsert.biomass = row.Biomass;
    return rowForInsert;
}

function dataForInsertSpecie(id_phyto){
    var rowForInsert = {};
    rowForInsert.id_phyto = id_phyto;
    rowForInsert.id_species = '0';
    rowForInsert.percentage_of_total = '0';
    rowForInsert.percentage_of_the_total_biomass='0';
    rowForInsert.number = '0';
    rowForInsert.biomass = '0';
    return rowForInsert;
}

function dataForInsertDGSpecie(id_phyto, id_specie_in_phyto){
    var rowForInsert = {};
    rowForInsert.ID = id_specie_in_phyto;
    rowForInsert.IDphyto = id_phyto;
    rowForInsert.IDSpecies = '0';
    rowForInsert.SpecieName = 'Вид не определен';
    rowForInsert.PercentageOfTotal = '0';
    rowForInsert.PercentageOfTheTotalBiomass = '0';
    rowForInsert.Number = '0';
    rowForInsert.Biomass = '0';
    rowForInsert.GroupName = 'Группа не определена';
    return rowForInsert;
}

function dataForDeleteSpecie(data){
    var rowForDelete = {};
    rowForDelete.id_specie_in_phyto = data.ID;
    return rowForDelete;
}
