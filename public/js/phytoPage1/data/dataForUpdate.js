function dataForUpdate(record){

    var rowForUpdate = {};
    rowForUpdate.id_phyto = record.ID;
    rowForUpdate.id_horizon = record.HorizonID;
    rowForUpdate.total = record.Total;
    rowForUpdate.total_species = record.TotalSpecies;
    rowForUpdate.total_biomass = record.TotalBiomass;
    rowForUpdate.total_percent = record.TotalPercent;
    rowForUpdate.biomass_percent = record.BiomassPercent;
    rowForUpdate.id_saprobity = record.SaprobityID;
    rowForUpdate.id_class_of_purity = record.WaterPurityID;
    rowForUpdate.upholding_sample_time = record.UpholdingTime;
    rowForUpdate.concentrated_sample_volume = record.ConcentratedSampleVolume;
    rowForUpdate.cameras_viewed_number = record.CamerasViewedNumber;
    return rowForUpdate;
}