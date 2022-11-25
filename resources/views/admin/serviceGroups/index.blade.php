@extends('layouts.admin')
@section('content')
@can('service_group_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-primary" href="{{ route('admin.service-groups.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.serviceGroup.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.serviceGroup.title') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-ServiceGroup">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.serviceGroup.fields.type') }}
                        </th>
                        <th>
                            {{ trans('cruds.serviceGroup.fields.name') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($serviceGroups as $key => $serviceGroup)
                        <tr data-entry-id="{{ $serviceGroup->id }}">
                            <td>

                            </td>
                            <td>
                                {{ App\Models\ServiceGroup::TYPE_RADIO[$serviceGroup->type] ?? '' }}
                            </td>
                            <td>
                                {{ $serviceGroup->name ?? '' }}
                            </td>
                            <td width="150">
                                <form action="{{ route('admin.service-groups.destroy', $serviceGroup->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;" autocomplete="0">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                    <div class="btn-group" role="group" aria-label="Acciones">
                                        @can('service_group_show')
                                        <a class="btn btn-xs btn-primary" href="{{ route('admin.service-groups.show', $serviceGroup->id) }}">{{ trans('global.view') }}</a>
                                        @endcan
                                        @can('service_group_edit')
                                        <a class="btn btn-xs btn-info" href="{{ route('admin.service-groups.edit', $serviceGroup->id) }}">{{ trans('global.edit') }}</a>
                                        @endcan
                                        @can('service_group_delete')
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
@can('service_group_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.service-groups.massDestroy') }}",
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
    order: [[ 3, 'asc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-ServiceGroup:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
