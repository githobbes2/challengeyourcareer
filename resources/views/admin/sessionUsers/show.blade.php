@extends('layouts.admin')

@section('scripts')
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
@endsection

@section('styles')
<link href="{{ asset('css/rating-control.css') }}" rel="stylesheet">
@endsection

@section('content')
<section>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body pt-3 pb-2">
                    <a href="{{ route("admin.sessions.index") }}">{{ trans('global.sessions') }}</a> / Detalle de Sesión para un Candidato
                    @can('session_user_edit')
                    <a class="btn btn-sm btn-info float-right ml-1" href="{{ route('admin.session-users.edit', $sessionUser->id) }}">{{ trans('global.edit') }}</a>
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
                            <p class="mb-0">{{ trans('cruds.sessionUser.fields.user') }}</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{ $sessionUser->user->full_name ?? '' }}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">{{ trans('cruds.sessionUser.fields.session') }}</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{ $sessionUser->session->title ?? '' }}</p>
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
                            <p class="mb-0">{{ trans('cruds.sessionUser.fields.attendance') }}</p>
                        </div>
                        <div class="col-sm-9">
                            @if($sessionUser->attendance)
                            <ion-icon class="text-success h3" name="checkmark-outline"></ion-icon>
                            @else
                            <p class="text-muted mb-0 small"><em>- sin asistencia -</em></p>
                            @endif
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">{{ trans('cruds.sessionUser.fields.score') }}</p>
                        </div>
                        <div class="col-sm-9">
                        @if($sessionUser->score)
                            @if($sessionUser->score==5)
                            <label class="rating m-0" for="super-happy">
                                <svg class="small super-happy m-0" viewBox="0 0 24 24"><path d="M12,17.5C14.33,17.5 16.3,16.04 17.11,14H6.89C7.69,16.04 9.67,17.5 12,17.5M8.5,11A1.5,1.5 0 0,0 10,9.5A1.5,1.5 0 0,0 8.5,8A1.5,1.5 0 0,0 7,9.5A1.5,1.5 0 0,0 8.5,11M15.5,11A1.5,1.5 0 0,0 17,9.5A1.5,1.5 0 0,0 15.5,8A1.5,1.5 0 0,0 14,9.5A1.5,1.5 0 0,0 15.5,11M12,20A8,8 0 0,1 4,12A8,8 0 0,1 12,4A8,8 0 0,1 20,12A8,8 0 0,1 12,20M12,2C6.47,2 2,6.5 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2Z" /></svg>
                            </label>
                            @elseif($sessionUser->score==4)
                            <label class="rating m-0" for="happy">
                                <svg class="small happy m-0" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="100%" height="100%" viewBox="0 0 24 24"><path d="M20,12A8,8 0 0,0 12,4A8,8 0 0,0 4,12A8,8 0 0,0 12,20A8,8 0 0,0 20,12M22,12A10,10 0 0,1 12,22A10,10 0 0,1 2,12A10,10 0 0,1 12,2A10,10 0 0,1 22,12M10,9.5C10,10.3 9.3,11 8.5,11C7.7,11 7,10.3 7,9.5C7,8.7 7.7,8 8.5,8C9.3,8 10,8.7 10,9.5M17,9.5C17,10.3 16.3,11 15.5,11C14.7,11 14,10.3 14,9.5C14,8.7 14.7,8 15.5,8C16.3,8 17,8.7 17,9.5M12,17.23C10.25,17.23 8.71,16.5 7.81,15.42L9.23,14C9.68,14.72 10.75,15.23 12,15.23C13.25,15.23 14.32,14.72 14.77,14L16.19,15.42C15.29,16.5 13.75,17.23 12,17.23Z" /></svg>
                            </label>
                            @elseif($sessionUser->score==3)
                            <label class="rating m-0" for="neutral">
                                <svg class="small neutral m-0" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="100%" height="100%" viewBox="0 0 24 24"><path d="M8.5,11A1.5,1.5 0 0,1 7,9.5A1.5,1.5 0 0,1 8.5,8A1.5,1.5 0 0,1 10,9.5A1.5,1.5 0 0,1 8.5,11M15.5,11A1.5,1.5 0 0,1 14,9.5A1.5,1.5 0 0,1 15.5,8A1.5,1.5 0 0,1 17,9.5A1.5,1.5 0 0,1 15.5,11M12,20A8,8 0 0,0 20,12A8,8 0 0,0 12,4A8,8 0 0,0 4,12A8,8 0 0,0 12,20M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22C6.47,22 2,17.5 2,12A10,10 0 0,1 12,2M9,14H15A1,1 0 0,1 16,15A1,1 0 0,1 15,16H9A1,1 0 0,1 8,15A1,1 0 0,1 9,14Z" /></svg>
                            </label>
                            @elseif($sessionUser->score==2)
                            <label class="rating m-0" for="sad">
                                <svg class="small sad m-0" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="100%" height="100%" viewBox="0 0 24 24"><path d="M20,12A8,8 0 0,0 12,4A8,8 0 0,0 4,12A8,8 0 0,0 12,20A8,8 0 0,0 20,12M22,12A10,10 0 0,1 12,22A10,10 0 0,1 2,12A10,10 0 0,1 12,2A10,10 0 0,1 22,12M15.5,8C16.3,8 17,8.7 17,9.5C17,10.3 16.3,11 15.5,11C14.7,11 14,10.3 14,9.5C14,8.7 14.7,8 15.5,8M10,9.5C10,10.3 9.3,11 8.5,11C7.7,11 7,10.3 7,9.5C7,8.7 7.7,8 8.5,8C9.3,8 10,8.7 10,9.5M12,14C13.75,14 15.29,14.72 16.19,15.81L14.77,17.23C14.32,16.5 13.25,16 12,16C10.75,16 9.68,16.5 9.23,17.23L7.81,15.81C8.71,14.72 10.25,14 12,14Z" /></svg>
                            </label>
                            @elseif($sessionUser->score==1)
                            <label class="rating m-0" for="super-sad">
                                <svg class="small super-sad m-0" viewBox="0 0 24 24"><path d="M12,2C6.47,2 2,6.47 2,12C2,17.53 6.47,22 12,22A10,10 0 0,0 22,12C22,6.47 17.5,2 12,2M12,20A8,8 0 0,1 4,12A8,8 0 0,1 12,4A8,8 0 0,1 20,12A8,8 0 0,1 12,20M16.18,7.76L15.12,8.82L14.06,7.76L13,8.82L14.06,9.88L13,10.94L14.06,12L15.12,10.94L16.18,12L17.24,10.94L16.18,9.88L17.24,8.82L16.18,7.76M7.82,12L8.88,10.94L9.94,12L11,10.94L9.94,9.88L11,8.82L9.94,7.76L8.88,8.82L7.82,7.76L6.76,8.82L7.82,9.88L6.76,10.94L7.82,12M12,14C9.67,14 7.69,15.46 6.89,17.5H17.11C16.31,15.46 14.33,14 12,14Z" /></svg>
                            </label>
                            @endif
                        @else
                        <p class="text-muted mb-0 small"><em>- sin evaluación -</em></p>
                        @endif
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">{{ trans('cruds.sessionUser.fields.notes') }}</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0"><em>{!! nl2br($sessionUser->notes) !!}</em></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="card mb-1">
                <div class="card-body">
                    <h3 class="mb-2">Compromisos</h3>
                    <hr>
                    @forelse($sessionUser->sessionUserCandidateCommitments as $key => $commitment)
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title">{{ $commitment->title }}</h5>
                            @foreach($commitment->tags as $key => $tag)
                            <span class="badge badge-info">{{ $tag->name }}</span>
                            @endforeach
                            <p class="text-muted mb-0 mt-2">
                            @if($commitment->complete)
                            <ion-icon name="checkbox-outline"></ion-icon> Completada<br>
                            @else
                            <ion-icon name="square-outline"></ion-icon> Sin Completar<br>
                            @endif

                            @if($commitment->completion_date)
                            <ion-icon name="calendar-outline"></ion-icon> {{ $commitment->completion_date }}<br>
                            @endif

                            @can('candidate_commitment_show')
                            <a class="btn btn-sm btn-outline-primary float-right" href="{{ route('admin.candidate-commitments.show', $commitment) }}">{{ trans('global.details') }}</a>
                            @endcan
                            </p>
                        </div>
                    </div>
                    <hr>
                    @empty
                    <div class="alert alert-light col-12" role="alert">{{ __('No entries found') }}</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-0">
        <div class="col">
            <div class="card">
                <div class="card-body pt-3 pb-2">
                    @can('session_user_delete')
                    <form action="{{ route('admin.session-users.destroy', $sessionUser->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;" autocomplete="0">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="submit" class="btn btn-danger" value="{{ trans('global.delete') }}" {{ ($sessionUser->belongs_to_program) ? 'disabled' : '' }}>
                    </form>
                    @endcan
                    @can('session_user_edit')
                    <a class="btn btn-info float-right ml-1" href="{{ route('admin.session-users.edit', $sessionUser->id) }}">{{ trans('global.edit') }}</a>
                    @endcan
                    <a href="#" onclick="window.history.back();" class="btn btn-default float-right mb-2">{{ trans('global.back_to_list') }}</a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
