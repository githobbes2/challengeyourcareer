@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.user.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                @can('user_edit')
                <a class="btn btn-info float-right ml-1" href="{{ route('admin.users.edit', $user->id) }}">{{ trans('global.edit') }}</a>
                @endcan
                <a href="#" onclick="window.history.back();" class="btn btn-default float-right mb-2">{{ trans('global.back_to_list') }}</a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th width="180">{{ trans('cruds.user.fields.company') }}</th>
                        <td>{{ $user->company->name ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.user.fields.name') }}</th>
                        <td>{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.user.fields.lastname') }}</th>
                        <td>{{ $user->lastname }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.user.fields.email') }}</th>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.user.fields.phone') }}</th>
                        <td>{{ $user->phone }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.user.fields.birthday') }}</th>
                        <td>{{ $user->birthday }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.user.fields.government_number') }}</th>
                        <td>{{ $user->government_number }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.user.fields.passport') }}</th>
                        <td>{{ $user->passport }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.user.fields.language') }}</th>
                        <td>
                            @foreach($user->languages as $key => $language)
                                <span class="badge badge-info">{{ $language->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.user.fields.enable_challenge_card') }}</th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $user->enable_challenge_card ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.user.fields.photo') }}</th>
                        <td>
                            @if($user->photo_defined)
                                <a href="{{ $user->photo->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $user->photo->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.user.fields.social_linkedin') }}</th>
                        <td>{{ $user->social_linkedin }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.user.fields.system_language') }}</th>
                        <td>{{ $user->system_language->name ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.user.fields.last_login') }}</th>
                        <td>{{ $user->last_login }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.user.fields.email_verified_at') }}</th>
                        <td>{{ $user->email_verified_at }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.user.fields.roles') }}</th>
                        <td>
                            @foreach($user->roles as $key => $roles)
                                <span class="badge badge-info">{{ $roles->title }}</span>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                @can('user_edit')
                <a class="btn btn-info float-right ml-1" href="{{ route('admin.users.edit', $user->id) }}">{{ trans('global.edit') }}</a>
                @endcan
                <a href="#" onclick="window.history.back();" class="btn btn-default float-right mb-2">{{ trans('global.back_to_list') }}</a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        {{ trans('global.relatedData') }}
    </div>
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link" href="#user_session_users" role="tab" data-toggle="tab">
                {{ trans('cruds.sessionUser.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#user_job_offers" role="tab" data-toggle="tab">
                {{ trans('cruds.jobOffer.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#user_programs" role="tab" data-toggle="tab">
                {{ trans('cruds.program.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#user_sessions" role="tab" data-toggle="tab">
                {{ trans('cruds.session.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#user_user_notes" role="tab" data-toggle="tab">
                {{ trans('cruds.userNote.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#user_user_alerts" role="tab" data-toggle="tab">
                {{ trans('cruds.userAlert.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="user_session_users">
            @includeIf('admin.users.relationships.userSessionUsers', ['sessionUsers' => $user->userSessionUsers])
        </div>
        <div class="tab-pane" role="tabpanel" id="user_job_offers">
            @includeIf('admin.users.relationships.userJobOffers', ['jobOffers' => $user->userJobOffers])
        </div>
        <div class="tab-pane" role="tabpanel" id="user_programs">
            @includeIf('admin.users.relationships.userPrograms', ['programs' => $user->userPrograms])
        </div>
        <div class="tab-pane" role="tabpanel" id="user_sessions">
            @includeIf('admin.users.relationships.userSessions', ['sessions' => $user->userSessions])
        </div>
        <div class="tab-pane" role="tabpanel" id="user_user_notes">
            @includeIf('admin.users.relationships.userUserNotes', ['userNotes' => $user->userUserNotes])
        </div>
        <div class="tab-pane" role="tabpanel" id="user_user_alerts">
            @includeIf('admin.users.relationships.userUserAlerts', ['userAlerts' => $user->userUserAlerts])
        </div>
    </div>
</div>

@endsection
