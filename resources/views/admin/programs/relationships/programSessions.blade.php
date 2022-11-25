<div class="m-3">
    @can('session_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-primary" href="{{ route('admin.sessions.create', ['programID'=>$program->id]) }}">
                    {{ trans('global.add') }} {{ trans('cruds.session.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.session.title') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-programSessions">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>
                            <th>{{ trans('cruds.session.fields.title') }}</th>
                            <th>{{ trans('cruds.session.fields.user') }}</th>
                            <th>{{ trans('cruds.session.fields.session_type') }}</th>
                            <th>{{ trans('cruds.session.fields.start_time') }}</th>
                            <th>{{ trans('cruds.session.fields.location') }}</th>
                            <th>{{ trans('cruds.session.fields.status') }}</th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sessions as $key => $session)
                            <tr data-entry-id="{{ $session->id }}">
                                <td> </td>
                                <td>{{ $session->title ?? '' }}</td>
                                <td>{{ $session->user->name ?? '' }}</td>
                                <td>{{ $session->session_type->name ?? '' }}</td>
                                <td>{{ $session->start_time ?? '' }}</td>
                                <td>{{ $session->location ?? '' }}</td>
                                <td>{{ App\Models\Session::STATUS_RADIO[$session->status] ?? '' }}</td>
                                <td width="150">
                                <form action="{{ route('admin.sessions.destroy', $session->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;" autocomplete="0">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                    <div class="btn-group" role="group" aria-label="Acciones">
                                        @can('session_show')
                                        <a class="btn btn-xs btn-primary" href="{{ route('admin.sessions.show', $session->id) }}">{{ trans('global.view') }}</a>
                                        @endcan
                                        @can('session_edit')
                                        <a class="btn btn-xs btn-info" href="{{ route('admin.sessions.edit', $session->id) }}">{{ trans('global.edit') }}</a>
                                        @endcan
                                        @can('session_delete')
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
</div>
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('session_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.sessions.massDestroy') }}",
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
    order: [[ 4, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-programSessions:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
