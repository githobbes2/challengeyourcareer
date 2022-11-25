@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
        {{ trans('cruds.program.title') }}
        @can('program_create')
            <a class="btn btn-sm btn-primary float-right" href="{{ route('admin.programs.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.program.title_singular') }}
            </a>
        @endcan
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Program">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>{{ trans('cruds.program.fields.name') }}</th>
                        <th>{{ trans('global.sessions') }}</th>
                        <th>{{ trans('global.candidates') }}</th>
                        <th>{{ trans('cruds.program.fields.user') }}</th>
                        <th>{{ trans('cruds.program.fields.company') }}</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($programs as $key => $program)
                        <tr data-entry-id="{{ $program->id }}">
                            <td>

                            </td>
                            <th>{{ $program->name . ($program->internal_name ? ' ('. $program->internal_name .')' : '') }}</td>
                            <td>{{ $program->sessions_count ?? '' }}</td>
                            <td>{{ $program->program_candidate_programs_count ?? '' }}</td>
                            <td>{{ $program->user->name ?? '' }}</td>
                            <td>{{ $program->company->name ?? '' }}</td>
                            <td width="150">
                                <form action="{{ route('admin.programs.destroy', $program->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;" autocomplete="0">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                    <div class="btn-group" role="group" aria-label="Acciones">
                                        @can('program_show')
                                        <a class="btn btn-xs btn-primary" href="{{ route('admin.programs.show', $program->id) }}">{{ trans('global.view') }}</a>
                                        @endcan
                                        @can('program_edit')
                                        <a class="btn btn-xs btn-info" href="{{ route('admin.programs.edit', $program->id) }}">{{ trans('global.edit') }}</a>
                                        @endcan
                                        @can('program_delete')
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
@can('program_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.programs.massDestroy') }}",
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
    order: [[ 1, 'asc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-Program:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
