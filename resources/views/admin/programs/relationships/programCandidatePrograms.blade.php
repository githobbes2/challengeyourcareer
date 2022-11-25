<div class="m-3">
    @can('candidate_program_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-primary" href="{{ route('admin.candidate-programs.create', ['programID'=>$program->id]) }}">
                    {{ __('Enroll new candidates') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.candidateProgram.title') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-programCandidatePrograms">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>
                            <th>{{ trans('cruds.candidateProgram.fields.candidate') }}</th>
                            <th>{{ trans('cruds.candidateProgram.fields.tag') }}</th>
                            <th>{{ trans('cruds.candidateProgram.fields.program_start_date') }}</th>
                            <th>{{ trans('cruds.candidateProgram.fields.program_end_date') }}</th>
                            <th>{{ trans('cruds.candidateProgram.fields.relocation_date') }}</th>
                            <th>{{ trans('cruds.candidateProgram.fields.relocation_company') }}</th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($candidatePrograms as $key => $candidateProgram)
                            <tr data-entry-id="{{ $candidateProgram->id }}">
                                <td> </td>
                                <td>
                                    {{ $candidateProgram->candidate->full_name ?? '' }}
                                </td>
                                <td>
                                    @foreach($candidateProgram->tags as $key => $item)
                                        <span class="badge badge-info">{{ $item->name }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    {{ $candidateProgram->program_start_date ?? '' }}
                                </td>
                                <td>
                                    {{ $candidateProgram->program_end_date ?? '' }}
                                </td>
                                <td>
                                    {{ $candidateProgram->relocation_date ?? '' }}
                                </td>
                                <td>
                                    {{ $candidateProgram->relocation_company ?? '' }}
                                </td>
                                <td width="150">
                                <form action="{{ route('admin.candidate-programs.destroy', $candidateProgram->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;" autocomplete="0">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                    <div class="btn-group" role="group" aria-label="Acciones">
                                        @can('candidate_program_show')
                                        <a class="btn btn-xs btn-primary" href="{{ route('admin.candidate-programs.show', $candidateProgram->id) }}">{{ trans('global.view') }}</a>
                                        @endcan
                                        @can('candidate_program_edit')
                                        <a class="btn btn-xs btn-info" href="{{ route('admin.candidate-programs.edit', $candidateProgram->id) }}">{{ trans('global.edit') }}</a>
                                        @endcan
                                        @can('candidate_program_delete')
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
@can('candidate_program_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.candidate-programs.massDestroy') }}",
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
  let table = $('.datatable-programCandidatePrograms:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
