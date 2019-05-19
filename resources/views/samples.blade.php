
        {{--<canvas class="my-4" id="myChart" width="900" height="380"></canvas>--}}
        {{--@if(Illuminate\Support\Facades\Auth::check())--}}
<br/>
            @can('create', App\ViewNewSamples::class)

                <paper-dialog id="dialog" with-backdrop no-cancel-on-outside-click>
                    <h2>Добавление станции</h2>
                    <paper-input id="station_name" required label="Название станции" pattern=".{1,64}" error-message="не менее 1-го символа и не более 64-х"></paper-input><!-- required -->
                    <!--<div class="form-group">
                        <label >Название</label>
                        <input type="text" class="form-control" id="station_name"></input>
                    </div>-->
                    <paper-dropdown-menu-light label="Акватория" vertical-offset="60">
                        <paper-listbox class="dropdown-content" id="mydropdown" slot="dropdown-content"   selected="0">

                        </paper-listbox>
                    </paper-dropdown-menu-light>
                    <paper-input id="station_serial_number"  label="Серийный номер" ></paper-input><!-- required -->
                    <paper-input id="station_longitude" required label="Долгота" pattern="[-+]?((1[1-7]?[0-9]\.[0-9]{0,9}[1-9])|(1[1-7]?[0-9])|([1-9]?[0-9]\.[0-9]{0,9}[1-9])|([1-9]?[0-9])|(180))" error-message="от -180° до +180°"></paper-input>
                    <paper-input id="station_latitude" required label="Широта" pattern="[-+]?(([1-8]?[0-9]\.[0-9]{0,9}[1-9])|([1-8]?[0-9])|(90))" error-message="от −90° до +90°"></paper-input><!-- {1,9} -->

                    <div class="buttons">
                        <paper-button dialog-dismiss>Отмена</paper-button>
                        <paper-button autofocus id="btnAddStationDialog">Добавить</paper-button> <!-- dialog-confirm -->
                    </div>
                </paper-dialog>
            @endcan
        {{--@endif--}}
        @can('create', App\ViewNewSamples::class)
        <button id="btnAdd" class="gj-button-md">Добавить пробу</button>
        @endcan
        @can('update', App\ViewNewSamples::class)
        <button id="btnUndo" class="gj-button-md">Отменить</button>
        @endcan
        @can('create', App\ViewNewSamples::class)
        <button id="btnAddStation" class="gj-button-md">Добавить станцию</button>
        @endcan
        <br/><br/>
        <div class="table-responsive" id ="content">
            <table id="grid"></table>

        </div>





        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->


        {{--@if(Illuminate\Support\Facades\Auth::check())--}}

            @can('create', App\ViewNewSamples::class)
                <!-- Для диалога -->
                <!-- Для input -->
                <!--
                <link rel="import" href={{ URL::asset('components/iron-demo-helpers/demo-pages-shared-styles.html') }}>
                <link rel="import" href={{ URL::asset('components/iron-demo-helpers/demo-snippet.html') }}>
                -->
                <link rel="import" href={{ URL::asset('components/iron-icon/iron-icon.html') }}>
                <link rel="import" href={{ URL::asset('components/iron-icons/iron-icons.html') }}>
                <link rel="import" href={{ URL::asset('components/iron-input/iron-input.html') }}>
                <link rel="import" href={{ URL::asset('components/paper-icon-button/paper-icon-button.html') }}>
                <link rel="import" href={{ URL::asset('components/paper-styles/color.html') }}>
                <!-- присоединяются в paper-input.html
                <link rel="import" href={{ URL::asset('components/paper-input/paper-input-container.html') }}>
                <link rel="import" href={{ URL::asset('components/paper-input/paper-input-error.html') }}>
                присоединяются в paper-input.html -->
                <link rel="import" href={{ URL::asset('components/paper-input/paper-input.html') }}>
                <link rel="import" href={{ URL::asset('components/paper-input/paper-textarea.html') }}>
                <link rel="import" href={{ URL::asset('components/paper-input/demo/ssn-input.html') }}>
                <!-- Для input -->

                <!--<base href="http://polygit.org/components/">-->
                <script src="{{ URL::asset('components/webcomponentsjs/webcomponents-lite.js') }}"></script>

                <link rel="import" href="{{ URL::asset('components/polymer/polymer.html') }}">
                <link rel="import" href="{{ URL::asset('components/paper-dialog/paper-dialog.html') }}">
                <link rel="import" href="{{ URL::asset('components/paper-button/paper-button.html') }}">
                <link rel="import" href="{{ URL::asset('components/neon-animation/web-animations.html') }}">
                <link rel="import" href="{{ URL::asset('components/neon-animation/neon-animations.html') }}">
                <link rel="import" href="{{ URL::asset('components/paper-dropdown-menu/paper-dropdown-menu-light.html') }}">
                <link rel="import" href="{{ URL::asset('components/paper-listbox/paper-listbox.html') }}">
                <link rel="import" href="{{ URL::asset('components/paper-item/paper-item.html') }}">

                <link rel="import" href="{{ URL::asset('components/iron-demo-helpers/demo-snippet.html') }}">
                <link rel="import" href="{{ URL::asset('components/iron-demo-helpers/demo-pages-shared-styles.html') }}">
                <script type="text/javascript" src="{{ URL::asset('js/samplesPage/dialog/btnAddStation.js') }}"></script>
                <script type="text/javascript" src="{{ URL::asset('js/samplesPage/dialog/btnAddStationDialog.js') }}"></script>
                <script type="text/javascript" src="{{ URL::asset('js/samplesPage/dataForEditorFail.js') }}"></script>
                <script type="text/javascript" src="{{ URL::asset('js/samplesPage/splitString.js') }}"></script>
                <script type="text/javascript" src="{{ URL::asset('js/common/grid/dateToDBFormat.js') }}"></script>
                <script type="text/javascript" src="{{ URL::asset('js/common/grid/dataForEditor.js') }}"></script>
                <script type="text/javascript" src="{{ URL::asset('js/common/grid/deleteCBDataDataBound.js') }}"></script>
                <script type="text/javascript" src="{{ URL::asset('js/samplesPage/colorImage.js') }}"></script>
                <script type="text/javascript" src="{{ URL::asset('js/common/grid/dataBound.js') }}"></script>
                <script type="text/javascript" src="{{ URL::asset('js/common/grid/deleteCBData.js') }}"></script>
                <script type="text/javascript" src="{{ URL::asset('js/common/grid/checkFullStack.js') }}"></script>
                <script type="text/javascript" src="{{ URL::asset('js/samplesPage/checkForCBNull.js') }}"></script>
                <script type="text/javascript" src="{{ URL::asset('js/samplesPage/data/dataForUpdate.js') }}"></script>
                <script type="text/javascript" src="{{ URL::asset('js/samplesPage/data/dataForInsertAndDelete.js') }}"></script>
                <script type="text/javascript" src="{{ URL::asset('js/common/grid/pageSizeChange.js') }}"></script>
                <script type="text/javascript" src="{{ URL::asset('js/samplesPage/updateGrid.js') }}"></script>
                <script type="text/javascript" src="{{ URL::asset('js/common/grid/update.js') }}"></script>
                <script type="text/javascript" src="{{ URL::asset('js/common/grid/addRow.js') }}"></script>
                <script type="text/javascript" src="{{ URL::asset('js/common/grid/rowRemoving.js') }}"></script>
                {{--<script type="text/javascript" src="{{ URL::asset('js/samplesPage/checkDate.js') }}"></script>--}}
                <script type="text/javascript" src="{{ URL::asset('js/common/grid/cancelDeleteRow.js') }}"></script>
                <script type="text/javascript" src="{{ URL::asset('js/samplesPage/gridFTAll.js') }}"></script>
                <script type="text/javascript" src="{{ URL::asset('js/common/grid/btnUndo.js') }}"></script>
            @elsecan('update', App\ViewNewSamples::class)
                <script type="text/javascript" src="{{ URL::asset('js/samplesPage/dataForEditorFail.js') }}"></script>
                <script type="text/javascript" src="{{ URL::asset('js/samplesPage/splitString.js') }}"></script>
                <script type="text/javascript" src="{{ URL::asset('js/common/grid/dateToDBFormat.js') }}"></script>
                <script type="text/javascript" src="{{ URL::asset('js/common/grid/dataForEditor.js') }}"></script>
                <script type="text/javascript" src="{{ URL::asset('js/common/grid/deleteCBDataDataBound.js') }}"></script>
                <script type="text/javascript" src="{{ URL::asset('js/samplesPage/colorImage.js') }}"></script>
                <script type="text/javascript" src="{{ URL::asset('js/common/grid/dataBound.js') }}"></script>
                <script type="text/javascript" src="{{ URL::asset('js/common/grid/deleteCBData.js') }}"></script>
                <script type="text/javascript" src="{{ URL::asset('js/common/grid/checkFullStack.js') }}"></script>
                <script type="text/javascript" src="{{ URL::asset('js/samplesPage/checkForCBNull.js') }}"></script>
                <script type="text/javascript" src="{{ URL::asset('js/samplesPage/data/dataForUpdate.js') }}"></script>
                <script type="text/javascript" src="{{ URL::asset('js/samplesPage/updateGrid.js') }}"></script>
                <script type="text/javascript" src="{{ URL::asset('js/common/grid/update.js') }}"></script>
                {{--<script type="text/javascript" src="{{ URL::asset('js/samplesPage/checkDate.js') }}"></script>--}}
                <script type="text/javascript" src="{{ URL::asset('js/samplesPage/gridFTEdit.js') }}"></script>
                <script type="text/javascript" src="{{ URL::asset('js/common/grid/btnUndo.js') }}"></script>
            @elsecan('view', App\ViewNewSamples::class)
                <script type="text/javascript" src="{{ URL::asset('js/samplesPage/gridFTWatch.js') }}"></script>
            @endcan
        {{--@endif--}}