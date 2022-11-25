<div class="m-3">
    @can('poll_candidate_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-primary" href="{{ route('admin.poll-candidates.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.pollCandidate.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.pollCandidate.title') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-candidateProgramPollCandidates">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>
                        <th>
                                {{ trans('cruds.pollCandidate.fields.poll') }}
                            </th>
                            <th>
                                {{ trans('cruds.pollCandidate.fields.candidate') }}
                            </th>
                            <th>
                                {{ trans('cruds.pollCandidate.fields.score') }}
                            </th>
                            <th>
                                {{ trans('cruds.pollCandidate.fields.experience_points') }}
                            </th>
                            <th>
                                {{ trans('cruds.pollCandidate.fields.languages') }}
                            </th>
                            <th>
                                {{ trans('cruds.pollCandidate.fields.educational_level') }}
                            </th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pollCandidates as $key => $pollCandidate)
                            <tr data-entry-id="{{ $pollCandidate->id }}">
                                <td> </td>
                                <td>
                                    {{ $pollCandidate->poll->name ?? '' }}
                                </td>
                                <td>
                                    {{ $pollCandidate->candidate->full_name ?? '' }}
                                </td>
                                <td>
                                    {{ $pollCandidate->score ?? '' }}
                                </td>
                                <td>
                                    {{ $pollCandidate->experience_points ?? '' }}
                                </td>
                                <td>
                                    @foreach($pollCandidate->languages as $key => $item)
                                        <span class="badge badge-info">{{ $item->name }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    {{ $pollCandidate->educational_level->name ?? '' }}
                                </td>
                                <td width="150">
                                <form action="{{ route('admin.poll-candidates.destroy', $pollCandidate->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;" autocomplete="0">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                    <div class="btn-group" role="group" aria-label="Acciones">
                                        @can('poll_candidate_show')
                                        <a class="btn btn-xs btn-primary" href="{{ route('admin.poll-candidates.show', $pollCandidate->id) }}">{{ trans('global.view') }}</a>
                                        @endcan
                                        @can('poll_candidate_edit')
                                        <a class="btn btn-xs btn-info" href="{{ route('admin.poll-candidates.edit', $pollCandidate->id) }}">{{ trans('global.edit') }}</a>
                                        @endcan
                                        @can('poll_candidate_delete')
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
@can('poll_candidate_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.poll-candidates.massDestroy') }}",
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
  let table = $('.datatable-candidateProgramPollCandidates:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
