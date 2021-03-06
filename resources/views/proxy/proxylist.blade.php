@extends('layouts.app')

@section('content')

@if (session('status') || session('results'))
    <div class="alert alert-success alert-dismissable">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        {{ session('status') }}{{ session('results') }}
    </div>
    <script type="text/javascript" language="javascript">
        document.addEventListener("DOMContentLoaded", function(event) {
            $(".alert-dismissable").fadeTo(2000, 500).slideUp(500, function(){
                $(".alert-dismissable").alert('close');
            });
        });
    </script>
@endif

    <!-- Add/Edit Group -->
    <div class="panel panel-default">
        <div class="panel-body">
            <form class="form-horizontal" role="form" method="POST" action="/whitelist/{{ $type }}">
                {{ csrf_field() }}
                <div class="col-lg-12">
                    <div class="input-group">
                        <input type="text" class="form-control" name="value"
                            id="itemname"
                            placeholder="@lang('proxylist.tooltip.' . $type)">
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-default hidden" type="button" id="button-save">
                                <i class="fa fa-save"></i> @lang('proxylist.actions.save')
                            </button>
                            <a href="#" class="btn btn-default hidden" type="button" id="button-cancel">
                                <i class="fa fa-undo"></i> @lang('proxylist.actions.cancel')
                            </a>
                            <button type="submit" class="btn btn-default" type="button" id="button-add">
                                <i class="fa fa-plus"></i> @lang('proxylist.actions.add')
                            </button>
                        </span>
                    </div>
                    @if ($errors->has('value'))
                        <span class="help-block">
                            <strong>{{ $errors->first('value') }}</strong>
                        </span>
                    @endif
                </div>
                <input type="hidden" name="id" id="itemid" value="">
            </form>
        </div>
    </div>

    <!-- Current Groups -->
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-title pull-left">
                {{ trans('proxylist.in-whitelist', ['type' => trans_choice('proxylist.'.$type, 2)]) }}
            </div>
            <div class="panel-title pull-right">
                <div class="btn-toolbar pull-right" style="float: right;">
                    <form class="form-inline pull-right" role="form">
                        <div class="btn-toolbar">
                            <div class="input-group">
                                <span class="search-box{{ session('results') ? '' : ' hidden' }}">
                                    <input id="search" class="form-control" name="search" value="{{ session('search') }}" placeholder="@lang('proxylist.tooltip.search')">
                                </span>
                                <div id="search-button" class="search-button{{ session('results') ? ' input-group-btn' : '' }}">
                                    <a href="#"
                                        class="btn btn-default has-tooltip"
                                        data-toggle="tooltip"
                                        data-placement="bottom"
                                        title="@lang('proxylist.actions.search')"
                                        role="button">
                                        <i class="fa fa-search"></i>
                                    </a>
                                </div>
                            </div>

                            <a href="{{ Request::url() }}/clear" class="btn btn-default" style="float: right;">
                                <i class="fa fa-recycle"></i> @lang('proxylist.actions.drop')
                            </a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <script type="text/javascript" language="javascript">
            document.addEventListener("DOMContentLoaded", function() {
                $("#search-button").click(function() {
                    if ($(this).hasClass('input-group-btn')) {
                        $(this).parents('form:first').submit();
                    } else {
                        $(this).addClass('input-group-btn');
                        $(".search-box").removeClass('hidden');
                        $("#search").focus();
                    }
                });
                $(".search-option").click(function() {
                    $("#search-option").text($(this).text());
                    $("#search-type").val($(this).attr('value'));
                });
            });
        </script>

        <div class="panel-body">
            @if (count($items) > 0)
                <table class="table table table-hover items-table">

                    <!-- Table Headings -->
                    <thead>
                        <th>{{ trans_choice('proxylist.'.$type, 1) }}</th>
                        <th>&nbsp;</th>
                    </thead>

                    <!-- Table Body -->
                    <tbody>
                        @foreach ($items as $item)
                            <tr>
                                <td class="table-text">
                                    <div id="item{{ $item->id }}">{{ $item->value }}</div>
                                </td>
                                <td class="align-right col-xs-2">
                                    <div class="btn-toolbar">
                                        <div class="btn-group">
                                            <a href="#"
                                                class="btn btn-default edit-link has-tooltip"
                                                data-toggle="tooltip"
                                                data-placement="bottom"
                                                title="@lang('proxylist.actions.edit')"
                                                id="edit{{ $item->id }}"><i class="fa fa-pencil"></i></a>
                                            <a href="/whitelist/{{ $type }}/{{ $item->id }}/delete"
                                                class="btn btn-default has-tooltip"
                                                data-toggle="tooltip"
                                                data-placement="bottom"
                                                title="@lang('proxylist.actions.delete')"><i class="fa fa-trash"></i></a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                @lang('proxylist.message.empty.'.$type).
            @endif
        </div>
    </div>

    <div class="text-center">
        {{ $items->links() }}
    </div>

    <script type="text/javascript" language="javascript">
        document.addEventListener("DOMContentLoaded", function(event) {
            $('.edit-link').click(function () {
                var itemid = $(this).attr('id').substr(4);
                var itemname = document.getElementById( 'item' + itemid ).innerText;
                $('#itemid').val(itemid);
                $('#itemname').val(itemname);
                $('#button-cancel').removeClass('hidden');
                $('#button-save').removeClass('hidden');
                $('#button-add').addClass('hidden');
                $("#itemname").focus();
            });
            $('#button-cancel').click(function () {
                $('#itemid').val('');
                $('#itemname').val('');
                $('#button-cancel').addClass('hidden');
                $('#button-save').addClass('hidden');
                $('#button-add').removeClass('hidden');
            });
            $('.has-tooltip').tooltip();
        });
    </script>

{{ session()->forget(['results', 'search', 'type']) }}

@endsection
