@extends('layouts.admin')
@section('content')

<section>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body pt-3 pb-2">
                    <a href="{{ route("admin.sessions.index") }}">{{ trans('global.sessions') }}</a> / {{ $session->title }}
                    @can('session_edit')
                    <a class="btn btn-sm btn-info float-right ml-1" href="{{ route('admin.sessions.edit', $session->id) }}">{{ trans('global.edit') }}</a>
                    @endcan
                    <a href="#" onclick="window.history.back();" class="btn btn-sm btn-default float-right mb-2">{{ trans('global.back_to_list') }}</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">{{ trans('cruds.session.fields.title') }}</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{ $session->title }}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">{{ trans('cruds.session.fields.user') }}</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{ $session->user->name ?? '' }}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">{{ trans('cruds.session.fields.session_type') }}</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{ $session->session_type->name ?? '' }}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">{{ trans('cruds.session.fields.start_time') }}</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{ $session->start_time }}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">{{ trans('cruds.session.fields.duration') }}</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{ $session->duration }}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">{{ trans('cruds.session.fields.location') }}</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{ $session->location }}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">{{ trans('cruds.session.fields.status') }}</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{ App\Models\Session::STATUS_RADIO[$session->status] ?? '' }}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">{{ trans('cruds.session.fields.description') }}</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{!! $session->description !!}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">{{ trans('cruds.session.fields.private_notes') }}</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{ $session->private_notes }}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">{{ trans('cruds.session.fields.attachments') }}</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">
                            @foreach($session->attachments as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endforeach
                            </p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">{{ trans('cruds.session.fields.manager_score') }}</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{ $session->manager_score }}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">{{ trans('cruds.session.fields.development_area') }}</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{ $session->development_area->name ?? '' }}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">{{ trans('cruds.session.fields.experience_points') }}</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{ $session->experience_points }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="row">
                <div class="col">
                    <div class="card mb-0 mb-md-3">
                        <div class="card-header">
                            <h4 class="mb-0">{{ trans('cruds.session.fields.program') }}</h4>
                        </div>
                        <div class="card-body">
                            @if($program)
                            <a href="{{ route('admin.programs.show', $program->id) }}" class="btn btn-sm btn-outline-primary float-right">{{ trans('global.details') }}</a>
                            <p>{{ $program->name ?? '' }}</p>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">{{ trans('global.sessions') }}</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">{{ $program->sessions_count ?? '' }}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">{{ trans('global.candidates') }}</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">{{ $program->candidates_count ?? '' }}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">{{ trans('cruds.program.fields.user') }}</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">{{ $program->user->name ?? '' }}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">{{ trans('cruds.program.fields.company') }}</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">{{ $program->company->name ?? '' }}</p>
                                </div>
                            </div>
                            @else
                            <div class="alert alert-light" role="alert">{{ __('No relationship found') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="card mb-4 mb-md-0">
                        <div class="card-header">
                            <h4 class="mb-0">{{ trans('cruds.candidate.title') }}
                            @can('session_user_create')
                            <button type="button" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#addCandidates">{{ trans('cruds.sessionUser.add') }}</button>
                            @endcan
                            </h4>
                        </div>
                        <div class="card-body">

                            @if(!$sessionUsers->count() && $candidatesMissingCount==0)
                            <div class="alert alert-light col-12" role="alert">{{ __('No entries found') }}</div>
                            @else
                            <table class=" table table-bordered table-striped table-hover datatable datatable-session_users">
                                <thead>
                                    <tr>
                                        <th>{{ trans('global.name') }}</th>
                                        <th>{{ trans('cruds.sessionUser.fields.attendance') }}</th>
                                        <th>{{ trans('cruds.sessionUser.fields.score') }}</th>
                                        <th>
                                            &nbsp;
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sessionUsers as $key => $sessionUser)
                                        <tr data-entry-id="{{ $sessionUser->id }}">
                                            <th>{{ $sessionUser->user->full_name ?? '' }}</td>
                                            <td>
                                                <span style="display:none">{{ $sessionUser->attendance ?? '' }}</span>
                                                <input type="checkbox" disabled="disabled" {{ $sessionUser->attendance ? 'checked' : '' }}>
                                            </td>
                                            <td>
                                                {{ $sessionUser->score ?? '' }}
                                            </td>
                                            <td width="150">
                                            <form action="{{ route('admin.session-users.destroy', $sessionUser->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;" autocomplete="0">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                                <div class="btn-group" role="group" aria-label="Acciones">
                                                    @can('session_user_show')
                                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.session-users.show', $sessionUser->id) }}">{{ trans('global.view') }}</a>
                                                    @endcan
                                                    @can('session_user_edit')
                                                    <a class="btn btn-xs btn-info" href="{{ route('admin.session-users.edit', $sessionUser->id) }}">{{ trans('global.edit') }}</a>
                                                    @endcan
                                                    @can('session_user_delete')
                                                    <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}" {{ ($sessionUser->belongs_to_program) ? 'disabled' : '' }}>
                                                    @endcan
                                                </div>
                                            </form>
                                            </td>
                                        </tr>
                                    @endforeach

                                    @if ($program)
                                    @foreach($candidatesMissing as $key => $candidate)
                                        <tr data-entry-id="">
                                            <th>{{ $candidate->full_name ?? '' }}</td>
                                            <td>
                                                <input type="checkbox" disabled="disabled">
                                            </td>
                                            <td>

                                            </td>
                                            <td width="150">
                                                <div class="btn-group" role="group" aria-label="Acciones">
                                                    @can('session_user_show')
                                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.session-users.show-new', ['session'=>$session->id, 'user'=>$candidate->user_id]) }}">{{ trans('global.view') }}</a>
                                                    @endcan
                                                    @can('session_user_edit')
                                                    <a class="btn btn-xs btn-info" href="{{ route('admin.session-users.edit-new', ['session'=>$session->id, 'user'=>$candidate->user_id]) }}">{{ trans('global.edit') }}</a>
                                                    @endcan
                                                    @can('session_user_delete')
                                                    <button class="btn btn-xs btn-danger" disabled>{{ trans('global.delete') }}</button>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-0">
        <div class="col">
            <div class="card">
                <div class="card-body pt-3 pb-2">
                    @can('session_delete')
                    <form action="{{ route('admin.sessions.destroy', $session->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;" autocomplete="0">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="submit" class="btn btn-danger" value="{{ trans('global.delete') }}">
                    </form>
                    @endcan
                    @can('session_edit')
                    <a class="btn btn-info float-right ml-1" href="{{ route('admin.sessions.edit', $session->id) }}">{{ trans('global.edit') }}</a>
                    @endcan
                    <a href="#" onclick="window.history.back();" class="btn btn-default float-right mb-2">{{ trans('global.back_to_list') }}</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Add Candidates -->
<div class="modal fade" id="addCandidates" tabindex="-1" role="dialog" aria-labelledby="addCandidates" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <form method="POST" action="{{ route("admin.sessions.add-candidates") }}" enctype="multipart/form-data">
        <input type="hidden" name="session_id" value="{{ $session->id }}">
        @csrf
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">{{ trans('cruds.sessionUser.add') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div class="form-group">
                <label class="required" for="candidates">Candidato(s)</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">Borrar Selección</span>
                </div>
                <select class="form-control select2" name="candidates[]" id="candidates" multiple required>
                    @foreach($candidatesToAdd as $candidate)
                        <option value="{{ $candidate->user_id }}">{{ $candidate->full_name }}</option>
                    @endforeach
                </select>
                <span class="help-block">Seleccione los candidatos para agregar a la sesión.</span>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('global.cancel') }}</button>
        <button type="submit" class="btn btn-primary">{{ trans('global.save') }}</button>
      </div>
    </div>
    </form>
  </div>
</div>
@endsection
