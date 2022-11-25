@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.sessionUser.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.session-users.update", [$sessionUser->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf

            <input type="hidden" name="referer" id="referer" value="{{ $referer }}">
            @if(Auth::user()->is_consultant && !Auth::user()->is_admin)
            <input type="hidden" name="user_id" id="user_id" value="{{ $sessionUser->user->id }}">
            <input type="hidden" name="session_id" id="session_id" value="{{ $sessionUser->session->id }}">
            <div class="form-group">
                <label for="user_id">{{ trans('cruds.sessionUser.fields.user') }}</label>
                <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="select_user_id" id="select_user_id" disabled>
                    @foreach($users as $id => $entry)
                        <option value="{{ $id }}" {{ (old('user_id') ? old('user_id') : $sessionUser->user->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('user'))
                    <span class="text-danger">{{ $errors->first('user') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.sessionUser.fields.user_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="session_id">{{ trans('cruds.sessionUser.fields.session') }}</label>
                <select class="form-control select2 {{ $errors->has('session') ? 'is-invalid' : '' }}" name="select_session_id" id="select_session_id" disabled>
                    @foreach($sessions as $id => $entry)
                        <option value="{{ $id }}" {{ (old('session_id') ? old('session_id') : $sessionUser->session->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('session'))
                    <span class="text-danger">{{ $errors->first('session') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.sessionUser.fields.session_helper') }}</span>
            </div>
            @else
            <div class="form-group">
                <label class="required" for="user_id">{{ trans('cruds.sessionUser.fields.user') }}</label>
                <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id" required>
                    @foreach($users as $id => $entry)
                        <option value="{{ $id }}" {{ (old('user_id') ? old('user_id') : $sessionUser->user->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('user'))
                    <span class="text-danger">{{ $errors->first('user') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.sessionUser.fields.user_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="session_id">{{ trans('cruds.sessionUser.fields.session') }}</label>
                <select class="form-control select2 {{ $errors->has('session') ? 'is-invalid' : '' }}" name="session_id" id="session_id" required>
                    @foreach($sessions as $id => $entry)
                        <option value="{{ $id }}" {{ (old('session_id') ? old('session_id') : $sessionUser->session->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('session'))
                    <span class="text-danger">{{ $errors->first('session') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.sessionUser.fields.session_helper') }}</span>
            </div>
            @endif

            <div class="form-group">
                <div class="form-check {{ $errors->has('attendance') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="attendance" value="0">
                    <input class="form-check-input" type="checkbox" name="attendance" id="attendance" value="1" {{ $sessionUser->attendance || old('attendance', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="attendance">{{ trans('cruds.sessionUser.fields.attendance') }}</label>
                </div>
                @if($errors->has('attendance'))
                    <span class="text-danger">{{ $errors->first('attendance') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.sessionUser.fields.attendance_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="notes">{{ trans('cruds.sessionUser.fields.notes') }}</label>
                <textarea class="form-control {{ $errors->has('notes') ? 'is-invalid' : '' }}" name="notes" id="notes">{{ old('notes', $sessionUser->notes) }}</textarea>
                @if($errors->has('notes'))
                    <span class="text-danger">{{ $errors->first('notes') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.sessionUser.fields.notes_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="attachments">{{ trans('cruds.sessionUser.fields.attachments') }}</label>
                <div class="needsclick dropzone {{ $errors->has('attachments') ? 'is-invalid' : '' }}" id="attachments-dropzone">
                </div>
                @if($errors->has('attachments'))
                    <span class="text-danger">{{ $errors->first('attachments') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.sessionUser.fields.attachments_helper') }}</span>
            </div>
            @if(!Auth::user()->is_consultant && Auth::user()->is_admin)
            <div class="form-group">
                <label for="score">{{ trans('cruds.sessionUser.fields.score') }}</label>
                <input class="form-control {{ $errors->has('score') ? 'is-invalid' : '' }}" type="number" name="score" id="score" value="{{ old('score', $sessionUser->score) }}" step="1" min="1" max="5">
                @if($errors->has('score'))
                    <span class="text-danger">{{ $errors->first('score') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.sessionUser.fields.score_helper') }}</span>
            </div>
            @endif
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
    var uploadedAttachmentsMap = {}
Dropzone.options.attachmentsDropzone = {
    url: '{{ route('admin.session-users.storeMedia') }}',
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
@if(isset($sessionUser) && $sessionUser->attachments)
          var files =
            {!! json_encode($sessionUser->attachments) !!}
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
