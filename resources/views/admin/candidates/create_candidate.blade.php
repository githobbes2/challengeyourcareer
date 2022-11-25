@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.candidate.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.candidates.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="user_id">{{ trans('cruds.candidate.fields.user') }}</label>
                <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id" required>
                    @foreach($users as $id => $entry)
                        <option value="{{ $id }}" {{ old('user_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('user'))
                    <span class="text-danger">{{ $errors->first('user') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.candidate.fields.user_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="company_id">{{ trans('cruds.candidate.fields.company') }}</label>
                <select class="form-control select2 {{ $errors->has('company') ? 'is-invalid' : '' }}" name="company_id" id="company_id" required>
                    @foreach($companies as $id => $entry)
                        <option value="{{ $id }}" {{ old('company_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('company'))
                    <span class="text-danger">{{ $errors->first('company') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.candidate.fields.company_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="city_id">{{ trans('cruds.candidate.fields.city') }}</label>
                <select class="form-control select2 {{ $errors->has('city') ? 'is-invalid' : '' }}" name="city_id" id="city_id">
                    @foreach($cities as $id => $entry)
                        <option value="{{ $id }}" {{ old('city_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('city'))
                    <span class="text-danger">{{ $errors->first('city') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.candidate.fields.city_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="address">{{ trans('cruds.candidate.fields.address') }}</label>
                <input class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" type="text" name="address" id="address" value="{{ old('address', '') }}">
                @if($errors->has('address'))
                    <span class="text-danger">{{ $errors->first('address') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.candidate.fields.address_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="postalcode">{{ trans('cruds.candidate.fields.postalcode') }}</label>
                <input class="form-control {{ $errors->has('postalcode') ? 'is-invalid' : '' }}" type="text" name="postalcode" id="postalcode" value="{{ old('postalcode', '') }}">
                @if($errors->has('postalcode'))
                    <span class="text-danger">{{ $errors->first('postalcode') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.candidate.fields.postalcode_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="curriculum">{{ trans('cruds.candidate.fields.curriculum') }}</label>
                <div class="needsclick dropzone {{ $errors->has('curriculum') ? 'is-invalid' : '' }}" id="curriculum-dropzone">
                </div>
                @if($errors->has('curriculum'))
                    <span class="text-danger">{{ $errors->first('curriculum') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.candidate.fields.curriculum_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="profile">{{ trans('cruds.candidate.fields.profile') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('profile') ? 'is-invalid' : '' }}" name="profile" id="profile">{!! old('profile') !!}</textarea>
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
                        <option value="{{ $id }}" {{ in_array($id, old('tags', [])) ? 'selected' : '' }}>{{ $tag }}</option>
                    @endforeach
                </select>
                @if($errors->has('tags'))
                    <span class="text-danger">{{ $errors->first('tags') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.candidate.fields.tag_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="education_level_id">{{ trans('cruds.candidate.fields.education_level') }}</label>
                <select class="form-control select2 {{ $errors->has('education_level') ? 'is-invalid' : '' }}" name="education_level_id" id="education_level_id">
                    @foreach($education_levels as $id => $entry)
                        <option value="{{ $id }}" {{ old('education_level_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('education_level'))
                    <span class="text-danger">{{ $errors->first('education_level') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.candidate.fields.education_level_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="professional_level_id">{{ trans('cruds.candidate.fields.professional_level') }}</label>
                <select class="form-control select2 {{ $errors->has('professional_level') ? 'is-invalid' : '' }}" name="professional_level_id" id="professional_level_id">
                    @foreach($professional_levels as $id => $entry)
                        <option value="{{ $id }}" {{ old('professional_level_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('professional_level'))
                    <span class="text-danger">{{ $errors->first('professional_level') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.candidate.fields.professional_level_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="functional_area_id">{{ trans('cruds.candidate.fields.functional_area') }}</label>
                <select class="form-control select2 {{ $errors->has('functional_area') ? 'is-invalid' : '' }}" name="functional_area_id" id="functional_area_id">
                    @foreach($functional_areas as $id => $entry)
                        <option value="{{ $id }}" {{ old('functional_area_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('functional_area'))
                    <span class="text-danger">{{ $errors->first('functional_area') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.candidate.fields.functional_area_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="skills">{{ trans('cruds.candidate.fields.skill') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('skills') ? 'is-invalid' : '' }}" name="skills[]" id="skills" multiple>
                    @foreach($skills as $id => $skill)
                        <option value="{{ $id }}" {{ in_array($id, old('skills', [])) ? 'selected' : '' }}>{{ $skill }}</option>
                    @endforeach
                </select>
                @if($errors->has('skills'))
                    <span class="text-danger">{{ $errors->first('skills') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.candidate.fields.skill_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="industry_sector_id">{{ trans('cruds.candidate.fields.industry_sector') }}</label>
                <select class="form-control select2 {{ $errors->has('industry_sector') ? 'is-invalid' : '' }}" name="industry_sector_id" id="industry_sector_id">
                    @foreach($industry_sectors as $id => $entry)
                        <option value="{{ $id }}" {{ old('industry_sector_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('industry_sector'))
                    <span class="text-danger">{{ $errors->first('industry_sector') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.candidate.fields.industry_sector_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="position">{{ trans('cruds.candidate.fields.position') }}</label>
                <input class="form-control {{ $errors->has('position') ? 'is-invalid' : '' }}" type="text" name="position" id="position" value="{{ old('position', '') }}">
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
                        <option value="{{ $id }}" {{ in_array($id, old('related_companies', [])) ? 'selected' : '' }}>{{ $related_company }}</option>
                    @endforeach
                </select>
                @if($errors->has('related_companies'))
                    <span class="text-danger">{{ $errors->first('related_companies') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.candidate.fields.related_company_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="gender_id">{{ trans('cruds.candidate.fields.gender') }}</label>
                <select class="form-control select2 {{ $errors->has('gender') ? 'is-invalid' : '' }}" name="gender_id" id="gender_id">
                    @foreach($genders as $id => $entry)
                        <option value="{{ $id }}" {{ old('gender_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('gender'))
                    <span class="text-danger">{{ $errors->first('gender') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.candidate.fields.gender_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('disability') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="disability" value="0">
                    <input class="form-check-input" type="checkbox" name="disability" id="disability" value="1" {{ old('disability', 0) == 1 ? 'checked' : '' }}>
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
                    <input class="form-check-input" type="checkbox" name="immigrant" id="immigrant" value="1" {{ old('immigrant', 0) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="immigrant">{{ trans('cruds.candidate.fields.immigrant') }}</label>
                </div>
                @if($errors->has('immigrant'))
                    <span class="text-danger">{{ $errors->first('immigrant') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.candidate.fields.immigrant_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('challenge_card') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="challenge_card" value="0">
                    <input class="form-check-input" type="checkbox" name="challenge_card" id="challenge_card" value="1" {{ old('challenge_card', 0) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="challenge_card">{{ trans('cruds.candidate.fields.challenge_card') }}</label>
                </div>
                @if($errors->has('challenge_card'))
                    <span class="text-danger">{{ $errors->first('challenge_card') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.candidate.fields.challenge_card_helper') }}</span>
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
    Dropzone.options.curriculumDropzone = {
    url: '{{ route('admin.candidates.storeMedia') }}',
    maxFilesize: 8, // MB
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 5
    },
    success: function (file, response) {
      $('form').find('input[name="curriculum"]').remove()
      $('form').append('<input type="hidden" name="curriculum" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="curriculum"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($candidate) && $candidate->curriculum)
      var file = {!! json_encode($candidate->curriculum) !!}
          this.options.addedfile.call(this, file)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="curriculum" value="' + file.file_name + '">')
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
