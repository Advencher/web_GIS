@extends('layouts.papa')

@section('content')
    <div style="margin-left: 300px; margin-right: 300px">
            <br/>
            <button id="btnUndo" class="gj-button-md">Отменить</button>
            <br/><br/>
            <div class="table-responsive" id ="content">
                <table id="grid"></table>
            </div>
    </div>
@endsection

@section('navbar')
    <a class="nav-link" href="/" role="button" >На главную
        <span class="sr-only">(current)</span>
    </a>
@endsection

@section('script')
{{--@if(Illuminate\Support\Facades\Auth::check())--}}

    @can('create', App\Admin::class)
        <script type="text/javascript" src="{{ URL::asset('js/adminPage/dataForEditorFail.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('js/common/grid/dataForEditor.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('js/common/grid/deleteCBDataDataBound.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('js/common/grid/colorImage.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('js/common/grid/dataBound.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('js/common/grid/deleteCBData.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('js/common/grid/checkFullStack.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('js/adminPage/checkForCBNull.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('js/adminPage/data/dataForUpdate.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('js/adminPage/data/dataForInsertAndDelete.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('js/common/grid/update.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('js/adminPage/rowRemoving.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('js/adminPage/grid.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('js/common/grid/btnUndo.js') }}"></script>
    @endcan
@endsection
{{--@endif--}}
