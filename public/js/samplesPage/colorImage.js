function colorImage(records, i){
    var row = $('#grid').find('[data-position=' + (i+1) + ']').eq(0).children();
    var Pho = row.eq(9);
    var Phy = row.eq(10);
    if (records[i].CountPho > 0)
        Pho.css('color','#00e600');
    else
        Pho.css('color','#000000');
    if (records[i].CountPhy > 0)
        Phy.css('color','#00e600');
    else
        Phy.css('color','#000000');
}