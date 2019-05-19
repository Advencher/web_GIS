<br/>

            @can('create', App\ViewNewPhytos1::class)
            <paper-dialog id="dialog"  with-backdrop no-cancel-on-outside-click>
                <h2>Выбор глобальной пробы</h2>

                            <paper-input id="search" type="text" required label="Акватория, станция, или серийный номер пробы..."></paper-input>
                            <paper-button id="SubmitSearch" >Поиск</paper-button>
                            <paper-button id="btnClear" >Отчистить</paper-button>

                <paper-dialog-scrollable>
                    <div style= "width:600pt; height:200pt">
                    <table id="searchGrid"></table>
                    </div>
                </paper-dialog-scrollable>
                <div class="buttons">
                    <paper-button dialog-dismiss>Закрыть</paper-button>
                </div>

            </paper-dialog>
            @endcan

            <paper-dialog id="extraDialog" with-backdrop no-cancel-on-outside-click>
            <h2>Дополнительные данные</h2>
                <input id="id_phyto"  type="hidden" />
                <paper-dropdown-menu-light label="Сапробность" vertical-offset="60">
                    <paper-listbox class="dropdown-content" id="mydropdownSaprobity" slot="dropdown-content"  attr-for-selected="value" selected="1">

                    </paper-listbox>
                </paper-dropdown-menu-light>
                <paper-dropdown-menu-light label="Класс чистоты воды" vertical-offset="60">
                    <paper-listbox class="dropdown-content" id="mydropdownWaterPurity" slot="dropdown-content"  attr-for-selected="value" selected="1">
                    </paper-listbox>
                </paper-dropdown-menu-light>
                <paper-input id="station_longitude" required label="Долгота" readonly="true"></paper-input>
                <paper-input id="station_latitude" required label="Широта" readonly="true"></paper-input>
                <paper-input id="upholding_sample_time"  label="Выдержка пробы" pattern="^[0-9]+$" error-message="Только целые числа"></paper-input>
                <paper-input id="concentrated_sample_volume"  label="Концентрация" pattern="^[0-9]+$" error-message="Только целые числа"></paper-input>
                <paper-input id="cameras_viewed_number"  label="Сколько камер" pattern="^[0-9]+$" error-message="Только целые числа"></paper-input>

            <div class="buttons">
                <paper-button dialog-dismiss>Отмена</paper-button>
                @can('create | update', App\ViewNewPhytos1::class)
                <paper-button autofocus id="btnChangePhytoExtra">Изменить</paper-button>
                @endcan
            </div>
            </paper-dialog>

            <h2>Пробы фитопланктона</h2>
            @can('create', App\ViewNewPhytos1::class)
            <button id="btnAdd" class="gj-button-md">Добавить пробу фитопланктона</button>
            @endcan
            <button id="btnUndo" class="gj-button-md">Отменить</button>
            {{--<button id="btnAddStation" class="gj-button-md">Добавить пробу фитопланктона</button>--}}
            {{--<br/><br/>--}}
            <div class="table-responsive" id ="content">
                <table id="grid"></table>
            </div>

            <div id="myTabPhytoContent" class="tab-content">
                <div class="tab-pane fade active show" id="contentPhyto">
                    <br/>
                </div>
            </div>

<link rel="import" href={{ URL::asset('components/iron-icon/iron-icon.html') }}>
<link rel="import" href={{ URL::asset('components/iron-icons/iron-icons.html') }}>
<link rel="import" href={{ URL::asset('components/iron-input/iron-input.html') }}>
<link rel="import" href={{ URL::asset('components/paper-icon-button/paper-icon-button.html') }}>
<link rel="import" href={{ URL::asset('components/paper-styles/color.html') }}>
<link rel="import" href={{ URL::asset('components/paper-input/paper-input.html') }}>
<link rel="import" href={{ URL::asset('components/paper-input/paper-textarea.html') }}>
<link rel="import" href={{ URL::asset('components/paper-input/demo/ssn-input.html') }}>
<script src="{{ URL::asset('components/webcomponentsjs/webcomponents-lite.js') }}"></script>

<link rel="import" href="{{ URL::asset('components/paper-elements/paper-dialog-scrollable.html') }}">
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
<script type="text/javascript" src="{{ URL::asset('js/common/grid/colorImage.js') }}"></script>
<!-- Для диалога -->
@can('create', App\ViewNewPhytos1::class)
<!-- для грида из общей папки коммон -->
<script type="text/javascript" src="{{ URL::asset('js/common/grid/checkFullStack.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/common/grid/cancelDeleteRow.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/common/grid/dataBound.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/common/grid/update.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/common/grid/btnUndo.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/common/grid/deleteCBData.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/common/grid/rowRemoving.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/common/grid/pageSizeChange.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/common/grid/addRow.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/common/grid/deleteCBDataDataBound.js') }}"></script>

<!-- для грида из папки phytoPage1 -->
<script type="text/javascript" src="{{ URL::asset('js/phytoPage1/data/dataForInsertAndDelete.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/phytoPage1/data/dataForUpdate.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/phytoPage1/checkForCBNull.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/phytoPage1/addRowPhytoGlobal.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/phytoPage1/select2editorHorizon.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/phytoPage1/gridPhytoAll.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/phytoPage1/updateGrid.js') }}"></script>
<!-- для диалоговых окон-->
<script type="text/javascript" src="{{ URL::asset('js/phytoPage1/dialog/goToExtraDialog.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/phytoPage1/dialog/updateExtraDialog.js') }}"></script>

@elsecan ('update', App\ViewNewPhytos1::class)

    <script type="text/javascript" src="{{ URL::asset('js/common/grid/checkFullStack.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/common/grid/dataBound.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/common/grid/update.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/common/grid/btnUndo.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/common/grid/deleteCBData.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/common/grid/deleteCBDataDataBound.js') }}"></script>

    <script type="text/javascript" src="{{ URL::asset('js/phytoPage1/data/dataForUpdate.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/phytoPage1/select2editorHorizon.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/phytoPage1/checkForCBNull.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/phytoPage1/updateGrid.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/phytoPage1/gridPhytoEdit.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/phytoPage1/dialog/goToExtraDialog.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/phytoPage1/dialog/updateExtraDialog.js') }}"></script>

@elsecan ('view', App\ViewNewPhytos1::class)
    <script type="text/javascript" src="{{ URL::asset('js/phytoPage1/gridPhytoWatch.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/phytoPage1/dialog/goToExtraDialog.js') }}"></script>
@endcan



