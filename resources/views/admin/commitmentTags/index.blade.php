@extends('layouts.admin')
@section('content')
@can('commitment_tag_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-primary" href="{{ route('admin.commitment-tags.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.commitmentTag.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.commitmentTag.title') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-CommitmentTag">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.commitmentTag.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.commitmentTag.fields.color') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($commitmentTags as $key => $commitmentTag)
                        <tr data-entry-id="{{ $commitmentTag->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $commitmentTag->name ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\CommitmentTag::COLOR_RADIO[$commitmentTag->color] ?? '' }}
                            </td>
                            <td width="150">
                                <form action="{{ route('admin.commitment-tags.destroy', $commitmentTag->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;" autocomplete="0">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                    <div class="btn-group" role="group" aria-label="Acciones">
                                        @can('commitment_tag_show')
                                        <a class="btn btn-xs btn-primary" href="{{ route('admin.commitment-tags.show', $commitmentTag->id) }}">{{ trans('global.view') }}</a>
                                        @endcan
                                        @can('commitment_tag_edit')
                                        <a class="btn btn-xs btn-info" href="{{ route('admin.commitment-tags.edit', $commitmentTag->id) }}">{{ trans('global.edit') }}</a>
                                        @endcan
                                        @can('commitment_tag_delete')
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
@can('commitment_tag_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.commitment-tags.massDestroy') }}",
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
    order: [[ 2, 'asc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-CommitmentTag:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
