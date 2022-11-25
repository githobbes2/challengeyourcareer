@extends('layouts.app-candidate')

@section('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />
<link href="{{ asset('css/rating-control.css') }}" rel="stylesheet">
<link href="{{ asset('css/select2.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="section">
<div class="row">
    <div class="col-sm-6">
        <div class="card mb-1">
            <div class="card-body text-center">
                <img src="{{ $candidate->user->photo_default->preview }}" class="rounded-circle img-fluid" style="width: 150px;">
                <h2 class="my-1">{{ $candidate->full_name }}</h2>

                <p class="text-muted mt-2 mb-3">
                    {{ $candidate->company->name ?? '' }}<br>
                    {{ $candidate->user->email ?? '' }}<br>
                    {{ trans('cruds.user.fields.last_login') }}: {{ $candidate->user->last_login ?? trans('cruds.user.fields.last_login_null') }}
                </p>

                @if($program->program_type)
                @if($program->program_type->outplacement)
                <p class="text-muted mb-4">
                    @if($candidate->employability_score)
                    {{ trans('cruds.candidate.fields.employability_score') }}: {{ $candidate->employability_score }} <span class="small">({{ $candidate->employability_score_date }})</span>
                    @else
                    <em>{{ trans('cruds.candidate.fields.no_employability_score') }}</em>
                    @endif
                </p>
                @endif
                @endif
                <div class="d-flex justify-content-center mb-2">
                    <button type="button" class="btn btn-outline-primary ms-1" data-toggle="modal" data-target="#editProfile">{{ trans('candidate.buttons.edit_profile') }}</button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="card mb-1">
            <div class="card-body">
                <h3 class="mb-2 text-center">{{ trans('candidate.profile.program') }}</h3>
                <hr>
                <div class="row">
                    <div class="col-md-4"><p class="mb-0">{{ trans('cruds.candidateProgram.fields.program') }}</p></div>
                    <div class="col-md-8"><p class="text-muted mb-0">{{ $program->name ?? '' }}</p></div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-4"><p class="mb-0">{{ trans('cruds.candidateProgram.fields.status') }}</p></div>
                    <div class="col-md-8"><p class="text-muted mb-0">{{ App\Models\CandidateProgram::STATUS_RADIO[$candidateProgram->status] ?? '' }}</p></div>
                </div>
                <hr>
                @if($program->program_type)
                <div class="row">
                    <div class="col-md-4"><p class="mb-0">{{ trans('cruds.program.fields.program_type') }}</p></div>
                    <div class="col-md-8"><p class="text-muted mb-0">{{ $program->program_type->name ?? '' }}</p></div>
                </div>
                <hr>
                @endif
                <div class="row">
                    <div class="col-md-4"><p class="mb-0">{{ trans('global.session_count') }}</p></div>
                    <div class="col-md-8"><p class="text-muted mb-0">{{ $program->sessions_count ?? '' }}</p></div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-4"><p class="mb-0">{{ trans('global.consultant_in_charge') }}</p></div>
                    <div class="col-md-8"><p class="text-muted mb-0">{{ $program->user->name ?? '' }}</p></div>
                </div>
                <hr>
                @if($candidateProgram->program_start_date)
                <div class="row">
                    <div class="col-md-4"><p class="mb-0">{{ trans('candidate.profile.program_dates') }}</p></div>
                    <div class="col-md-8"><p class="text-muted mb-0">
                        @if($candidateProgram->program_end_date)
                        {{ trans('global.from_date') . ' ' . $candidateProgram->program_start_date . ' ' . trans('global.to_date') . ' ' . $candidateProgram->program_end_date }}
                        @else
                        {{ trans('candidate.profile.start_date') . ' ' . $candidateProgram->program_start_date }}
                        @endif
                    </p></div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="card mb-1 mb-lg-0">
            <div class="card-body">
                <h3 class="mb-2 text-center">{{ trans('cruds.candidate.cards.personal') }}</h3>
                <hr>
                <div class="row">
                    <div class="col-md-3"><p class="mb-0">{{ trans('cruds.candidate.fields.gender') }}</p></div>
                    <div class="col-md-9"><p class="text-muted mb-0">{{ $candidate->gender->name ?? '' }}</p></div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-3"><p class="mb-0">{{ trans('cruds.user.fields.birthday') }}</p></div>
                    <div class="col-md-9"><p class="text-muted mb-0">{{ $candidate->user->birthday }}</p></div>
                </div>
                <hr>
                <p class="text-muted mb-0"><input type="checkbox" disabled="disabled" {{ $candidate->disability ? 'checked' : '' }}> {{ trans('cruds.candidate.fields.disability') }}</p>
                <p class="text-muted mb-0"><input type="checkbox" disabled="disabled" {{ $candidate->immigrant ? 'checked' : '' }}> {{ trans('cruds.candidate.fields.immigrant') }}</p>
                <hr>
                <div class="row">
                    <div class="col-md-3"><p class="mb-0">{{ trans('cruds.user.fields.phone') }}</p></div>
                    <div class="col-md-9"><p class="text-muted mb-0">{{ $candidate->user->phone }}</p></div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-3"><p class="mb-0">{{ trans('cruds.candidate.fields.city') }}</p></div>
                    <div class="col-md-9"><p class="text-muted mb-0">{{ $candidate->city->name ?? '' }}</p></div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-3"><p class="mb-0">{{ trans('cruds.candidate.fields.address') }}</p></div>
                    <div class="col-md-9"><p class="text-muted mb-0">{{ $candidate->address }}</p></div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-3"><p class="mb-0">{{ trans('cruds.candidate.fields.postalcode') }}</p></div>
                    <div class="col-md-9"><p class="text-muted mb-0">{{ $candidate->postalcode }}</p></div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-3"><p class="mb-0">{{ trans('cruds.user.fields.government_number') }}</p></div>
                    <div class="col-md-9"><p class="text-muted mb-0">{{ $candidate->user->government_number }}</p></div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-3"><p class="mb-0">{{ trans('cruds.user.fields.passport') }}</p></div>
                    <div class="col-md-9"><p class="text-muted mb-0">{{ $candidate->user->passport }}</p></div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-3"><p class="mb-0">{{ trans('cruds.user.fields.language') }}</p></div>
                    <div class="col-md-9">
                        @foreach($candidate->user->languages as $key => $language)
                        <span class="badge badge-info">{{ $language->name }}</span>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="col-sm-6">

        <div class="card mb-1 mb-lg-0">
            <div class="card-body">
                <h3 class="mb-2 text-center">{{ trans('cruds.candidate.cards.professional') }}</h3>
                <hr>
                <div class="row">
                    <div class="col-md-3">
                        <p class="mb-0">{{ trans('cruds.candidate.fields.profile') }}</p>
                    </div>
                    <div class="col-md-9">
                        <p class="text-muted mb-0">{!! $candidate->profile !!}</p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-3">
                        <p class="mb-0">{{ trans('cruds.candidate.fields.position') }}</p>
                    </div>
                    <div class="col-md-9">
                        <p class="text-muted mb-0">{{ $candidate->position }}</p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-3">
                        <p class="mb-0">{{ trans('cruds.candidate.fields.related_company') }}</p>
                    </div>
                    <div class="col-md-9">
                        @foreach($candidate->related_companies as $key => $related_company)
                        <span class="badge badge-info">{{ $related_company->name }}</span>
                        @endforeach
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-3">
                        <p class="mb-0">{{ trans('cruds.user.fields.social_linkedin') }}</p>
                    </div>
                    <div class="col-md-9">
                        <p class="text-muted mb-0">{{ $candidate->user->social_linkedin }}</p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-3">
                        <p class="mb-0">{{ trans('cruds.candidate.fields.education_level') }}</p>
                    </div>
                    <div class="col-md-9">
                        <p class="text-muted mb-0">{{ $candidate->education_level->name ?? '' }}</p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-3">
                        <p class="mb-0">{{ trans('cruds.candidate.fields.professional_level') }}</p>
                    </div>
                    <div class="col-md-9">
                        <p class="text-muted mb-0">{{ $candidate->professional_level->name ?? '' }}</p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-3">
                        <p class="mb-0">{{ trans('cruds.candidate.fields.functional_area') }}</p>
                    </div>
                    <div class="col-md-9">
                        <p class="text-muted mb-0">{{ $candidate->functional_area->name ?? '' }}</p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-3">
                        <p class="mb-0">{{ trans('cruds.candidate.fields.skill') }}</p>
                    </div>
                    <div class="col-md-9">
                        @foreach($candidate->skills as $key => $skill)
                        <span class="badge badge-info">{{ $skill->name }}</span>
                        @endforeach
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-3">
                        <p class="mb-0">{{ trans('cruds.candidate.fields.industry_sector') }}</p>
                    </div>
                    <div class="col-md-9">
                        <p class="text-muted mb-0">{{ $candidate->industry_sector->name ?? '' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<!-- Edit Profile -->
<div class="modal fade modalbox" id="editProfile" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Perfil</h5>
                <a href="javascript:;" data-dismiss="modal">{{ trans('global.cancel') }}</a>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route("admin.candidate.profile.update", [$candidate]) }}" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <input style="display:none">
			        <input type="password" style="display:none">
			        <input type="hidden" name="company_id" value="0">

                    <div class="card card-default">
                        <div class="card-body">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="required" for="name">{{ trans('cruds.user.fields.name') }}</label>
                                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $candidate->user->name) }}" required>
                                    @if($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.user.fields.name_helper') }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="lastname">{{ trans('cruds.user.fields.lastname') }}</label>
                                    <input class="form-control {{ $errors->has('lastname') ? 'is-invalid' : '' }}" type="text" name="lastname" id="lastname" value="{{ old('lastname', $candidate->user->lastname) }}">
                                    @if($errors->has('lastname'))
                                        <span class="text-danger">{{ $errors->first('lastname') }}</span>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.user.fields.lastname_helper') }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="required" for="email">{{ trans('cruds.user.fields.email') }}</label>
                                    <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email" id="email" value="{{ old('email', $candidate->user->email) }}" required>
                                    @if($errors->has('email'))
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.user.fields.email_helper') }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password">Nueva Contraseña</label>
                                    <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" type="password" name="password" id="password">
                                    @if($errors->has('password'))
                                        <span class="text-danger">{{ $errors->first('password') }}</span>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.user.fields.password_helper') }}</span>
                                </div>
                            </div>
                        </div>

                        <div id="accordion" class="mb-2">
                        <div class="card bg-light mb-1">
                            <div class="card-header accordion-header" id="headingOne">
                                <a class="btn" data-toggle="collapse" href="#collapseOne" role="button" aria-expanded="false" aria-controls="collapseOne"><h4 class="mb-0">{{ trans('cruds.candidate.cards.personal') }}</h4></a>
                            </div>
                            <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="gender_id">{{ trans('cruds.candidate.fields.gender') }}</label>
                                            <select class="form-control select2 {{ $errors->has('gender') ? 'is-invalid' : '' }}" name="gender_id" id="gender_id">
                                                @foreach($genders as $id => $entry)
                                                    <option value="{{ $id }}" {{ (old('gender_id') ? old('gender_id') : $candidate->gender->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                                @endforeach
                                            </select>
                                            @if($errors->has('gender'))
                                                <span class="text-danger">{{ $errors->first('gender') }}</span>
                                            @endif
                                            <span class="help-block">{{ trans('cruds.candidate.fields.gender_helper') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="birthday">{{ trans('cruds.user.fields.birthday') }}</label>
                                            <input class="form-control date {{ $errors->has('birthday') ? 'is-invalid' : '' }}" type="text" name="birthday" id="birthday" value="{{ old('birthday', $user->birthday) }}">
                                            @if($errors->has('birthday'))
                                                <span class="text-danger">{{ $errors->first('birthday') }}</span>
                                            @endif
                                            <span class="help-block">{{ trans('cruds.user.fields.birthday_helper') }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-check {{ $errors->has('disability') ? 'is-invalid' : '' }}">
                                        <input type="hidden" name="disability" value="0">
                                        <input class="form-check-input" type="checkbox" name="disability" id="disability" value="1" {{ $candidate->disability || old('disability', 0) === 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="disability">{{ trans('cruds.candidate.fields.disability') }}</label>
                                    </div>
                                    @if($errors->has('disability'))
                                        <span class="text-danger">{{ $errors->first('disability') }}</span>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.candidate.fields.disability_helper') }}</span>
                                </div>
                                <div class="form-group">
                                    <div class="form-check {{ $errors->has('immigrant') ? 'is-invalid' : '' }}">
                                        <input type="hidden" name="immigrant" value="0">
                                        <input class="form-check-input" type="checkbox" name="immigrant" id="immigrant" value="1" {{ $candidate->immigrant || old('immigrant', 0) === 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="immigrant">{{ trans('cruds.candidate.fields.immigrant') }}</label>
                                    </div>
                                    @if($errors->has('immigrant'))
                                        <span class="text-danger">{{ $errors->first('immigrant') }}</span>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.candidate.fields.immigrant_helper') }}</span>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone">{{ trans('cruds.user.fields.phone') }}</label>
                                            <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}">
                                            @if($errors->has('phone'))
                                                <span class="text-danger">{{ $errors->first('phone') }}</span>
                                            @endif
                                            <span class="help-block">{{ trans('cruds.user.fields.phone_helper') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="city_id">{{ trans('cruds.candidate.fields.city') }}</label>
                                            <select class="form-control select2 {{ $errors->has('city') ? 'is-invalid' : '' }}" name="city_id" id="city_id">
                                                @foreach($cities as $id => $entry)
                                                    <option value="{{ $id }}" {{ (old('city_id') ? old('city_id') : $candidate->city->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                                @endforeach
                                            </select>
                                            @if($errors->has('city'))
                                                <span class="text-danger">{{ $errors->first('city') }}</span>
                                            @endif
                                            <span class="help-block">{{ trans('cruds.candidate.fields.city_helper') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="address">{{ trans('cruds.candidate.fields.address') }}</label>
                                            <input class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" type="text" name="address" id="address" value="{{ old('address', $candidate->address) }}">
                                            @if($errors->has('address'))
                                                <span class="text-danger">{{ $errors->first('address') }}</span>
                                            @endif
                                            <span class="help-block">{{ trans('cruds.candidate.fields.address_helper') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="postalcode">{{ trans('cruds.candidate.fields.postalcode') }}</label>
                                            <input class="form-control {{ $errors->has('postalcode') ? 'is-invalid' : '' }}" type="text" name="postalcode" id="postalcode" value="{{ old('postalcode', $candidate->postalcode) }}">
                                            @if($errors->has('postalcode'))
                                                <span class="text-danger">{{ $errors->first('postalcode') }}</span>
                                            @endif
                                            <span class="help-block">{{ trans('cruds.candidate.fields.postalcode_helper') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="government_number">{{ trans('cruds.user.fields.government_number') }}</label>
                                            <input class="form-control {{ $errors->has('government_number') ? 'is-invalid' : '' }}" type="text" name="government_number" id="government_number" value="{{ old('government_number', $user->government_number) }}">
                                            @if($errors->has('government_number'))
                                                <span class="text-danger">{{ $errors->first('government_number') }}</span>
                                            @endif
                                            <span class="help-block">{{ trans('cruds.user.fields.government_number_helper') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="passport">{{ trans('cruds.user.fields.passport') }}</label>
                                            <input class="form-control {{ $errors->has('passport') ? 'is-invalid' : '' }}" type="text" name="passport" id="passport" value="{{ old('passport', $user->passport) }}">
                                            @if($errors->has('passport'))
                                                <span class="text-danger">{{ $errors->first('passport') }}</span>
                                            @endif
                                            <span class="help-block">{{ trans('cruds.user.fields.passport_helper') }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div>
                                        <label for="languages" class="mr-1">{{ trans('cruds.user.fields.language') }}</label>
                                        <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                                        <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                                    </div>
                                    <select class="form-control select2 {{ $errors->has('languages') ? 'is-invalid' : '' }}" name="languages[]" id="languages" multiple>
                                        @foreach($languages as $id => $language)
                                            <option value="{{ $id }}" {{ (in_array($id, old('languages', [])) || $user->languages->contains($id)) ? 'selected' : '' }}>{{ $language }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('languages'))
                                        <span class="text-danger">{{ $errors->first('languages') }}</span>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.user.fields.language_helper') }}</span>
                                </div>

                                <div class="form-group">
                                    <label for="photo">{{ trans('cruds.user.fields.photo') }}</label>
                                    <div class="needsclick dropzone {{ $errors->has('photo') ? 'is-invalid' : '' }}" id="photo-dropzone">
                                    </div>
                                    @if($errors->has('photo'))
                                        <span class="text-danger">{{ $errors->first('photo') }}</span>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.user.fields.photo_helper') }}</span>
                                </div>
                            </div>
                            </div>
                        </div>

                        <div class="card bg-light">
                            <div class="card-header accordion-header" id="headingTwo">
                                <a class="btn" data-toggle="collapse" href="#collapseTwo" role="button" aria-expanded="false" aria-controls="collapseTwo"><h4 class="mb-0">{{ trans('cruds.candidate.cards.professional') }}</h4></a>
                            </div>
                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="profile">{{ trans('cruds.candidate.fields.profile') }}</label>
                                    <textarea class="form-control ckeditor {{ $errors->has('profile') ? 'is-invalid' : '' }}" name="profile" id="profile">{!! old('profile', $candidate->profile) !!}</textarea>
                                    @if($errors->has('profile'))
                                        <span class="text-danger">{{ $errors->first('profile') }}</span>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.candidate.fields.profile_helper') }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="position">{{ trans('cruds.candidate.fields.position') }}</label>
                                    <input class="form-control {{ $errors->has('position') ? 'is-invalid' : '' }}" type="text" name="position" id="position" value="{{ old('position', $candidate->position) }}">
                                    @if($errors->has('position'))
                                        <span class="text-danger">{{ $errors->first('position') }}</span>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.candidate.fields.position_helper') }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="related_companies">{{ trans('cruds.candidate.fields.related_company') }}</label>
                                    <div style="padding-bottom: 4px">
                                        <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                                        <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                                    </div>
                                    <select class="form-control select2 {{ $errors->has('related_companies') ? 'is-invalid' : '' }}" name="related_companies[]" id="related_companies" multiple>
                                        @foreach($related_companies as $id => $related_company)
                                            <option value="{{ $id }}" {{ (in_array($id, old('related_companies', [])) || $candidate->related_companies->contains($id)) ? 'selected' : '' }}>{{ $related_company }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('related_companies'))
                                        <span class="text-danger">{{ $errors->first('related_companies') }}</span>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.candidate.fields.related_company_helper') }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="social_linkedin">{{ trans('cruds.user.fields.social_linkedin') }}</label>
                                    <input class="form-control {{ $errors->has('social_linkedin') ? 'is-invalid' : '' }}" type="text" name="social_linkedin" id="social_linkedin" value="{{ old('social_linkedin', $user->social_linkedin) }}">
                                    @if($errors->has('social_linkedin'))
                                        <span class="text-danger">{{ $errors->first('social_linkedin') }}</span>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.user.fields.social_linkedin_helper') }}</span>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="education_level_id">{{ trans('cruds.candidate.fields.education_level') }}</label>
                                            <select class="form-control select2 {{ $errors->has('education_level') ? 'is-invalid' : '' }}" name="education_level_id" id="education_level_id">
                                                @foreach($education_levels as $id => $entry)
                                                    <option value="{{ $id }}" {{ (old('education_level_id') ? old('education_level_id') : $candidate->education_level->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                                @endforeach
                                            </select>
                                            @if($errors->has('education_level'))
                                                <span class="text-danger">{{ $errors->first('education_level') }}</span>
                                            @endif
                                            <span class="help-block">{{ trans('cruds.candidate.fields.education_level_helper') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="industry_sector_id">{{ trans('cruds.candidate.fields.industry_sector') }}</label>
                                            <select class="form-control select2 {{ $errors->has('industry_sector') ? 'is-invalid' : '' }}" name="industry_sector_id" id="industry_sector_id">
                                                @foreach($industry_sectors as $id => $entry)
                                                    <option value="{{ $id }}" {{ (old('industry_sector_id') ? old('industry_sector_id') : $candidate->industry_sector->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                                @endforeach
                                            </select>
                                            @if($errors->has('industry_sector'))
                                                <span class="text-danger">{{ $errors->first('industry_sector') }}</span>
                                            @endif
                                            <span class="help-block">{{ trans('cruds.candidate.fields.industry_sector_helper') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="functional_area_id">{{ trans('cruds.candidate.fields.functional_area') }}</label>
                                            <select class="form-control select2 {{ $errors->has('functional_area') ? 'is-invalid' : '' }}" name="functional_area_id" id="functional_area_id">
                                                @foreach($functional_areas as $id => $entry)
                                                    <option value="{{ $id }}" {{ (old('functional_area_id') ? old('functional_area_id') : $candidate->functional_area->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                                @endforeach
                                            </select>
                                            @if($errors->has('functional_area'))
                                                <span class="text-danger">{{ $errors->first('functional_area') }}</span>
                                            @endif
                                            <span class="help-block">{{ trans('cruds.candidate.fields.functional_area_helper') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="professional_level_id">{{ trans('cruds.candidate.fields.professional_level') }}</label>
                                            <select class="form-control select2 {{ $errors->has('professional_level') ? 'is-invalid' : '' }}" name="professional_level_id" id="professional_level_id">
                                                @foreach($professional_levels as $id => $entry)
                                                    <option value="{{ $id }}" {{ (old('professional_level_id') ? old('professional_level_id') : $candidate->professional_level->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                                @endforeach
                                            </select>
                                            @if($errors->has('professional_level'))
                                                <span class="text-danger">{{ $errors->first('professional_level') }}</span>
                                            @endif
                                            <span class="help-block">{{ trans('cruds.candidate.fields.professional_level_helper') }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="skills">{{ trans('cruds.candidate.fields.skill') }}</label>
                                    <div style="padding-bottom: 4px">
                                        <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                                        <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                                    </div>
                                    <select class="form-control select2 {{ $errors->has('skills') ? 'is-invalid' : '' }}" name="skills[]" id="skills" multiple>
                                        @foreach($skills as $id => $skill)
                                            <option value="{{ $id }}" {{ (in_array($id, old('skills', [])) || $candidate->skills->contains($id)) ? 'selected' : '' }}>{{ $skill }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('skills'))
                                        <span class="text-danger">{{ $errors->first('skills') }}</span>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.candidate.fields.skill_helper') }}</span>
                                </div>
                            </div>
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
<!-- * Edit Profile -->
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/16.0.0/classic/ckeditor.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
<script src="{{ asset('js/main.js') }}"></script>
<script>
    Dropzone.options.photoDropzone = {
    url: '{{ route('admin.users.storeMedia') }}',
    maxFilesize: 8, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 5,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').find('input[name="photo"]').remove()
      $('form').append('<input type="hidden" name="photo" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="photo"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($user) && $user->photo)
      var file = {!! json_encode($user->photo) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, file.preview)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="photo" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
@endif
    },
    error: function (file, response) {
        if ($.type(response) === 'string') {
            var message = response //dropzone sends it's own error messages in string
        } else {
            var message = response.errors.file
        }
        file.previewElement.classList.add('dz-error')
        _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
        _results = []
        for (_i = 0, _len = _ref.length; _i < _len; _i++) {
            node = _ref[_i]
            _results.push(node.textContent = message)
        }

        return _results
    }
}
</script>
<script>
    $(document).ready(function () {
  function SimpleUploadAdapter(editor) {
    editor.plugins.get('FileRepository').createUploadAdapter = function(loader) {
      return {
        upload: function() {
          return loader.file
            .then(function (file) {
              return new Promise(function(resolve, reject) {
                // Init request
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '{{ route('admin.candidates.storeCKEditorImages') }}', true);
                xhr.setRequestHeader('x-csrf-token', window._token);
                xhr.setRequestHeader('Accept', 'application/json');
                xhr.responseType = 'json';

                // Init listeners
                var genericErrorText = `Couldn't upload file: ${ file.name }.`;
                xhr.addEventListener('error', function() { reject(genericErrorText) });
                xhr.addEventListener('abort', function() { reject() });
                xhr.addEventListener('load', function() {
                  var response = xhr.response;

                  if (!response || xhr.status !== 201) {
                    return reject(response && response.message ? `${genericErrorText}\n${xhr.status} ${response.message}` : `${genericErrorText}\n ${xhr.status} ${xhr.statusText}`);
                  }

                  $('form').append('<input type="hidden" name="ck-media[]" value="' + response.id + '">');

                  resolve({ default: response.url });
                });

                if (xhr.upload) {
                  xhr.upload.addEventListener('progress', function(e) {
                    if (e.lengthComputable) {
                      loader.uploadTotal = e.total;
                      loader.uploaded = e.loaded;
                    }
                  });
                }

                // Send request
                var data = new FormData();
                data.append('upload', file);
                data.append('crud_id', '{{ $candidate->id ?? 0 }}');
                xhr.send(data);
              });
            })
        }
      };
    }
  }

  var allEditors = document.querySelectorAll('.ckeditor');
  for (var i = 0; i < allEditors.length; ++i) {
    ClassicEditor.create(
      allEditors[i], {
        extraPlugins: [SimpleUploadAdapter]
      }
    );
  }
});
</script>

@endsection
