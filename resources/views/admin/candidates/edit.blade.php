@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.candidate.title_singular') }}
    </div>

    <div class="card-body">
        <form autocomplete="off" method="POST" action="{{ route("admin.candidates.update", [$candidate->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <input style="display:none">
			<input type="password" style="display:none">
            <input type="hidden" name="referer" value="{{ $referer }}">

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="required" for="name">{{ trans('cruds.user.fields.name') }}</label>
                        <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required>
                        @if($errors->has('name'))
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.user.fields.name_helper') }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="lastname">{{ trans('cruds.user.fields.lastname') }}</label>
                        <input class="form-control {{ $errors->has('lastname') ? 'is-invalid' : '' }}" type="text" name="lastname" id="lastname" value="{{ old('lastname', $user->lastname) }}">
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
                        <label class="required" for="company_id">{{ trans('cruds.candidate.fields.company') }}</label>
                        <select class="form-control select2 {{ $errors->has('company') ? 'is-invalid' : '' }}" name="company_id" id="company_id" required>
                            @foreach($companies as $id => $entry)
                                <option value="{{ $id }}" {{ (old('company_id') ? old('company_id') : $candidate->company->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('company'))
                            <span class="text-danger">{{ $errors->first('company') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.candidate.fields.company_helper') }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="system_language_id">{{ trans('cruds.user.fields.system_language') }}</label>
                        <select class="form-control select2 {{ $errors->has('system_language') ? 'is-invalid' : '' }}" name="system_language_id" id="system_language_id">
                            @foreach($system_languages as $id => $entry)
                                <option value="{{ $id }}" {{ (old('system_language_id') ? old('system_language_id') : $user->system_language->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('system_language'))
                            <span class="text-danger">{{ $errors->first('system_language') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.user.fields.system_language_helper') }}</span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="required" for="email">{{ trans('cruds.user.fields.email') }}</label>
                        <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required>
                        @if($errors->has('email'))
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.user.fields.email_helper') }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="required" for="password">{{ trans('cruds.user.fields.password') }}</label>
                        <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" type="password" name="password" id="password" autocomplete="new-password">
                        @if($errors->has('password'))
                            <span class="text-danger">{{ $errors->first('password') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.user.fields.password_helper') }}</span>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="form-check {{ $errors->has('challenge_card') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="challenge_card" value="0">
                    <input class="form-check-input" type="checkbox" name="challenge_card" id="challenge_card" value="1" {{ $candidate->challenge_card || old('challenge_card', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="challenge_card">{{ trans('cruds.candidate.fields.challenge_card') }}</label>
                </div>
                @if($errors->has('challenge_card'))
                    <span class="text-danger">{{ $errors->first('challenge_card') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.candidate.fields.challenge_card_helper') }}</span>
            </div>

            <div id="accordion">
            <div class="card bg-light">
                <div class="card-header" id="headingOne">
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
                        <label for="languages">{{ trans('cruds.user.fields.language') }}</label>
                        <div style="padding-bottom: 4px">
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
                <div class="card-header" id="headingTwo">
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
                        <label for="tags">{{ trans('cruds.candidate.fields.tag') }}</label>
                        <div style="padding-bottom: 4px">
                            <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                            <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                        </div>
                        <select class="form-control select2 {{ $errors->has('tags') ? 'is-invalid' : '' }}" name="tags[]" id="tags" multiple>
                            @foreach($tags as $id => $tag)
                                <option value="{{ $id }}" {{ (in_array($id, old('tags', [])) || $candidate->tags->contains($id)) ? 'selected' : '' }}>{{ $tag }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('tags'))
                            <span class="text-danger">{{ $errors->first('tags') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.candidate.fields.tag_helper') }}</span>
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
                        <label for="target_companies">{{ trans('cruds.candidate.fields.target_companies') }}</label>
                        <textarea class="form-control {{ $errors->has('target_companies') ? 'is-invalid' : '' }}" name="target_companies" id="target_companies">{{ old('target_companies', $candidate->target_companies) }}</textarea>
                        @if($errors->has('target_companies'))
                            <span class="text-danger">{{ $errors->first('target_companies') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.candidate.fields.target_companies_helper') }}</span>
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
                        <a href="#" onclick="window.history.back();" class="btn btn-default float-right">{{ trans('global.cancel') }}</a>
                    </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
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
