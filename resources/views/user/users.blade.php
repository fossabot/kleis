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

    <!-- Current Users -->
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-title pull-left">
                Administrateurs
            </div>
            <div class="panel-title pull-right">
                <div class="btn-toolbar pull-right" style="float: right;">
                    <form class="form-inline pull-right" role="form">
                        <input id="search-type" type="hidden" name="type" value="email">
                        <div class="btn-toolbar">
                            <div class="input-group">
                                <div class="search-box input-group-btn{{ session('results') ? '' : ' hidden' }}">
                                    <button id="search-option-button" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span id="search-option">Email</span>&nbsp;<span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li class="search-option{{ session('type') == 'email' ? ' option-selected' : '' }}" value="email"><a href="#">Email</a></li>
                                        <li class="search-option{{ session('type') == 'fullname' ? ' option-selected' : '' }}" value="fullname"><a href="#">Nom</a></li>
                                        <li class="search-option{{ session('type') == 'group' ? ' option-selected' : '' }}" value="group"><a href="#">D&eacute;l&eacute;gation</a></li>
                                    </ul>
                                </div>
                                <span class="search-box{{ session('results') ? '' : ' hidden' }}">
                                    <input id="search" class="form-control" name="search" value="{{ session('search') }}" placeholder="Jokers * et %">
                                </span>
                                <div id="search-button" class="search-button{{ session('results') ? ' input-group-btn' : '' }}">
                                    <a href="#" class="btn btn-default" role="button">
                                        <i class="fa fa-search"></i>
                                    </a>
                                </div>
                            </div>

                            <a href="{{ url('/user') }}" class="btn btn-default" style="float: right;">
                                <i class="fa fa-plus"></i> Ajouter un administrateur
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
                if ($(".option-selected").size()) {
                    $("#search-option").text($(".option-selected").text());
                    $("#search-type").val($(".option-selected").attr('value'));
                }
            });
        </script>

        <div class="panel-body">
            @if (count($users) > 0)
                <table class="table table table-hover admin-table">

                    <!-- Table Headings -->
                    <thead>
                        <th>Nom</th>
                        <th>Niveau</th>
                        <th>D&eacute;l&eacute;gation</th>
                        <th>Email</th>
                        <th>Actif</th>
                        <th>&nbsp;</th>
                    </thead>

                    <!-- Table Body -->
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <!-- User Name -->
                                <td class="table-text">
                                    <div>{{ $user->firstname }} {{ $user->lastname }}</div>
                                </td>
                                <td class="table-text">
                                    <div><div><i class="fa {{ $user->getLevel()['icon'] }}" title="{{ $user->getLevel()['text'] }}"></i></div></div>
                                </td>
                                <td class="table-text">
                                    <div>{{ $user->group ? $user->group->name : '&#9679;' }}</div>
                                </td>
                                <td class="table-text">
                                    <div>{{ $user->email }}</div>
                                </td>
                                <td class="table-text">
                                    <div><i class="fa {{ $user->getStatus()['icon'] }}" title="{{ $user->getStatus()['text'] }}"></i></div>
                                </td>
                                <td class="align-right col-xs-2">
                                    <div class="btn-toolbar">
                                        <div class="btn-group">
                                            <a href="/user/{{ $user->id }}" class="btn btn-default"><i class="fa fa-pencil"></i></a>
                                            @if($user->id == Auth::user()->id)
                                                <a href="#" class="btn btn-default disabled" disabled="true"><i class="fa fa-ban"></i></a>
                                            @elseif ($user->status == 1)
                                                <a href="/user/{{ $user->id }}/disable" class="btn btn-default"><i class="fa fa-ban"></i></a>
                                            @else
                                                <a href="/user/{{ $user->id }}/enable" class="btn btn-default"><i class="fa fa-check"></i></a>
                                            @endif
                                            @if ($user->status == 1 || $user->id == Auth::user()->id)
                                                <a href="#" class="btn btn-default disabled" disabled="true"><i class="fa fa-trash"></i></a>
                                            @else
                                                <a href="/user/{{ $user->id }}/delete" class="btn btn-default"><i class="fa fa-trash"></i></a>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                Aucun utilisateur.
            @endif
        </div>
    </div>

    <div class="text-center">
        {{ $users->links() }}
    </div>

{{ session()->forget(['results', 'search', 'type']) }}

@endsection
