@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.jobOffer.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.job-offers.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="title">{{ trans('cruds.jobOffer.fields.title') }}</label>
                <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', '') }}" required>
                @if($errors->has('title'))
                    <span class="text-danger">{{ $errors->first('title') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.jobOffer.fields.title_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="user_id">{{ trans('cruds.jobOffer.fields.user') }}</label>
                @if(Auth::user()->is_consultant && !Auth::user()->is_admin)
                    <select class="form-control select2" name="user_id" id="user_id" disabled>
                        @foreach($users as $id => $entry)
                            @if(Auth::user()->id == $id)
                            <option value="{{ $id }}" selected>{{ $entry }}</option>
                            @endif
                        @endforeach
                    </select>
                @else
                    <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id">
                        @foreach($users as $id => $entry)
                            <option value="{{ $id }}" {{ old('user_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('user'))
                        <span class="text-danger">{{ $errors->first('user') }}</span>
                    @endif
                @endif
                <span class="help-block">{{ trans('cruds.jobOffer.fields.user_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="candidate_id">{{ trans('cruds.jobOffer.fields.candidate') }}</label>
                <select class="form-control select2 {{ $errors->has('candidate') ? 'is-invalid' : '' }}" name="candidate_id" id="candidate_id">
                    @foreach($candidates as $id => $entry)
                        <option value="{{ $id }}" {{ old('candidate_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('candidate'))
                    <span class="text-danger">{{ $errors->first('candidate') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.jobOffer.fields.candidate_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="program_id">{{ trans('cruds.jobOffer.fields.program') }}</label>
                <select class="form-control select2 {{ $errors->has('program') ? 'is-invalid' : '' }}" name="program_id" id="program_id">
                    @foreach($programs as $id => $entry)
                        <option value="{{ $id }}" {{ old('program_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('program'))
                    <span class="text-danger">{{ $errors->first('program') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.jobOffer.fields.program_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('active') ? 'is-invalid' : '' }}">
                    <input class="form-check-input" type="checkbox" name="active" id="active" value="1" required {{ old('active', 0) == 1 || old('active') === null ? 'checked' : '' }}>
                    <label class="required form-check-label" for="active">{{ trans('cruds.jobOffer.fields.active') }}</label>
                </div>
                @if($errors->has('active'))
                    <span class="text-danger">{{ $errors->first('active') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.jobOffer.fields.active_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="date_start">{{ trans('cruds.jobOffer.fields.date_start') }}</label>
                <input class="form-control date {{ $errors->has('date_start') ? 'is-invalid' : '' }}" type="text" name="date_start" id="date_start" value="{{ old('date_start') }}" required>
                @if($errors->has('date_start'))
                    <span class="text-danger">{{ $errors->first('date_start') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.jobOffer.fields.date_start_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="date_end">{{ trans('cruds.jobOffer.fields.date_end') }}</label>
                <input class="form-control date {{ $errors->has('date_end') ? 'is-invalid' : '' }}" type="text" name="date_end" id="date_end" value="{{ old('date_end') }}">
                @if($errors->has('date_end'))
                    <span class="text-danger">{{ $errors->first('date_end') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.jobOffer.fields.date_end_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="tags">{{ trans('cruds.jobOffer.fields.tag') }}</label>
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
                <span class="help-block">{{ trans('cruds.jobOffer.fields.tag_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="recruiter_type_id">{{ trans('cruds.jobOffer.fields.recruiter_type') }}</label>
                <select class="form-control select2 {{ $errors->has('recruiter_type') ? 'is-invalid' : '' }}" name="recruiter_type_id" id="recruiter_type_id">
                    @foreach($recruiter_types as $id => $entry)
                        <option value="{{ $id }}" {{ old('recruiter_type_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('recruiter_type'))
                    <span class="text-danger">{{ $errors->first('recruiter_type') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.jobOffer.fields.recruiter_type_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="company">{{ trans('cruds.jobOffer.fields.company') }}</label>
                <input class="form-control {{ $errors->has('company') ? 'is-invalid' : '' }}" type="text" name="company" id="company" value="{{ old('company', '') }}">
                @if($errors->has('company'))
                    <span class="text-danger">{{ $errors->first('company') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.jobOffer.fields.company_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="contact_name">{{ trans('cruds.jobOffer.fields.contact_name') }}</label>
                <input class="form-control {{ $errors->has('contact_name') ? 'is-invalid' : '' }}" type="text" name="contact_name" id="contact_name" value="{{ old('contact_name', '') }}">
                @if($errors->has('contact_name'))
                    <span class="text-danger">{{ $errors->first('contact_name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.jobOffer.fields.contact_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="contact_email">{{ trans('cruds.jobOffer.fields.contact_email') }}</label>
                <input class="form-control {{ $errors->has('contact_email') ? 'is-invalid' : '' }}" type="email" name="contact_email" id="contact_email" value="{{ old('contact_email') }}">
                @if($errors->has('contact_email'))
                    <span class="text-danger">{{ $errors->first('contact_email') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.jobOffer.fields.contact_email_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="contact_phone">{{ trans('cruds.jobOffer.fields.contact_phone') }}</label>
                <input class="form-control {{ $errors->has('contact_phone') ? 'is-invalid' : '' }}" type="text" name="contact_phone" id="contact_phone" value="{{ old('contact_phone', '') }}">
                @if($errors->has('contact_phone'))
                    <span class="text-danger">{{ $errors->first('contact_phone') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.jobOffer.fields.contact_phone_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="url">{{ trans('cruds.jobOffer.fields.url') }}</label>
                <input class="form-control {{ $errors->has('url') ? 'is-invalid' : '' }}" type="text" name="url" id="url" value="{{ old('url', '') }}">
                @if($errors->has('url'))
                    <span class="text-danger">{{ $errors->first('url') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.jobOffer.fields.url_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="city_id">{{ trans('cruds.jobOffer.fields.city') }}</label>
                <select class="form-control select2 {{ $errors->has('city') ? 'is-invalid' : '' }}" name="city_id" id="city_id">
                    @foreach($cities as $id => $entry)
                        <option value="{{ $id }}" {{ old('city_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('city'))
                    <span class="text-danger">{{ $errors->first('city') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.jobOffer.fields.city_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="description">{{ trans('cruds.jobOffer.fields.description') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description">{!! old('description') !!}</textarea>
                @if($errors->has('description'))
                    <span class="text-danger">{{ $errors->first('description') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.jobOffer.fields.description_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="educational_level_id">{{ trans('cruds.jobOffer.fields.educational_level') }}</label>
                <select class="form-control select2 {{ $errors->has('educational_level') ? 'is-invalid' : '' }}" name="educational_level_id" id="educational_level_id">
                    @foreach($educational_levels as $id => $entry)
                        <option value="{{ $id }}" {{ old('educational_level_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('educational_level'))
                    <span class="text-danger">{{ $errors->first('educational_level') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.jobOffer.fields.educational_level_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="professional_level_id">{{ trans('cruds.jobOffer.fields.professional_level') }}</label>
                <select class="form-control select2 {{ $errors->has('professional_level') ? 'is-invalid' : '' }}" name="professional_level_id" id="professional_level_id">
                    @foreach($professional_levels as $id => $entry)
                        <option value="{{ $id }}" {{ old('professional_level_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('professional_level'))
                    <span class="text-danger">{{ $errors->first('professional_level') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.jobOffer.fields.professional_level_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="functional_area_id">{{ trans('cruds.jobOffer.fields.functional_area') }}</label>
                <select class="form-control select2 {{ $errors->has('functional_area') ? 'is-invalid' : '' }}" name="functional_area_id" id="functional_area_id">
                    @foreach($functional_areas as $id => $entry)
                        <option value="{{ $id }}" {{ old('functional_area_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('functional_area'))
                    <span class="text-danger">{{ $errors->first('functional_area') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.jobOffer.fields.functional_area_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="languages">{{ trans('cruds.jobOffer.fields.language') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('languages') ? 'is-invalid' : '' }}" name="languages[]" id="languages" multiple>
                    @foreach($languages as $id => $language)
                        <option value="{{ $id }}" {{ in_array($id, old('languages', [])) ? 'selected' : '' }}>{{ $language }}</option>
                    @endforeach
                </select>
                @if($errors->has('languages'))
                    <span class="text-danger">{{ $errors->first('languages') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.jobOffer.fields.language_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="skill_id">{{ trans('cruds.jobOffer.fields.skill') }}</label>
                <select class="form-control select2 {{ $errors->has('skill') ? 'is-invalid' : '' }}" name="skill_id" id="skill_id">
                    @foreach($skills as $id => $entry)
                        <option value="{{ $id }}" {{ old('skill_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('skill'))
                    <span class="text-danger">{{ $errors->first('skill') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.jobOffer.fields.skill_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="industry_sector_id">{{ trans('cruds.jobOffer.fields.industry_sector') }}</label>
                <select class="form-control select2 {{ $errors->has('industry_sector') ? 'is-invalid' : '' }}" name="industry_sector_id" id="industry_sector_id">
                    @foreach($industry_sectors as $id => $entry)
                        <option value="{{ $id }}" {{ old('industry_sector_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('industry_sector'))
                    <span class="text-danger">{{ $errors->first('industry_sector') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.jobOffer.fields.industry_sector_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="attachments">{{ trans('cruds.jobOffer.fields.attachments') }}</label>
                <div class="needsclick dropzone {{ $errors->has('attachments') ? 'is-invalid' : '' }}" id="attachments-dropzone">
                </div>
                @if($errors->has('attachments'))
                    <span class="text-danger">{{ $errors->first('attachments') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.jobOffer.fields.attachments_helper') }}</span>
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
                xhr.open('POST', '{{ route('admin.job-offers.storeCKEditorImages') }}', true);
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
                data.append('crud_id', '{{ $jobOffer->id ?? 0 }}');
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

<script>
    var uploadedAttachmentsMap = {}
Dropzone.options.attachmentsDropzone = {
    url: '{{ route('admin.job-offers.storeMedia') }}',
    maxFilesize: 8, // MB
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 5
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="attachments[]" value="' + response.name + '">')
      uploadedAttachmentsMap[file.name] = response.name
    },
    removedfile: function (file) {
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedAttachmentsMap[file.name]
      }
      $('form').find('input[name="attachments[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($jobOffer) && $jobOffer->attachments)
          var files =
            {!! json_encode($jobOffer->attachments) !!}
              for (var i in files) {
              var file = files[i]
              this.options.addedfile.call(this, file)
              file.previewElement.classList.add('dz-complete')
              $('form').append('<input type="hidden" name="attachments[]" value="' + file.file_name + '">')
            }
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
@endsection
