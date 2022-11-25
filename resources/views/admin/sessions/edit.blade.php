@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.session.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.sessions.update", [$session->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="required" for="title">{{ trans('cruds.session.fields.title') }}</label>
                        <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', $session->title) }}" required>
                        @if($errors->has('title'))
                            <span class="text-danger">{{ $errors->first('title') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.session.fields.title_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label class="required" for="session_type_id">{{ trans('cruds.session.fields.session_type') }}</label>
                        <select class="form-control select2 {{ $errors->has('session_type') ? 'is-invalid' : '' }}" name="session_type_id" id="session_type_id" required>
                            @foreach($session_types as $id => $entry)
                                <option value="{{ $id }}" {{ (old('session_type_id') ? old('session_type_id') : $session->session_type->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('session_type'))
                            <span class="text-danger">{{ $errors->first('session_type') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.session.fields.session_type_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label class="required" for="user_id">{{ trans('cruds.session.fields.user') }}</label>
                        <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id" required>
                            @foreach($users as $id => $entry)
                                <option value="{{ $id }}" {{ (old('user_id') ? old('user_id') : $session->user->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('user'))
                            <span class="text-danger">{{ $errors->first('user') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.session.fields.user_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label for="program_id">{{ trans('cruds.session.fields.program') }}</label>
                        <select class="form-control select2 {{ $errors->has('program') ? 'is-invalid' : '' }}" name="program_id" id="program_id">
                            @foreach($programs as $item)
                                <option value="{{ $item->id }}" {{ (old('program_id') ? old('program_id') : $session->program->id ?? '') == $item->id ? 'selected' : '' }}>{{ $item->name }} {{ $item->internal_name ? '('. $item->internal_name .')' : '' }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('program'))
                            <span class="text-danger">{{ $errors->first('program') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.session.fields.program_helper') }}</span>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-8">
                            <div class="form-group">
                                <label class="required" for="start_time">{{ trans('cruds.session.fields.start_time') }}</label>
                                <input class="form-control datetime {{ $errors->has('start_time') ? 'is-invalid' : '' }}" type="text" name="start_time" id="start_time" value="{{ old('start_time', $session->start_time) }}" required>
                                @if($errors->has('start_time'))
                                    <span class="text-danger">{{ $errors->first('start_time') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.session.fields.start_time_helper') }}</span>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label class="required" for="duration">{{ trans('cruds.session.fields.duration') }}</label>
                                <input class="form-control {{ $errors->has('duration') ? 'is-invalid' : '' }}" type="number" name="duration" id="duration" value="{{ old('duration', $session->duration) }}" step="1" required>
                                @if($errors->has('duration'))
                                    <span class="text-danger">{{ $errors->first('duration') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.session.fields.duration_helper') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="location">{{ trans('cruds.session.fields.location') }}</label>
                        <input class="form-control {{ $errors->has('location') ? 'is-invalid' : '' }}" type="text" name="location" id="location" value="{{ old('location', $session->location) }}">
                        @if($errors->has('location'))
                            <span class="text-danger">{{ $errors->first('location') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.session.fields.location_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label class="required">{{ trans('cruds.session.fields.status') }}</label>
                        @foreach(App\Models\Session::STATUS_RADIO as $key => $label)
                            <div class="form-check {{ $errors->has('status') ? 'is-invalid' : '' }}">
                                <input class="form-check-input" type="radio" id="status_{{ $key }}" name="status" value="{{ $key }}" {{ old('status', $session->status) === (string) $key ? 'checked' : '' }} required>
                                <label class="form-check-label" for="status_{{ $key }}">{{ $label }}</label>
                            </div>
                        @endforeach
                        @if($errors->has('status'))
                            <span class="text-danger">{{ $errors->first('status') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.session.fields.status_helper') }}</span>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="description">{{ trans('cruds.session.fields.description') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description">{!! old('description', $session->description) !!}</textarea>
                @if($errors->has('description'))
                    <span class="text-danger">{{ $errors->first('description') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.session.fields.description_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="private_notes">{{ trans('cruds.session.fields.private_notes') }}</label>
                <textarea class="form-control {{ $errors->has('private_notes') ? 'is-invalid' : '' }}" name="private_notes" id="private_notes">{{ old('private_notes', $session->private_notes) }}</textarea>
                @if($errors->has('private_notes'))
                    <span class="text-danger">{{ $errors->first('private_notes') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.session.fields.private_notes_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="attachments">{{ trans('cruds.session.fields.attachments') }}</label>
                <div class="needsclick dropzone {{ $errors->has('attachments') ? 'is-invalid' : '' }}" id="attachments-dropzone">
                </div>
                @if($errors->has('attachments'))
                    <span class="text-danger">{{ $errors->first('attachments') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.session.fields.attachments_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="manager_score">{{ trans('cruds.session.fields.manager_score') }}</label>
                <input class="form-control {{ $errors->has('manager_score') ? 'is-invalid' : '' }}" type="number" name="manager_score" id="manager_score" value="{{ old('manager_score', $session->manager_score) }}" step="1">
                @if($errors->has('manager_score'))
                    <span class="text-danger">{{ $errors->first('manager_score') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.session.fields.manager_score_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="development_area_id">{{ trans('cruds.session.fields.development_area') }}</label>
                <select class="form-control {{ $errors->has('development_area') ? 'is-invalid' : '' }}" name="development_area_id" id="development_area_id" required>
                    @foreach($development_areas as $id => $entry)
                        <option value="{{ $id }}" {{ (old('development_area_id') ? old('development_area_id') : $session->development_area->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('development_area'))
                    <span class="text-danger">{{ $errors->first('development_area') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.session.fields.development_area_helper') }}</span>
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
                xhr.open('POST', '{{ route('admin.sessions.storeCKEditorImages') }}', true);
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
                data.append('crud_id', '{{ $session->id ?? 0 }}');
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
    url: '{{ route('admin.sessions.storeMedia') }}',
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
@if(isset($session) && $session->attachments)
          var files =
            {!! json_encode($session->attachments) !!}
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
