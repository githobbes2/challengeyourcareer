@extends('layouts.app-candidate')

@section('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />
<link href="{{ asset('css/rating-control.css') }}" rel="stylesheet">
<link href="{{ asset('css/select2.css') }}" rel="stylesheet">
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
<script src="{{ asset('js/main.js') }}"></script>
@endsection

@section('content')
<div class="section">
<div class="row">
    <div class="col-sm-6">
        <div class="card mb-1">
            <div class="card-body">
                <h3 class="mb-2 text-center">{{ $session->title }}</h3>
                <hr>
                <div class="row">
                    <div class="col-md-4"><p class="mb-0">{{ trans('cruds.session.fields.session_type') }}</p></div>
                    <div class="col-md-8"><p class="text-muted mb-0">{{ $session->session_type->name ?? '' }}</p></div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-4"><p class="mb-0">{{ trans('cruds.session.fields.status') }}</p></div>
                    <div class="col-md-8"><p class="text-muted mb-0">{{ App\Models\Session::STATUS_RADIO[$session->status] ?? '' }}</p></div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-4"><p class="mb-0">{{ trans('global.consultant') }}</p></div>
                    <div class="col-md-8"><p class="text-muted mb-0">{{ $session->user->name ?? '' }}</p></div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-4"><p class="mb-0">{{ trans('global.date') }}</p></div>
                    <div class="col-md-8"><p class="text-muted mb-0">{{ $session->start_time }} ({{ $session->duration . ' ' . trans('global.minutes_short') }})</p></div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-4"><p class="mb-0">{{ trans('cruds.session.fields.location') }}</p></div>
                    <div class="col-md-8"><p class="text-muted mb-0">{{ $session->location }}</p></div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-4"><p class="mb-0">{{ trans('cruds.session.fields.attachments') }}</p></div>
                    <div class="col-md-8"><p class="text-muted mb-0">
                        @foreach($session->attachments as $key => $media)
                            <a href="{{ $media->getUrl() }}" target="_blank">
                                {{ trans('global.view_file') }}
                            </a>
                        @endforeach
                    </p></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="card mb-1">
            <div class="card-body">
                <h3 class="mb-2 text-center">Mi Participación</h3>
                <hr>
                <div class="row">
                    <div class="col-4"><p class="mb-0">{{ trans('cruds.sessionUser.fields.attendance') }}</p></div>
                    <div class="col-8">
                        @if($sessionUser->attendance)
                        <ion-icon class="text-success h3 m-0" name="checkmark-outline"></ion-icon>
                        @else
                        <p class="text-muted mb-0"><em>- sin asistencia -</em></p>
                        @endif
                    </div>
                </div>
                <hr>
                <div class="row">
                    @if($sessionUser->score)
                    <div class="col-4">
                        <p class="mb-0">{{ trans('global.evaluation') }}</p>
                    </div>
                    <div class="col-8">
                        @if($sessionUser->score==5)
                        <label class="rating m-0" for="super-happy">
                            <input type="radio" name="score" class="super-happy" id="super-happy" value="5" disabled checked>
                            <svg class="m-0" viewBox="0 0 24 24"><path d="M12,17.5C14.33,17.5 16.3,16.04 17.11,14H6.89C7.69,16.04 9.67,17.5 12,17.5M8.5,11A1.5,1.5 0 0,0 10,9.5A1.5,1.5 0 0,0 8.5,8A1.5,1.5 0 0,0 7,9.5A1.5,1.5 0 0,0 8.5,11M15.5,11A1.5,1.5 0 0,0 17,9.5A1.5,1.5 0 0,0 15.5,8A1.5,1.5 0 0,0 14,9.5A1.5,1.5 0 0,0 15.5,11M12,20A8,8 0 0,1 4,12A8,8 0 0,1 12,4A8,8 0 0,1 20,12A8,8 0 0,1 12,20M12,2C6.47,2 2,6.5 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2Z" /></svg>
                        </label>
                        @elseif($sessionUser->score==4)
                        <label class="rating m-0" for="happy">
                            <input type="radio" name="score" class="happy" id="happy" value="4" disabled checked>
                            <svg class="m-0" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="100%" height="100%" viewBox="0 0 24 24"><path d="M20,12A8,8 0 0,0 12,4A8,8 0 0,0 4,12A8,8 0 0,0 12,20A8,8 0 0,0 20,12M22,12A10,10 0 0,1 12,22A10,10 0 0,1 2,12A10,10 0 0,1 12,2A10,10 0 0,1 22,12M10,9.5C10,10.3 9.3,11 8.5,11C7.7,11 7,10.3 7,9.5C7,8.7 7.7,8 8.5,8C9.3,8 10,8.7 10,9.5M17,9.5C17,10.3 16.3,11 15.5,11C14.7,11 14,10.3 14,9.5C14,8.7 14.7,8 15.5,8C16.3,8 17,8.7 17,9.5M12,17.23C10.25,17.23 8.71,16.5 7.81,15.42L9.23,14C9.68,14.72 10.75,15.23 12,15.23C13.25,15.23 14.32,14.72 14.77,14L16.19,15.42C15.29,16.5 13.75,17.23 12,17.23Z" /></svg>
                        </label>
                        @elseif($sessionUser->score==3)
                        <label class="rating m-0" for="neutral">
                            <input type="radio" name="score" class="neutral" id="neutral" value="3" disabled checked>
                            <svg class="m-0" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="100%" height="100%" viewBox="0 0 24 24"><path d="M8.5,11A1.5,1.5 0 0,1 7,9.5A1.5,1.5 0 0,1 8.5,8A1.5,1.5 0 0,1 10,9.5A1.5,1.5 0 0,1 8.5,11M15.5,11A1.5,1.5 0 0,1 14,9.5A1.5,1.5 0 0,1 15.5,8A1.5,1.5 0 0,1 17,9.5A1.5,1.5 0 0,1 15.5,11M12,20A8,8 0 0,0 20,12A8,8 0 0,0 12,4A8,8 0 0,0 4,12A8,8 0 0,0 12,20M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22C6.47,22 2,17.5 2,12A10,10 0 0,1 12,2M9,14H15A1,1 0 0,1 16,15A1,1 0 0,1 15,16H9A1,1 0 0,1 8,15A1,1 0 0,1 9,14Z" /></svg>
                        </label>
                        @elseif($sessionUser->score==2)
                        <label class="rating m-0" for="sad">
                            <input type="radio" name="score" class="sad" id="sad" value="2" disabled checked>
                            <svg class="m-0" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="100%" height="100%" viewBox="0 0 24 24"><path d="M20,12A8,8 0 0,0 12,4A8,8 0 0,0 4,12A8,8 0 0,0 12,20A8,8 0 0,0 20,12M22,12A10,10 0 0,1 12,22A10,10 0 0,1 2,12A10,10 0 0,1 12,2A10,10 0 0,1 22,12M15.5,8C16.3,8 17,8.7 17,9.5C17,10.3 16.3,11 15.5,11C14.7,11 14,10.3 14,9.5C14,8.7 14.7,8 15.5,8M10,9.5C10,10.3 9.3,11 8.5,11C7.7,11 7,10.3 7,9.5C7,8.7 7.7,8 8.5,8C9.3,8 10,8.7 10,9.5M12,14C13.75,14 15.29,14.72 16.19,15.81L14.77,17.23C14.32,16.5 13.25,16 12,16C10.75,16 9.68,16.5 9.23,17.23L7.81,15.81C8.71,14.72 10.25,14 12,14Z" /></svg>
                        </label>
                        @elseif($sessionUser->score==1)
                        <label class="rating m-0" for="super-sad">
                            <input type="radio" name="score" class="super-sad" id="super-sad" value="1" disabled checked>
                            <svg class="m-0" viewBox="0 0 24 24"><path d="M12,2C6.47,2 2,6.47 2,12C2,17.53 6.47,22 12,22A10,10 0 0,0 22,12C22,6.47 17.5,2 12,2M12,20A8,8 0 0,1 4,12A8,8 0 0,1 12,4A8,8 0 0,1 20,12A8,8 0 0,1 12,20M16.18,7.76L15.12,8.82L14.06,7.76L13,8.82L14.06,9.88L13,10.94L14.06,12L15.12,10.94L16.18,12L17.24,10.94L16.18,9.88L17.24,8.82L16.18,7.76M7.82,12L8.88,10.94L9.94,12L11,10.94L9.94,9.88L11,8.82L9.94,7.76L8.88,8.82L7.82,7.76L6.76,8.82L7.82,9.88L6.76,10.94L7.82,12M12,14C9.67,14 7.69,15.46 6.89,17.5H17.11C16.31,15.46 14.33,14 12,14Z" /></svg>
                        </label>
                        @endif
                    </div>
                    @else
                    <div class="col-12">
                        <p class="mb-0">{{ trans('global.evaluation') }}</p>
                        <p class="text-muted mb-0">{{ trans('candidate.session.evaluation_text') }}</p>
                    </div>
                    <div class="col-12">
                        <button type="button" class="btn btn-outline-primary btn-block mt-2 mb-1" data-toggle="modal" data-target="#ProvideScore">{{ trans('candidate.buttons.evaluate') }}</button>
                    </div>
                    @endif
                </div>
                <hr>
                @if($sessionUser->notes)
                <div class="row">
                    <div class="col-12"><p class="mb-0">
                        <button type="button" class="btn btn-sm btn-outline-primary mt-1 float-right" data-toggle="modal" data-target="#EditNote">{{ trans('global.edit') }}</button>
                        {{ trans('candidate.session.notes') }}
                    </p></div>
                    <div class="col-12"><p class="text-muted mb-0"><em>{!! nl2br($sessionUser->notes) !!}</em></p></div>
                </div>
                @else
                <div class="row">
                <div class="col-12">
                    <button type="button" class="btn btn-outline-primary btn-block ms-1" data-toggle="modal" data-target="#EditNote">{{ trans('candidate.buttons.add_note') }}</button>
                </div>
                </div>
                @endif
            </div>
        </div>

        <div class="card mb-1">
            <div class="card-body">
                <h3 class="mb-2 text-center">Mis Compromisos
                <button type="button" class="btn btn-sm btn-outline-primary float-right ms-1" data-toggle="modal" data-target="#addCommitment">{{ trans('global.add') }}</button>
                </h3>
                <hr>
                @forelse($sessionUser->sessionUserCandidateCommitments as $key => $commitment)
                <div class="row">
                    <div class="col">
                        <h5 class="card-title">{{ $commitment->title }}</h5>
                        @foreach($commitment->tags as $key => $tag)
                        <span class="badge badge-info">{{ $tag->name }}</span>
                        @endforeach
                        <p class="text-muted mb-0 mt-1">
                        @if($commitment->complete)
                        <ion-icon name="checkbox-outline"></ion-icon> Completada<br>
                        @else
                        <ion-icon name="square-outline"></ion-icon> Sin Completar<br>
                        @endif

                        @if($commitment->completion_date)
                        <ion-icon name="calendar-outline"></ion-icon> {{ $commitment->completion_date }}<br>
                        @endif

                        @can('candidate_commitment_show')
                        <a class="btn btn-xs btn-outline-primary float-right" href="{{ route('admin.candidate.commitment.show', $commitment) }}">{{ trans('global.details') }}</a>
                        @endcan
                        </p>
                    </div>
                </div>
                <hr>
                @empty
                <div class="alert alert-light col-12" role="alert">{{ __('No commitments have been defined') }}</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
</div>

<!-- Evaluate Session -->
<div class="modal fade modalbox" id="ProvideScore" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ trans('global.evaluation') }}</h5>
                <a href="javascript:;" data-dismiss="modal">{{ trans('global.cancel') }}</a>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.candidate.session.evaluate', [$sessionUser->id]) }}" method="POST">
                    @csrf
                    <div class="card card-default">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <h4>{{ $session->title }}</h4>
                                    <p class="text-muted mb-0">{{ trans('candidate.session.evaluation_text') }}</p>
                                </div>
                                <div class="col-lg-12 form-group">

                                    <label class="rating" for="super-happy">
                                        <input type="radio" name="score" class="super-happy" id="super-happy" value="5" required>
                                        <svg viewBox="0 0 24 24"><path d="M12,17.5C14.33,17.5 16.3,16.04 17.11,14H6.89C7.69,16.04 9.67,17.5 12,17.5M8.5,11A1.5,1.5 0 0,0 10,9.5A1.5,1.5 0 0,0 8.5,8A1.5,1.5 0 0,0 7,9.5A1.5,1.5 0 0,0 8.5,11M15.5,11A1.5,1.5 0 0,0 17,9.5A1.5,1.5 0 0,0 15.5,8A1.5,1.5 0 0,0 14,9.5A1.5,1.5 0 0,0 15.5,11M12,20A8,8 0 0,1 4,12A8,8 0 0,1 12,4A8,8 0 0,1 20,12A8,8 0 0,1 12,20M12,2C6.47,2 2,6.5 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2Z" /></svg>
                                    </label>

                                    <label class="rating" for="happy">
                                        <input type="radio" name="score" class="happy" id="happy" value="4" required>
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="100%" height="100%" viewBox="0 0 24 24"><path d="M20,12A8,8 0 0,0 12,4A8,8 0 0,0 4,12A8,8 0 0,0 12,20A8,8 0 0,0 20,12M22,12A10,10 0 0,1 12,22A10,10 0 0,1 2,12A10,10 0 0,1 12,2A10,10 0 0,1 22,12M10,9.5C10,10.3 9.3,11 8.5,11C7.7,11 7,10.3 7,9.5C7,8.7 7.7,8 8.5,8C9.3,8 10,8.7 10,9.5M17,9.5C17,10.3 16.3,11 15.5,11C14.7,11 14,10.3 14,9.5C14,8.7 14.7,8 15.5,8C16.3,8 17,8.7 17,9.5M12,17.23C10.25,17.23 8.71,16.5 7.81,15.42L9.23,14C9.68,14.72 10.75,15.23 12,15.23C13.25,15.23 14.32,14.72 14.77,14L16.19,15.42C15.29,16.5 13.75,17.23 12,17.23Z" /></svg>
                                    </label>

                                    <label class="rating" for="neutral">
                                        <input type="radio" name="score" class="neutral" id="neutral" value="3" required>
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="100%" height="100%" viewBox="0 0 24 24"><path d="M8.5,11A1.5,1.5 0 0,1 7,9.5A1.5,1.5 0 0,1 8.5,8A1.5,1.5 0 0,1 10,9.5A1.5,1.5 0 0,1 8.5,11M15.5,11A1.5,1.5 0 0,1 14,9.5A1.5,1.5 0 0,1 15.5,8A1.5,1.5 0 0,1 17,9.5A1.5,1.5 0 0,1 15.5,11M12,20A8,8 0 0,0 20,12A8,8 0 0,0 12,4A8,8 0 0,0 4,12A8,8 0 0,0 12,20M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22C6.47,22 2,17.5 2,12A10,10 0 0,1 12,2M9,14H15A1,1 0 0,1 16,15A1,1 0 0,1 15,16H9A1,1 0 0,1 8,15A1,1 0 0,1 9,14Z" /></svg>
                                    </label>

                                    <label class="rating" for="sad">
                                        <input type="radio" name="score" class="sad" id="sad" value="2" required>
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="100%" height="100%" viewBox="0 0 24 24"><path d="M20,12A8,8 0 0,0 12,4A8,8 0 0,0 4,12A8,8 0 0,0 12,20A8,8 0 0,0 20,12M22,12A10,10 0 0,1 12,22A10,10 0 0,1 2,12A10,10 0 0,1 12,2A10,10 0 0,1 22,12M15.5,8C16.3,8 17,8.7 17,9.5C17,10.3 16.3,11 15.5,11C14.7,11 14,10.3 14,9.5C14,8.7 14.7,8 15.5,8M10,9.5C10,10.3 9.3,11 8.5,11C7.7,11 7,10.3 7,9.5C7,8.7 7.7,8 8.5,8C9.3,8 10,8.7 10,9.5M12,14C13.75,14 15.29,14.72 16.19,15.81L14.77,17.23C14.32,16.5 13.25,16 12,16C10.75,16 9.68,16.5 9.23,17.23L7.81,15.81C8.71,14.72 10.25,14 12,14Z" /></svg>
                                    </label>

                                    <label class="rating" for="super-sad">
                                        <input type="radio" name="score" class="super-sad" id="super-sad" value="1" required>
                                        <svg viewBox="0 0 24 24"><path d="M12,2C6.47,2 2,6.47 2,12C2,17.53 6.47,22 12,22A10,10 0 0,0 22,12C22,6.47 17.5,2 12,2M12,20A8,8 0 0,1 4,12A8,8 0 0,1 12,4A8,8 0 0,1 20,12A8,8 0 0,1 12,20M16.18,7.76L15.12,8.82L14.06,7.76L13,8.82L14.06,9.88L13,10.94L14.06,12L15.12,10.94L16.18,12L17.24,10.94L16.18,9.88L17.24,8.82L16.18,7.76M7.82,12L8.88,10.94L9.94,12L11,10.94L9.94,9.88L11,8.82L9.94,7.76L8.88,8.82L7.82,7.76L6.76,8.82L7.82,9.88L6.76,10.94L7.82,12M12,14C9.67,14 7.69,15.46 6.89,17.5H17.11C16.31,15.46 14.33,14 12,14Z" /></svg>
                                    </label>

                                </div>
                                <div class="col-lg-12 form-group">
                                    <label for="content" class="control-label required">{{ trans('global.feedback') }}</label>
                                    <textarea name="score_feedback" class="form-control" rows="4">{{ old('notes', $sessionUser->score_feedback) }}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary float-right ml-2" type="submit">{{ trans('global.save') }}</button>
                                <a href="javascript:;" data-dismiss="modal" class="btn btn-default float-right">{{ trans('global.cancel') }}</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- * Evaluate Session -->

