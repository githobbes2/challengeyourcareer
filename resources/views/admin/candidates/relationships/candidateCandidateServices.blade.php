<div class="m-3">
    @can('candidate_service_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-primary" href="{{ route('admin.candidate-services.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.candidateService.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.candidateService.title') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-candidateCandidateServices">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>
                        <th>
                                {{ trans('cruds.candidateService.fields.candidate') }}
                            </th>
                            <th>
                                {{ trans('cruds.candidateService.fields.service_item') }}
                            </th>
                            <th>
                                {{ trans('cruds.candidateService.fields.date_service') }}
                            </th>
                            <th>
                                {{ trans('cruds.candidateService.fields.user') }}
                            </th>
                            <th>
                                {{ trans('cruds.candidateService.fields.attendance') }}
                            </th>
                            <th>
                                {{ trans('cruds.candidateService.fields.notes') }}
                            </th>
                            <th>
                                {{ trans('cruds.candidateService.fields.candidate_program') }}
                            </th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($candidateServices as $key => $candidateService)
                            <tr data-entry-id="{{ $candidateService->id }}">
                                <td> </td>
                                <td>
                                    {{ $candidateService->candidate->full_name ?? '' }}
                                </td>
                                <td>
                                    {{ $candidateService->service_item->name ?? '' }}
                                </td>
                                <td>
                                    {{ $candidateService->date_service ?? '' }}
                                </td>
                                <td>
                                    {{ $candidateService->user->name ?? '' }}
                                </td>
                                <td>
                                    <span style="display:none">{{ $candidateService->attendance ?? '' }}</span>
                                    <input type="checkbox" disabled="disabled" {{ $candidateService->attendance ? 'checked' : '' }}>
                                </td>
                                <td>
                                    {{ $candidateService->notes ?? '' }}
                                </td>
                                <td>
                                    {{ $candidateService->candidate_program->program_start_date ?? '' }}
                                </td>
                                <td width="150">
                                <form action="{{ route('admin.candidate-services.destroy', $candidateService->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;" autocomplete="0">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                    <div class="btn-group" role="group" aria-label="Acciones">
                                        @can('candidate_service_show')
                                        <a class="btn btn-xs btn-primary" href="{{ route('admin.candidate-services.show', $candidateService->id) }}">{{ trans('global.view') }}</a>
                                        @endcan
                                        @can('candidate_service_edit')
                                        <a class="btn btn-xs btn-info" href="{{ route('admin.candidate-services.edit', $candidateService->id) }}">{{ trans('global.edit') }}</a>
                                        @endcan
                                        @can('candidate_service_delete')
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
@can('candidate_service_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.candidate-services.massDestroy') }}",
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
  let table = $('.datatable-candidateCandidateServices:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
