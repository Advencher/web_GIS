@extends('layouts.onePhyto')

@can('create', App\Admin::class)
@section('navbar')
    <a class="nav-link" href="../admin" role="button" >Панель администрирования
        <span class="sr-only">(current)</span>
    </a>
@endsection
@endcan

@section('content')
<br/>


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

<h2 id="globalID">Данные фитопланктона в пробе с глобальным ID - </h2>

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
@endsection

@section('script')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
    <script type="text/javascript" src="{{ URL::asset('js/onePhytoPage/data/dataForInsertAndDelete.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/onePhytoPage/data/dataForUpdate.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/onePhytoPage/checkForCBNull.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/onePhytoPage/addRowPhytoGlobal.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/onePhytoPage/select2editorHorizon.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/onePhytoPage/gridPhytoAll.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/onePhytoPage/updateGrid.js') }}"></script>
    <!-- для диалоговых окон-->
    <script type="text/javascript" src="{{ URL::asset('js/onePhytoPage/dialog/goToExtraDialog.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/onePhytoPage/dialog/updateExtraDialog.js') }}"></script>

@elsecan ('update', App\ViewNewPhytos1::class)

    <script type="text/javascript" src="{{ URL::asset('js/common/grid/checkFullStack.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/common/grid/dataBound.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/common/grid/update.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/common/grid/btnUndo.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/common/grid/deleteCBData.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/common/grid/deleteCBDataDataBound.js') }}"></script>

    <script type="text/javascript" src="{{ URL::asset('js/onePhytoPage/data/dataForUpdate.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/onePhytoPage/select2editorHorizon.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/onePhytoPage/checkForCBNull.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/onePhytoPage/updateGrid.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/onePhytoPage/gridPhytoEdit.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/onePhytoPage/dialog/goToExtraDialog.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/onePhytoPage/dialog/updateExtraDialog.js') }}"></script>

@elsecan ('view', App\ViewNewPhytos1::class)
    <script type="text/javascript" src="{{ URL::asset('js/onePhytoPage/gridPhytoWatch.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/onePhytoPage/dialog/goToExtraDialog.js') }}"></script>
@endcan
@endsection