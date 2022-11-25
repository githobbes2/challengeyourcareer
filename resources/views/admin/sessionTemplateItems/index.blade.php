@extends('layouts.admin')
@section('content')
@can('session_template_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-primary" href="{{ route('admin.session-templates.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.sessionTemplate.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.sessionTemplate.title') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-SessionTemplate">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>{{ trans('cruds.sessionTemplate.fields.session_type') }}</th>
                        <th>{{ trans('cruds.sessionTemplate.fields.quantity') }}</th>
                        <th>{{ trans('cruds.sessionTemplate.fields.title') }}</th>
                        <th>{{ trans('cruds.sessionTemplate.fields.duration') }}</th>
                        <th>{{ trans('cruds.sessionTemplate.fields.attachments') }}</th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sessionTemplates as $key => $sessionTemplate)
                        <tr data-entry-id="{{ $sessionTemplate->id }}">
                            <td>

                            </td>
                            <td>{{ $sessionTemplate->session_type->name ?? '' }}</td>
                            <td>{{ $sessionTemplate->quantity ?? '' }}</td>
                            <td>{{ $sessionTemplate->title ?? '' }}</td>
                            <td>{{ $sessionTemplate->duration ?? '' }}</td>
                            <td>
                                @foreach($sessionTemplate->attachments as $key => $media)
                                    <a href="{{ $media->getUrl() }}" target="_blank">
                                        {{ trans('global.view_file') }}
                                    </a>
                                @endforeach
                            </td>
                            <td width="150">
                                <form action="{{ route('admin.session-templates.destroy', $sessionTemplate->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;" autocomplete="0">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                    <div class="btn-group" role="group" aria-label="Acciones">
                                        @can('session_template_show')
                                        <a class="btn btn-xs btn-primary" href="{{ route('admin.session-templates.show', $sessionTemplate->id) }}">{{ trans('global.view') }}</a>
                                        @endcan
                                        @can('session_template_edit')
                                        <a class="btn btn-xs btn-info" href="{{ route('admin.session-templates.edit', $sessionTemplate->id) }}">{{ trans('global.edit') }}</a>
                                        @endcan
                                        @can('session_template_delete')
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                        @endcan
                                    </div>
                                </form>

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('session_template_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.session-templates.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-SessionTemplate:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
