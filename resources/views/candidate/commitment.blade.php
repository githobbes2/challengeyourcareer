@extends('layouts.app-candidate')

@section('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />
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
                <h3 class="mb-2">{{ $candidateCommitment->title }}</h3>
                @if ($candidateCommitment->session_user)
                <hr>
                <div class="row">
                    <div class="col-md-4"><p class="mb-0">{{ trans('cruds.candidateCommitment.fields.session_user') }}</p></div>
                    <div class="col-md-8"><p class="text-muted mb-0">{{ $candidateCommitment->session_user->session->title ?? '' }}</p></div>
                </div>
                @endif
                <hr>
                <div class="row">
                    <div class="col-md-4"><p class="mb-0">{{ trans('global.completion') }}</p></div>
                    <div class="col-md-8">
                    @if($candidateCommitment->complete)
                        <ion-icon class="text-success h3 m-0" name="checkmark-outline"></ion-icon>
                        @else
                        <p class="text-muted mb-0"><em>- sin cumplir -</em></p>
                        @endif
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-4"><p class="mb-0">{{ trans('cruds.candidateCommitment.fields.completion_date') }}</p></div>
                    <div class="col-md-8"><p class="text-muted mb-0">{{ $candidateCommitment->completion_date }}</p></div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-4"><p class="mb-0">{{ trans('cruds.candidateCommitment.candidate_fields.development_area') }}</p></div>
                    <div class="col-md-8"><p class="text-muted mb-0">{{ $candidateCommitment->development_area->name }}</p></div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-4"><p class="mb-0">{{ trans('cruds.candidateCommitment.fields.tag') }}</p></div>
                    <div class="col-md-8">
                        @foreach($candidateCommitment->tags as $key => $tag)
                            <span class="badge badge-info">{{ $tag->name }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="card mb-1">
            <div class="card-body">
                <div class="row">
                    <div class="col-12"><p class="mb-0">{{ trans('cruds.candidateCommitment.fields.note') }}</p></div>
                    <div class="col-12">
                        {{ $candidateCommitment->note }}
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-12"><p class="mb-0">{{ trans('cruds.candidateCommitment.fields.comments') }}</p></div>
                    <div class="col-12">
                        {{ $candidateCommitment->comments }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-6 text-center">
        @can('candidate_commitment_delete')
        <form action="{{ route('admin.candidate-commitments.destroy', $candidateCommitment->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" autocomplete="0">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <button type="submit" class="btn btn-danger btn-block mt-1 mb-1">{{ trans('global.delete') }}</button>
        </form>
        @endcan
    </div>
    <div class="col-6 text-center">
        <button type="button" class="btn btn-outline-primary btn-block mt-1 mb-1" data-toggle="modal" data-target="#EditRecord">{{ trans('global.edit') }}</button>
    </div>
</div>
</div>

<!-- Add/Edit Notes -->
<div class="modal fade modalbox" id="EditRecord" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Compromiso</h5>
                <a href="javascript:;" data-dismiss="modal">{{ trans('global.cancel') }}</a>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route("admin.candidate-commitments.update", [$candidateCommitment->id]) }}" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="card card-default">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="required" for="title">{{ trans('cruds.candidateCommitment.fields.title') }}</label>
                                        <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', $candidateCommitment->title) }}" required>
                                        @if($errors->has('title'))
                                            <span class="text-danger">{{ $errors->first('title') }}</span>
                                        @endif
                                        <span class="help-block">{{ trans('cruds.candidateCommitment.fields.title_helper') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="session_user_id">{{ trans('cruds.candidateCommitment.fields.session_user') }}</label>
                                        <select class="form-control select2 {{ $errors->has('session_user') ? 'is-invalid' : '' }}" name="session_user_id" id="session_user_id">
                                            @foreach($session_users as $id => $entry)
                                                <option value="{{ $id }}" {{ (old('session_user_id') ? old('session_user_id') : $candidateCommitment->session_user->session_id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('session_user'))
                                            <span class="text-danger">{{ $errors->first('session_user') }}</span>
                                        @endif
                                        <span class="help-block">{{ trans('cruds.candidateCommitment.fields.session_user_helper') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="completion_date">{{ trans('cruds.candidateCommitment.fields.completion_date') }}</label>
                                        <input class="form-control date {{ $errors->has('completion_date') ? 'is-invalid' : '' }}" type="text" name="completion_date" id="completion_date" value="{{ old('completion_date', $candidateCommitment->completion_date) }}">
                                        @if($errors->has('completion_date'))
                                            <span class="text-danger">{{ $errors->first('completion_date') }}</span>
                                        @endif
                                        <span class="help-block">{{ trans('cruds.candidateCommitment.fields.completion_date_helper') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group pt-md-4">
                                        <div class="form-check pt-md-1 {{ $errors->has('complete') ? 'is-invalid' : '' }}">
                                            <input type="hidden" name="complete" value="0">
                                            <input class="form-check-input" type="checkbox" name="complete" id="complete" value="1" {{ $candidateCommitment->complete || old('complete', 0) === 1 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="complete">{{ trans('cruds.candidateCommitment.fields.complete') }}</label>
                                        </div>
                                        @if($errors->has('complete'))
                                            <span class="text-danger">{{ $errors->first('complete') }}</span>
                                        @endif
                                        <span class="help-block">{{ trans('cruds.candidateCommitment.fields.complete_helper') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="required no-margin-bottom">{{ trans('cruds.candidateCommitment.candidate_fields.development_area') }}</label><br>
                                        <span class="help-block">{{ trans('cruds.candidateCommitment.candidate_fields.development_area_helper') }}</span>
                                        <div class="row display-flex pt-1">
                                        @foreach($development_areas as $area)
                                            <div class="col-sm-4 mb-1">
                                                <div class="cards-1">
                                                <label class="no-margin-bottom" style="min-height:130px">
                                                <div class="row">
                                                    <div class="col-1 col-sm-2 text-center">
                                                        <input id="development_area_id" value="{{ $area->id }}" type="radio" name="development_area_id" {{ old('development_area_id', (string) $candidateCommitment->development_area_id) === (string) $area->id ? 'checked' : '' }} required>
                                                    </div>
                                                    <div class="col-11 col-sm-10">
                                                        <h3 class="no-maring-top">{{ $area->name }}</h3>
                                                        <p class="small no-margin-bottom">{{ $area->description ?? ' ' }}</p>
                                                    </div>
                                                </div>
                                                </label>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="note">{{ trans('cruds.candidateCommitment.fields.note') }}</label>
                                        <textarea class="form-control {{ $errors->has('note') ? 'is-invalid' : '' }}" name="note" id="note">{{ old('note', $candidateCommitment->note) }}</textarea>
                                        @if($errors->has('note'))
                                            <span class="text-danger">{{ $errors->first('note') }}</span>
                                        @endif
                                        <span class="help-block">{{ trans('cruds.candidateCommitment.fields.note_helper') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="comments">{{ trans('cruds.candidateCommitment.fields.comments') }}</label>
                                        <textarea class="form-control {{ $errors->has('comments') ? 'is-invalid' : '' }}" name="comments" id="comments">{{ old('comments', $candidateCommitment->comments) }}</textarea>
                                        @if($errors->has('comments'))
                                            <span class="text-danger">{{ $errors->first('comments') }}</span>
                                        @endif
                                        <span class="help-block">{{ trans('cruds.candidateCommitment.fields.comments_helper') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="tags">{{ trans('cruds.candidateCommitment.fields.tag') }}</label>
                                        <div style="padding-bottom: 4px">
                                            <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                                            <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                                        </div>
                                        <select class="form-control select2 {{ $errors->has('tags') ? 'is-invalid' : '' }}" name="tags[]" id="tags" multiple>
                                            @foreach($tags as $id => $tag)
                                                <option value="{{ $id }}" {{ (in_array($id, old('tags', [])) || $candidateCommitment->tags->contains($id)) ? 'selected' : '' }}>{{ $tag }}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('tags'))
                                            <span class="text-danger">{{ $errors->first('tags') }}</span>
                                        @endif
                                        <span class="help-block">{{ trans('cruds.candidateCommitment.fields.tag_helper') }}</span>
                                    </div>
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
@endsection
