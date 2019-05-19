function dataForCancelDelete(row){
    var rowForInsert = {};
    rowForInsert.id_phyto = row.ID;
    rowForInsert.id_sample = row.IDSample;
    rowForInsert.id_horizon = row.HorizonID;
    rowForInsert.id_class_of_purity = row.WaterPurityID;
    rowForInsert.id_saprobity = row.SaprobityID;
    rowForInsert.total = row.Total;
    rowForInsert.total_species = row.TotalSpecies;
    rowForInsert.total_biomass = row.TotalBiomass;
    rowForInsert.total_percent = row.TotalPercent;
    rowForInsert.biomass_percent = row.BiomassPercent;
    rowForInsert.upholding_sample_time = row.UpholdingTime;
    rowForInsert.concentrated_sample_volume = row.ConcentratedSampleVolume;
    rowForInsert.cameras_viewed_number = row.CamerasViewedNumber;
    return rowForInsert;
}

function dataForInsert(data, IDsample){
    var rowForInsert = {};
    rowForInsert.id_phyto = data;
    rowForInsert.id_sample = IDsample;
    rowForInsert.id_horizon = "1";
    rowForInsert.id_class_of_purity = "1";
    rowForInsert.id_saprobity = "1";
    rowForInsert.total = "0";
    rowForInsert.total_species = "0";
    rowForInsert.total_biomass = "0";
    rowForInsert.total_percent = "0";
    rowForInsert.biomass_percent = "0";
    rowForInsert.upholding_sample_time = "0";
    rowForInsert.concentrated_sample_volume = "0";
    rowForInsert.cameras_viewed_number = "0";
    return rowForInsert;
}

function dataForInsertDG(data, IDsample, station, id_station, date, time, utc){
    var rowForInsert = {};
    rowForInsert.ID = data;
    rowForInsert.IDsample = IDsample;
    rowForInsert.StationID = id_station;
    rowForInsert.Station = station;
    rowForInsert.HorizonID = "1";
    rowForInsert.Horizon= "инт.";
    rowForInsert.SaprobityID = "1";
    rowForInsert.WaterPurityID = "1";
    rowForInsert.Total = "0";
    rowForInsert.TotalSpecies = "0";
    rowForInsert.TotalBiomass = "0";
    rowForInsert.TotalPercent = "0";
    rowForInsert.BiomassPercent = "0";
    rowForInsert.UpholdingTime = "0";
    rowForInsert.ConcentratedSampleVolume = "0";
    rowForInsert.CamerasViewedNumber = "0";
    rowForInsert.Date = date;
    rowForInsert.Time = time;
    rowForInsert.UTC = utc;
    return rowForInsert;
}

function dataForDelete(data){
    var rowForDelete = {};
    rowForDelete.id_phyto = data.ID;
    return rowForDelete;
}
