@extends('layouts.admin')
@section('content')
@can('candidate_curriculum_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-primary" href="{{ route('admin.candidate-curriculums.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.candidateCurriculum.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.candidateCurriculum.title') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-CandidateCurriculum">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.candidateCurriculum.fields.candidate') }}
                        </th>
                        <th>
                            {{ trans('cruds.candidateCurriculum.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.candidateCurriculum.fields.file') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($candidateCurriculums as $key => $candidateCurriculum)
                        <tr data-entry-id="{{ $candidateCurriculum->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $candidateCurriculum->candidate->full_name ?? '' }}
                            </td>
                            <td>
                                {{ $candidateCurriculum->name ?? '' }}
                            </td>
                            <td>
                                @if($candidateCurriculum->file)
                                    <a href="{{ $candidateCurriculum->file->getUrl() }}" target="_blank">
                                        {{ trans('global.view_file') }}
                                    </a>
                                @endif
                            </td>
                            <td width="150">
                                <form action="{{ route('admin.candidate-curriculums.destroy', $candidateCurriculum->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;" autocomplete="0">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                    <div class="btn-group" role="group" aria-label="Acciones">
                                        @can('candidate_curriculum_show')
                                        <a class="btn btn-xs btn-primary" href="{{ route('admin.candidate-curriculums.show', $candidateCurriculum->id) }}">{{ trans('global.view') }}</a>
                                        @endcan
                                        @can('candidate_curriculum_edit')
                                        <a class="btn btn-xs btn-info" href="{{ route('admin.candidate-curriculums.edit', $candidateCurriculum->id) }}">{{ trans('global.edit') }}</a>
                                        @endcan
                                        @can('candidate_curriculum_delete')
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
@can('candidate_curriculum_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.candidate-curriculums.massDestroy') }}",
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
  let table = $('.datatable-CandidateCurriculum:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
