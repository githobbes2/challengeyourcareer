@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.consultant.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.consultants.update", [$consultant->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="user_id">{{ trans('cruds.consultant.fields.user') }}</label>
                <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id" required>
                    @foreach($users as $id => $entry)
                        <option value="{{ $id }}" {{ (old('user_id') ? old('user_id') : $consultant->user->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('user'))
                    <span class="text-danger">{{ $errors->first('user') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.consultant.fields.user_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="consultant_type_id">{{ trans('cruds.consultant.fields.consultant_type') }}</label>
                <select class="form-control select2 {{ $errors->has('consultant_type') ? 'is-invalid' : '' }}" name="consultant_type_id" id="consultant_type_id" required>
                    @foreach($consultant_types as $id => $entry)
                        <option value="{{ $id }}" {{ (old('consultant_type_id') ? old('consultant_type_id') : $consultant->consultant_type->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('consultant_type'))
                    <span class="text-danger">{{ $errors->first('consultant_type') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.consultant.fields.consultant_type_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="office_id">{{ trans('cruds.consultant.fields.office') }}</label>
                <select class="form-control select2 {{ $errors->has('office') ? 'is-invalid' : '' }}" name="office_id" id="office_id">
                    @foreach($offices as $id => $entry)
                        <option value="{{ $id }}" {{ (old('office_id') ? old('office_id') : $consultant->office->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('office'))
                    <span class="text-danger">{{ $errors->first('office') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.consultant.fields.office_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="profile">{{ trans('cruds.consultant.fields.profile') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('profile') ? 'is-invalid' : '' }}" name="profile" id="profile">{!! old('profile', $consultant->profile) !!}</textarea>
                @if($errors->has('profile'))
                    <span class="text-danger">{{ $errors->first('profile') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.consultant.fields.profile_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="session_skills">{{ trans('cruds.consultant.fields.session_skills') }}</label>
                <textarea class="form-control {{ $errors->has('session_skills') ? 'is-invalid' : '' }}" name="session_skills" id="session_skills">{{ old('session_skills', $consultant->session_skills) }}</textarea>
                @if($errors->has('session_skills'))
                    <span class="text-danger">{{ $errors->first('session_skills') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.consultant.fields.session_skills_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="skill_tags">{{ trans('cruds.consultant.fields.skill_tags') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('skill_tags') ? 'is-invalid' : '' }}" name="skill_tags[]" id="skill_tags" multiple>
                    @foreach($skill_tags as $id => $skill_tag)
                        <option value="{{ $id }}" {{ (in_array($id, old('skill_tags', [])) || $consultant->skill_tags->contains($id)) ? 'selected' : '' }}>{{ $skill_tag }}</option>
                    @endforeach
                </select>
                @if($errors->has('skill_tags'))
                    <span class="text-danger">{{ $errors->first('skill_tags') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.consultant.fields.skill_tags_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('challenge_card') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="challenge_card" value="0">
                    <input class="form-check-input" type="checkbox" name="challenge_card" id="challenge_card" value="1" {{ $consultant->challenge_card || old('challenge_card', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="challenge_card">{{ trans('cruds.consultant.fields.challenge_card') }}</label>
                </div>
                @if($errors->has('challenge_card'))
                    <span class="text-danger">{{ $errors->first('challenge_card') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.consultant.fields.challenge_card_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="url_linkedin">{{ trans('cruds.consultant.fields.url_linkedin') }}</label>
                <input class="form-control {{ $errors->has('url_linkedin') ? 'is-invalid' : '' }}" type="text" name="url_linkedin" id="url_linkedin" value="{{ old('url_linkedin', $consultant->url_linkedin) }}">
                @if($errors->has('url_linkedin'))
                    <span class="text-danger">{{ $errors->first('url_linkedin') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.consultant.fields.url_linkedin_helper') }}</span>
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
                xhr.open('POST', '{{ route('admin.consultants.storeCKEditorImages') }}', true);
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
                data.append('crud_id', '{{ $consultant->id ?? 0 }}');
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
