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
            <form class="form-horizontal" role="form" method="POST" action="{{ url('/groups') }}">
                {{ csrf_field() }}
                <div class="col-lg-12">
                    <div class="input-group">
                        <input type="text" class="form-control" name="name" id="groupname" placeholder="@lang('groups.tooltip.group')">
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-default hidden" type="button" id="button-save">
                                <i class="fa fa-save"></i> @lang('groups.actions.save')
                            </button>
                            <a href="#" class="btn btn-default hidden" type="button" id="button-cancel">
                                <i class="fa fa-undo"></i> @lang('groups.actions.cancel')
                            </a>
                            <button type="submit" class="btn btn-default" type="button" id="button-add">
                                <i class="fa fa-plus"></i> @lang('groups.actions.add')
                            </button>
                        </span>
                    </div>
                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
                <input type="hidden" name="id" id="groupid" value="">
            </form>
        </div>
    </div>

    <!-- Current Groups -->
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-title pull-left">
                {{ trans_choice('groups.groups', 2) }}
            </div>
            <div class="panel-title pull-right">
                <form class="form-inline pull-right" role="form">
                    <div class="input-group">
                        <input id="search-type" type="hidden" name="type" value="group">
                        <span class="search-box{{ session('results') ? '' : ' hidden' }}">
                            <input id="search" class="form-control" name="search" value="{{ session('search') }}" placeholder="@lang('groups.tooltip.search')">
                        </span>
                        <div id="search-button" class="search-button{{ session('results') ? ' input-group-btn' : '' }}">
                            <a href="#" class="btn btn-default has-tooltip"
                                data-toggle="tooltip"
                                data-placement="bottom"
                                title="@lang('groups.actions.search')"
                                role="button">
                                <i class="fa fa-search"></i>
                            </a>
                        </div>
                    </div>
                </form>
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
            @if (count($groups) > 0)
                <table class="table table table-hover groups-table">

                    <!-- Table Headings -->
                    <thead>
                        <th>{{ trans_choice('groups.groups', 1) }}</th>
                        <th>@lang('groups.accounts.enabled')</th>
                        <th>@lang('groups.accounts.disabled')</th>
                        <th>@lang('groups.managers')</th>
                        <th>&nbsp;</th>
                    </thead>

                    <!-- Table Body -->
                    <tbody>
                        @foreach ($groups as $group)
                            <tr>
                                <td class="table-text col-xs-3">
                                    <div id="group{{ $group->id }}">{{ $group->name }}</div>
                                </td>
                                <td class="table-text">
                                    <div><span class="badge">{{ $group->countAccounts(1) }}</span></div>
                                </td>
                                <td class="table-text">
                                    <div><span class="badge">{{ $group->countAccounts(0) }}</span></div>
                                </td>
                                <td class="table-text">
                                    <div><span class="badge">{{ $group->countUsers() }}</span></div>
                                </td>
                                <td class="align-right col-xs-3">
                                    <div class="btn-toolbar">
                                        <div class="btn-group">
                                            <a href="#" class="btn btn-default has-tooltip edit-group"
                                                data-toggle="tooltip"
                                                data-placement="bottom"
                                                title="@lang('groups.actions.edit')"
                                                id="edit{{ $group->id }}"><i class="fa fa-pencil"></i></a>
                                            @if ($group->countAccounts() > 0)
                                            <a href="/group/{{ $group->id }}/accounts"
                                                class="btn btn-default has-tooltip"
                                                data-toggle="tooltip"
                                                data-placement="bottom"
                                                title="@lang('groups.actions.display')"><i class="fa fa-list-alt"></i></a>
                                            @else
                                                <a href="#" class="btn btn-default disabled" disabled="true"><i class="fa fa-list-alt"></i></a>
                                            @endif
                                            @if ($group->countAccounts(1) > 0)
                                                <a href="/group/{{ $group->id }}/disable"
                                                    class="btn btn-default has-tooltip"
                                                    data-toggle="tooltip"
                                                    data-placement="bottom"
                                                    title="@lang('groups.actions.disable')"><i class="fa fa-ban"></i></a>
                                            @else
                                                <a href="#" class="btn btn-default disabled" disabled="true"><i class="fa fa-ban"></i></a>
                                            @endif
                                            @if ($group->countAccounts(0) > 0)
                                                <a href="/group/{{ $group->id }}/purge"
                                                    class="btn btn-default has-tooltip"
                                                    data-toggle="tooltip"
                                                    data-placement="bottom"
                                                    title="@lang('groups.actions.drop')"><i class="fa fa-recycle"></i></a>
                                            @else
                                                <a href="#" class="btn btn-default disabled" disabled="true"><i class="fa fa-recycle"></i></a>
                                            @endif
                                            @if ($group->countAccounts() + $group->countUsers() > 0)
                                                <a href="#" class="btn btn-default disabled" disabled="true"><i class="fa fa-trash"></i></a>
                                            @else
                                                <a href="/group/{{ $group->id }}/delete"
                                                    class="btn btn-default has-tooltip"
                                                    data-toggle="tooltip"
                                                    data-placement="bottom"
                                                    title="@lang('groups.actions.delete')"><i class="fa fa-trash"></i></a>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                @lang('groups.message.empty').
            @endif
        </div>
    </div>

    <div class="text-center">
        {{ $groups->links() }}
    </div>

    <script type="text/javascript" language="javascript">
        document.addEventListener("DOMContentLoaded", function(event) {
            $('.edit-group').click(function () {
                var groupid = $(this).attr('id').substr(4);
                var groupname = document.getElementById( 'group' + groupid ).innerText;
                $('#groupid').val(groupid);
                $('#groupname').val(groupname);
                $('#button-cancel').removeClass('hidden');
                $('#button-save').removeClass('hidden');
                $('#button-add').addClass('hidden');
                $("#groupname").focus();
            });
            $('#button-cancel').click(function () {
                $('#groupid').val('');
                $('#groupname').val('');
                $('#button-cancel').addClass('hidden');
                $('#button-save').addClass('hidden');
                $('#button-add').removeClass('hidden');
            });
            $('.has-tooltip').tooltip();
        });
    </script>

{{ session()->forget(['results', 'search', 'type']) }}

@endsection
