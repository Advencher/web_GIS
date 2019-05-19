<div id="page-wrapper" class="gray-bg" style="margin-left: 300px; margin-right: 300px">
    {{----}}
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                   <br/>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5>Фильтрация</h5>
                                    <div class="ibox-tools">
                                        <a class="collapse-link">
                                            <i class="fa fa-chevron-up"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="ibox-content">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div id="reportrange" class="form-control">
                                                <i class="fa fa-calendar"></i>
                                                <span></span> <b class="caret"></b>
                                            </div>

                                            <a href="#" id="allTime">За всё время</a>
                                            <a href="#" id="get-calendar-field" style="margin-left: 10px;"></a>
                                            
                                        </div>
                                        <div class="col-md-4">
                                            <select class="selectArea form-control" multiple="multiple">

                                            </select>

                                            <a href="#" id="selectAquatories">Выбрать все</a>&nbsp;&nbsp;&nbsp;
                                            <a href="#" id="clearAquatories">Очистить</a>
                                        </div>
                                        <div class="col-md-4">
                                            <select class="selectStation form-control" multiple="multiple">
                                            </select>
                                            <a href="#" id="selectStations">Выбрать все</a>
                                            &nbsp;&nbsp;&nbsp;
                                            <a href="#" id="clearStations">Очистить</a>
                                            <!-- <a href="#" id="mapStations" style="margin-left: 10px;">Отметить на карте</a> -->
                                            <a href="#" id="mapStations-ajax" style="margin-left: 10px;">Отметить на карте</a>
                                            
                                        </div>
                                    </div>
                                    <br/>
                                    <button id="btnAcceptFilter" class="gj-button-md">Применить к таблице</button>
                                </div>
                            </div>
                            <br/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="map" style="width: 75%; height: 600px; display: none; margin: auto;"></div>
    <div id="map-diagram" style="width: 75%; height: 600px; display: none; margin: auto; margin-top: 45px;"></div>


</div>