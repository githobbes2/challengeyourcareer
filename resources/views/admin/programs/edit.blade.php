@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.program.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.programs.update", [$program->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.program.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $program->name) }}" required>
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.program.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="internal_name">{{ trans('cruds.program.fields.internal_name') }}</label>
                <input class="form-control {{ $errors->has('internal_name') ? 'is-invalid' : '' }}" type="text" name="internal_name" id="internal_name" value="{{ old('internal_name', $program->internal_name) }}">
                @if($errors->has('internal_name'))
                    <span class="text-danger">{{ $errors->first('internal_name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.program.fields.internal_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="program_type_id">{{ trans('cruds.program.fields.program_type') }}</label>
                <select class="form-control select2 {{ $errors->has('program_type') ? 'is-invalid' : '' }}" name="program_type_id" id="program_type_id">
                    @foreach($program_types as $id => $entry)
                        <option value="{{ $id }}" {{ (old('program_type_id') ? old('program_type_id') : $program->program_type->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('program_type'))
                    <span class="text-danger">{{ $errors->first('program_type') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.program.fields.program_type_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="session_template_id">{{ trans('cruds.program.fields.session_template') }}</label>
                <select class="form-control select2 {{ $errors->has('session_template') ? 'is-invalid' : '' }}" name="session_template_id" id="session_template_id">
                    @foreach($session_templates as $id => $entry)
                        <option value="{{ $id }}" {{ (old('session_template_id') ? old('session_template_id') : $program->session_template_id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('session_template'))
                    <span class="text-danger">{{ $errors->first('session_template') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.program.fields.session_template_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="user_id">{{ trans('cruds.program.fields.user') }}</label>
                <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id" required>
                    @foreach($users as $id => $entry)
                        <option value="{{ $id }}" {{ (old('user_id') ? old('user_id') : $program->user->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('user'))
                    <span class="text-danger">{{ $errors->first('user') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.program.fields.user_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">{{ trans('cruds.program.fields.individual') }}</label>
                @foreach(App\Models\Program::INDIVIDUAL_RADIO as $key => $label)
                    <div class="form-check {{ $errors->has('individual') ? 'is-invalid' : '' }}">
                        <input class="form-check-input" type="radio" id="individual_{{ $key }}" name="individual" value="{{ $key }}" {{ old('individual', $program->individual) === (string) $key ? 'checked' : '' }} required>
                        <label class="form-check-label" for="individual_{{ $key }}">{{ $label }}</label>
                    </div>
                @endforeach
                @if($errors->has('individual'))
                    <span class="text-danger">{{ $errors->first('individual') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.program.fields.individual_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="service_group_id">{{ trans('cruds.program.fields.service_group') }}</label>
                <select class="form-control select2 {{ $errors->has('service_group') ? 'is-invalid' : '' }}" name="service_group_id" id="service_group_id">
                    @foreach($service_groups as $id => $entry)
                        <option value="{{ $id }}" {{ (old('service_group_id') ? old('service_group_id') : $program->service_group_id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('service_group'))
                    <span class="text-danger">{{ $errors->first('service_group') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.program.fields.service_group_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="company_id">{{ trans('cruds.program.fields.company') }}</label>
                <select class="form-control select2 {{ $errors->has('company') ? 'is-invalid' : '' }}" name="company_id" id="company_id">
                    @foreach($companies as $id => $entry)
                        <option value="{{ $id }}" {{ (old('company_id') ? old('company_id') : $program->company->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('company'))
                    <span class="text-danger">{{ $errors->first('company') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.program.fields.company_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="invoice">{{ trans('cruds.program.fields.invoice') }}</label>
                <input class="form-control {{ $errors->has('invoice') ? 'is-invalid' : '' }}" type="text" name="invoice" id="invoice" value="{{ old('invoice', $program->invoice) }}">
                @if($errors->has('invoice'))
                    <span class="text-danger">{{ $errors->first('invoice') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.program.fields.invoice_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="reference">{{ trans('cruds.program.fields.reference') }}</label>
                <input class="form-control {{ $errors->has('reference') ? 'is-invalid' : '' }}" type="text" name="reference" id="reference" value="{{ old('reference', $program->reference) }}">
                @if($errors->has('reference'))
                    <span class="text-danger">{{ $errors->first('reference') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.program.fields.reference_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="internal_notes">{{ trans('cruds.program.fields.internal_notes') }}</label>
                <textarea class="form-control {{ $errors->has('internal_notes') ? 'is-invalid' : '' }}" name="internal_notes" id="internal_notes">{{ old('internal_notes', $program->internal_notes) }}</textarea>
                @if($errors->has('internal_notes'))
                    <span class="text-danger">{{ $errors->first('internal_notes') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.program.fields.internal_notes_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="attachments">{{ trans('cruds.program.fields.attachments') }}</label>
                <div class="needsclick dropzone {{ $errors->has('attachments') ? 'is-invalid' : '' }}" id="attachments-dropzone">
                </div>
                @if($errors->has('attachments'))
                    <span class="text-danger">{{ $errors->first('attachments') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.program.fields.attachments_helper') }}</span>
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
    var uploadedAttachmentsMap = {}
Dropzone.options.attachmentsDropzone = {
    url: '{{ route('admin.programs.storeMedia') }}',
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
@if(isset($program) && $program->attachments)
          var files =
            {!! json_encode($program->attachments) !!}
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
