        @can('create', App\ViewNewSamples::class)
        <!--<button id="btnAdd" class="gj-button-md">Добавить пробу</button>-->
		<?php if(isset($_POST['sid'])) echo '<button id="btnAdd" class="gj-button-md">Добавить пигмент</button>';?>
        @endcan
        @can('update', App\ViewNewSamples::class)
        <button id="btnUndo" class="gj-button-md">Отменить</button>
        @endcan
        <br/><br/>
        <div class="table-responsive" id ="content">
            <table id="grid"></table>
        </div>




		<?php
		if(isset($_POST['sid'])) echo '<script>var pigment_sid='.$_POST['sid'].'</script>';
		?>
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
                <script type="text/javascript" src="{{ URL::asset('js/pigmentsPage/dataForEditorFail.js') }}"></script>
                <script type="text/javascript" src="{{ URL::asset('js/pigmentsPage/splitString.js') }}"></script>
                <script type="text/javascript" src="{{ URL::asset('js/common/grid/dateToDBFormat.js') }}"></script>
                <script type="text/javascript" src="{{ URL::asset('js/common/grid/dataForEditor.js') }}"></script>
                <script type="text/javascript" src="{{ URL::asset('js/common/grid/deleteCBDataDataBound.js') }}"></script>
                <script type="text/javascript" src="{{ URL::asset('js/common/grid/dataBound.js') }}"></script>
                <script type="text/javascript" src="{{ URL::asset('js/common/grid/deleteCBData.js') }}"></script>
                <script type="text/javascript" src="{{ URL::asset('js/common/grid/checkFullStack.js') }}"></script>
                <script type="text/javascript" src="{{ URL::asset('js/pigmentsPage/checkForCBNull.js') }}"></script>
                <script type="text/javascript" src="{{ URL::asset('js/pigmentsPage/data/dataForUpdate.js') }}"></script>
                <script type="text/javascript" src="{{ URL::asset('js/pigmentsPage/data/dataForInsertAndDelete.js') }}"></script>
                <script type="text/javascript" src="{{ URL::asset('js/common/grid/pageSizeChange.js') }}"></script>
                <script type="text/javascript" src="{{ URL::asset('js/pigmentsPage/updateGrid.js') }}"></script>
                <script type="text/javascript" src="{{ URL::asset('js/common/grid/update.js') }}"></script>
                <script type="text/javascript" src="{{ URL::asset('js/common/grid/addRow.js') }}"></script>
                <script type="text/javascript" src="{{ URL::asset('js/common/grid/rowRemoving.js') }}"></script>
                {{--<script type="text/javascript" src="{{ URL::asset('js/pigmentsPage/checkDate.js') }}"></script>--}}
                <script type="text/javascript" src="{{ URL::asset('js/common/grid/cancelDeleteRow.js') }}"></script>
                <script type="text/javascript" src="{{ URL::asset('js/pigmentsPage/gridFTAll.js') }}"></script>
                <script type="text/javascript" src="{{ URL::asset('js/common/grid/btnUndo.js') }}"></script>
            @elsecan('update', App\ViewNewSamples::class)
                <script type="text/javascript" src="{{ URL::asset('js/pigmentsPage/dataForEditorFail.js') }}"></script>
                <script type="text/javascript" src="{{ URL::asset('js/pigmentsPage/splitString.js') }}"></script>
                <script type="text/javascript" src="{{ URL::asset('js/common/grid/dateToDBFormat.js') }}"></script>
                <script type="text/javascript" src="{{ URL::asset('js/common/grid/dataForEditor.js') }}"></script>
                <script type="text/javascript" src="{{ URL::asset('js/common/grid/deleteCBDataDataBound.js') }}"></script>
                <script type="text/javascript" src="{{ URL::asset('js/common/grid/dataBound.js') }}"></script>
                <script type="text/javascript" src="{{ URL::asset('js/common/grid/deleteCBData.js') }}"></script>
                <script type="text/javascript" src="{{ URL::asset('js/common/grid/checkFullStack.js') }}"></script>
                <script type="text/javascript" src="{{ URL::asset('js/pigmentsPage/checkForCBNull.js') }}"></script>
                <script type="text/javascript" src="{{ URL::asset('js/pigmentsPage/data/dataForUpdate.js') }}"></script>
                <script type="text/javascript" src="{{ URL::asset('js/pigmentsPage/updateGrid.js') }}"></script>
                <script type="text/javascript" src="{{ URL::asset('js/common/grid/update.js') }}"></script>
                {{--<script type="text/javascript" src="{{ URL::asset('js/pigmentsPage/checkDate.js') }}"></script>--}}
                <script type="text/javascript" src="{{ URL::asset('js/pigmentsPage/gridFTEdit.js') }}"></script>
                <script type="text/javascript" src="{{ URL::asset('js/common/grid/btnUndo.js') }}"></script>
            @elsecan('view', App\ViewNewSamples::class)
                <script type="text/javascript" src="{{ URL::asset('js/pigmentsPage/gridFTWatch.js') }}"></script>
            @endcan
        {{--@endif--}}