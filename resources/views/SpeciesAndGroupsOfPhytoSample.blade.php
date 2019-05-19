<br/>

<input type="hidden" id="IDphyto" value = "{{$id_phyto}}">
@can('create', App\ViewNewPhytos1::class)
<paper-dialog id="addSpecieDialog" with-backdrop no-cancel-on-outside-click>
    <h2>Добавление вида фитопланктона</h2>
    <paper-dropdown-menu-light label="Выберете группу фитопланктона" vertical-offset="60">
        <paper-listbox class="dropdown-content" id="mydropdownGroup" slot="dropdown-content"  attr-for-selected="value" selected="1">

        </paper-listbox>
    </paper-dropdown-menu-light>
    <paper-input id="nameSpecie" required label="Введите имя нового вида" pattern="^[а-яА-ЯёЁa-zA-Z0-9 #.-]+$" error-message="Недопустимые символы"></paper-input>
    <div class="buttons">
        <paper-button dialog-dismiss>Отмена</paper-button>
        <paper-button autofocus id="btnAddNewSpecie">Добавить</paper-button> <!-- dialog-confirm -->
    </div>
</paper-dialog>
@endcan

<h2>Виды фитопланктона в пробе</h2>
@can('create', App\ViewNewPhytos1::class)
<button id="btnAddSpecieSample" class="gj-button-md">Добавить вид фитопланктона в пробу</button>
<button id="btnAddSpecie" class="gj-button-md">Добавить вид фитоплактона</button>
@endcan

<button id="btnUndoSpecieSample" class="gj-button-md">Отменить</button>

<br/><br/>

<div class="table-responsive" id ="content">
    <table id="gridFT1"></table>
</div>

<h2></h2>

<h2>Группы фитопланктона в пробе</h2>
@can('create', App\ViewNewPhytos1::class)
<button id="btnAddGroup" class="gj-button-md">Добавить группу фитопланктона в пробу</button>
@endcan

<button id="btnUndoGroup" class="gj-button-md">Отменить</button>

<div class="table-responsive" id ="content">
    <table id="gridSD"></table>
</div>


<!-- Для видов фитоплантктона -->


<!-- Для групп фитоплантктона -->
<script type="text/javascript" src="{{ URL::asset('js/common/grid/colorImage.js') }}"></script>
<!-- common-->
@can('create', App\ViewNewPhytos1::class)
<script type="text/javascript" src="{{ URL::asset('js/common/grid/deleteCBData.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/page2Phyto/warkSpecie/dataBoundSpecie.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/page2Phyto/warkGroup/dataBoundGroup.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/common/grid/checkFullStack.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/common/grid/deleteCBDataDataBound.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/common/grid/pageSizeChange.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/page2Phyto/dataGp/dataForUpdate.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/page2Phyto/dataGp/dataForInsertAndDelete.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/page2Phyto/select2editorGroups.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/page2Phyto/warkGroup/addRowPhytoGroup.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/page2Phyto/warkGroup/updateGroup.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/page2Phyto/warkGroup/rowRemovingGroup.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/page2Phyto/warkGroup/btnUndoGroup.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/page2Phyto/warkGroup/checkForCBNullGroup.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/page2Phyto/warkGroup/cancelDeleteRowGroup.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/page2Phyto/dataSp/dataForUpdate.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/page2Phyto/dataSp/dataForInsertAndDelete.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/page2Phyto/warkSpecie/addRowPhytoSpecie.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/page2Phyto/warkSpecie/updateSpecie.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/page2Phyto/warkSpecie/rowRemovingSpecie.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/page2Phyto/warkSpecie/btnUndoSpecie.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/page2Phyto/warkSpecie/checkForCBNullSpecie.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/page2Phyto/warkSpecie/cancelDeleteRowSpecie.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/page2Phyto/warkSpecie/addRowPhytoSpecie.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/page2Phyto/select2editorSpecies.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/page2Phyto/dialog/goToAddSpecie.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/page2Phyto/dialog/insertNewSpecie.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/page2Phyto/updateGridSpecie.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/page2Phyto/gridPhytoSpGp.js') }}"></script>
@elsecan ('update', App\ViewNewPhytos1::class)
    <script type="text/javascript" src="{{ URL::asset('js/common/grid/deleteCBData.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/page2Phyto/warkSpecie/dataBoundSpecie.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/page2Phyto/warkGroup/dataBoundGroup.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/common/grid/checkFullStack.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/common/grid/deleteCBDataDataBound.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/page2Phyto/dataGp/dataForUpdate.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/page2Phyto/select2editorGroups.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/page2Phyto/warkGroup/updateGroup.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/page2Phyto/warkGroup/btnUndoGroup.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/page2Phyto/warkGroup/checkForCBNullGroup.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/page2Phyto/dataSp/dataForUpdate.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/page2Phyto/warkSpecie/updateSpecie.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/page2Phyto/warkSpecie/btnUndoSpecie.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/page2Phyto/warkSpecie/checkForCBNullSpecie.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/page2Phyto/select2editorSpecies.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/page2Phyto/updateGridSpecie.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/page2Phyto/gridPhytoSpGpEdit.js') }}"></script>
@elsecan ('view', App\ViewNewPhytos1::class)
    <script type="text/javascript" src="{{ URL::asset('js/page2Phyto/gridPhytoSpGpWatch.js') }}"></script>
@endcan