<!-- Add/Edit Notes -->
<div class="modal fade modalbox" id="EditNote" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ trans('candidate.session.notes') }}</h5>
                <a href="javascript:;" data-dismiss="modal">{{ trans('global.cancel') }}</a>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.candidate.session.update', [$sessionUser->id]) }}" method="POST">
                    @csrf
                    <div class="card card-default">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <h4>{{ $session->title }}</h4>
                                </div>
                                <div class="col-lg-12 form-group">
                                    <label for="content" class="control-label required">{{ trans('global.note') }}</label>
                                    <textarea name="notes" class="form-control" rows="8">{{ old('notes', $sessionUser->notes) }}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary float-right ml-2" type="submit">{{ trans('global.save') }}</button>
                                <a href="javascript:;" data-dismiss="modal" class="btn btn-default float-right">{{ trans('global.cancel') }}</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- * Add/Edit Notes -->

<!-- Add Commitment -->
<div class="modal fade modalbox" id="addCommitment" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nuevo Compromiso</h5>
                <a href="javascript:;" data-dismiss="modal">{{ trans('global.cancel') }}</a>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route("admin.candidate-commitments.store") }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="session_user_id" value="{{ $sessionUser->id }}">
                    <div class="card card-default">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <h4>{{ $session->title }}</h4>
                                </div>

                                <div class="form-group">
                                    <label class="required" for="title">{{ trans('cruds.candidateCommitment.fields.title') }}</label>
                                    <input class="form-control" type="text" name="title" id="title" value="{{ old('title', '') }}" required>
                                    <span class="help-block">{{ trans('cruds.candidateCommitment.fields.title_helper') }}</span>
                                </div>
                                <div class="form-group">
                                    <div class="form-check">
                                        <input type="hidden" name="complete" value="0">
                                        <input class="form-check-input" type="checkbox" name="complete" id="complete" value="1" {{ old('complete', 0) == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="complete">{{ trans('cruds.candidateCommitment.fields.complete') }}</label>
                                    </div>
                                    <span class="help-block">{{ trans('cruds.candidateCommitment.fields.complete_helper') }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="completion_date">{{ trans('cruds.candidateCommitment.fields.completion_date') }}</label>
                                    <input class="form-control date" type="text" name="completion_date" id="completion_date" value="{{ old('completion_date') }}">
                                    <span class="help-block">{{ trans('cruds.candidateCommitment.fields.completion_date_helper') }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="tags">{{ trans('cruds.candidateCommitment.fields.tag') }}</label>
                                    <div style="padding-bottom: 4px">
                                        <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                                    </div>
                                    <select class="form-control select2" name="tags[]" id="tags" multiple>
                                        @foreach($tags as $id => $tag)
                                            <option value="{{ $id }}" {{ in_array($id, old('tags', [])) ? 'selected' : '' }}>{{ $tag }}</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block">{{ trans('cruds.candidateCommitment.fields.tag_helper') }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="note">{{ trans('cruds.candidateCommitment.fields.note') }}</label>
                                    <textarea class="form-control" name="note" id="note">{{ old('note') }}</textarea>
                                    <span class="help-block">{{ trans('cruds.candidateCommitment.fields.note_helper') }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="comments">{{ trans('cruds.candidateCommitment.fields.comments') }}</label>
                                    <textarea class="form-control" name="comments" id="comments">{{ old('comments') }}</textarea>
                                    <span class="help-block">{{ trans('cruds.candidateCommitment.fields.comments_helper') }}</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary float-right ml-2" type="submit">{{ trans('global.save') }}</button>
                                <a href="javascript:;" data-dismiss="modal" class="btn btn-default float-right">{{ trans('global.cancel') }}</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- * Add Commitment -->
@endsection
