<div class="m-3">
    @can('user_note_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-primary" href="{{ route('admin.user-notes.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.userNote.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.userNote.title') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-userUserNotes">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>
                        <th>
                                {{ trans('cruds.userNote.fields.user') }}
                            </th>
                            <th>
                                {{ trans('cruds.userNote.fields.title') }}
                            </th>
                            <th>
                                {{ trans('cruds.userNote.fields.session_user') }}
                            </th>
                            <th>
                                {{ trans('cruds.userNote.fields.tag') }}
                            </th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($userNotes as $key => $userNote)
                            <tr data-entry-id="{{ $userNote->id }}">
                                <td> </td>
                                <td>
                                    {{ $userNote->user->name ?? '' }}
                                </td>
                                <td>
                                    {{ $userNote->title ?? '' }}
                                </td>
                                <td>
                                    {{ $userNote->session_user->attendance ?? '' }}
                                </td>
                                <td>
                                    @foreach($userNote->tags as $key => $item)
                                        <span class="badge badge-info">{{ $item->name }}</span>
                                    @endforeach
                                </td>
                                <td width="150">
                                <form action="{{ route('admin.user-notes.destroy', $userNote->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;" autocomplete="0">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                    <div class="btn-group" role="group" aria-label="Acciones">
                                        @can('user_note_show')
                                        <a class="btn btn-xs btn-primary" href="{{ route('admin.user-notes.show', $userNote->id) }}">{{ trans('global.view') }}</a>
                                        @endcan
                                        @can('user_note_edit')
                                        <a class="btn btn-xs btn-info" href="{{ route('admin.user-notes.edit', $userNote->id) }}">{{ trans('global.edit') }}</a>
                                        @endcan
                                        @can('user_note_delete')
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
@can('user_note_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.user-notes.massDestroy') }}",
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
  let table = $('.datatable-userUserNotes:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
