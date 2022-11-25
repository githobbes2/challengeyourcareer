<div class="m-3">
    @can('candidate_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-primary" href="{{ route('admin.candidates.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.candidate.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.candidate.title') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-companyCandidates">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>
                            <th>{{ trans('cruds.user.name') }}</th>
                            <th>{{ trans('cruds.candidate.fields.tag') }}</th>
                            <th>{{ trans('cruds.candidate.fields.education_level') }}</th>
                            <th>{{ trans('cruds.candidate.fields.professional_level') }}</th>
                            <th>{{ trans('cruds.candidate.fields.functional_area') }}</th>
                            <th>{{ trans('cruds.candidate.fields.industry_sector') }}</th>
                            <th>{{ trans('cruds.candidate.fields.position') }}</th>
                            <th>{{ trans('cruds.candidate.fields.related_company') }}</th>
                            <th>{{ trans('cruds.candidate.fields.gender') }}</th>
                            <th>{{ trans('cruds.candidate.fields.disability') }}</th>
                            <th>{{ trans('cruds.candidate.fields.immigrant') }}</th>
                            <th>{{ trans('cruds.candidate.fields.employability_score') }}</th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($candidates as $key => $candidate)
                            <tr data-entry-id="{{ $candidate->id }}">
                                <td> </td>
                                <td>
                                    {{ $candidate->user->full_name ?? '' }}
                                </td>
                                <td>
                                    @foreach($candidate->tags as $key => $item)
                                        <span class="badge badge-info">{{ $item->name }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    {{ $candidate->education_level->name ?? '' }}
                                </td>
                                <td>
                                    {{ $candidate->professional_level->name ?? '' }}
                                </td>
                                <td>
                                    {{ $candidate->functional_area->name ?? '' }}
                                </td>
                                <td>
                                    {{ $candidate->industry_sector->name ?? '' }}
                                </td>
                                <td>
                                    {{ $candidate->position ?? '' }}
                                </td>
                                <td>
                                    @foreach($candidate->related_companies as $key => $item)
                                        <span class="badge badge-info">{{ $item->name }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    {{ $candidate->gender->name ?? '' }}
                                </td>
                                <td>
                                    <span style="display:none">{{ $candidate->disability ?? '' }}</span>
                                    <input type="checkbox" disabled="disabled" {{ $candidate->disability ? 'checked' : '' }}>
                                </td>
                                <td>
                                    <span style="display:none">{{ $candidate->immigrant ?? '' }}</span>
                                    <input type="checkbox" disabled="disabled" {{ $candidate->immigrant ? 'checked' : '' }}>
                                </td>
                                <td>
                                    {{ $candidate->employability_score ?? '' }}
                                </td>
                                <td width="150">
                                <form action="{{ route('admin.candidates.destroy', $candidate->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;" autocomplete="0">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                    <div class="btn-group" role="group" aria-label="Acciones">
                                        @can('candidate_show')
                                        <a class="btn btn-xs btn-primary" href="{{ route('admin.candidates.show', $candidate->id) }}">{{ trans('global.view') }}</a>
                                        @endcan
                                        @can('candidate_edit')
                                        <a class="btn btn-xs btn-info" href="{{ route('admin.candidates.edit', $candidate->id) }}">{{ trans('global.edit') }}</a>
                                        @endcan
                                        @can('candidate_delete')
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
@can('candidate_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.candidates.massDestroy') }}",
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
  let table = $('.datatable-companyCandidates:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
