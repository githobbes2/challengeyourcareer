<div class="m-3">
    @can('session_user_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-primary" href="{{ route('admin.session-users.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.sessionUser.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.sessionUser.title') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-session_users">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>
                        <th>
                                {{ trans('cruds.sessionUser.fields.user') }}
                            </th>
                            <th>
                                {{ trans('cruds.sessionUser.fields.session') }}
                            </th>
                            <th>
                                {{ trans('cruds.session.fields.start_time') }}
                            </th>
                            <th>
                                {{ trans('cruds.sessionUser.fields.attendance') }}
                            </th>
                            <th>
                                {{ trans('cruds.sessionUser.fields.score') }}
                            </th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sessionUsers as $key => $sessionUser)
                            <tr data-entry-id="{{ $sessionUser->id }}">
                                <td> </td>
                                <td>
                                    {{ $sessionUser->user->name ?? '' }}
                                </td>
                                <td>
                                    {{ $sessionUser->session->title ?? '' }}
                                </td>
                                <td>
                                    {{ $sessionUser->session->start_time ?? '' }}
                                </td>
                                <td>
                                    <span style="display:none">{{ $sessionUser->attendance ?? '' }}</span>
                                    <input type="checkbox" disabled="disabled" {{ $sessionUser->attendance ? 'checked' : '' }}>
                                </td>
                                <td>
                                    {{ $sessionUser->score ?? '' }}
                                </td>
                                <td width="150">
                                <form action="{{ route('admin.session-users.destroy', $sessionUser->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;" autocomplete="0">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                    <div class="btn-group" role="group" aria-label="Acciones">
                                        @can('session_user_show')
                                        <a class="btn btn-xs btn-primary" href="{{ route('admin.session-users.show', $sessionUser->id) }}">{{ trans('global.view') }}</a>
                                        @endcan
                                        @can('session_user_edit')
                                        <a class="btn btn-xs btn-info" href="{{ route('admin.session-users.edit', $sessionUser->id) }}">{{ trans('global.edit') }}</a>
                                        @endcan
                                        @can('session_user_delete')
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
@can('session_user_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.session-users.massDestroy') }}",
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
  let table = $('.datatable-session_users:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
