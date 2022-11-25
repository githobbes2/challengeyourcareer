<div class="m-3">
    @can('job_offer_candidate_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-primary" href="{{ route('admin.job-offer-candidates.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.jobOfferCandidate.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.jobOfferCandidate.title') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-candidateJobOfferCandidates">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>
                        <th>
                                {{ trans('cruds.jobOfferCandidate.fields.job_offer') }}
                            </th>
                            <th>
                                {{ trans('cruds.jobOfferCandidate.fields.candidate') }}
                            </th>
                            <th>
                                {{ trans('cruds.jobOfferCandidate.fields.status') }}
                            </th>
                            <th>
                                {{ trans('cruds.jobOfferCandidate.fields.is_favorite') }}
                            </th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jobOfferCandidates as $key => $jobOfferCandidate)
                            <tr data-entry-id="{{ $jobOfferCandidate->id }}">
                                <td> </td>
                                <td>
                                    {{ $jobOfferCandidate->job_offer->title ?? '' }}
                                </td>
                                <td>
                                    {{ $jobOfferCandidate->candidate->full_name ?? '' }}
                                </td>
                                <td>
                                    {{ App\Models\JobOfferCandidate::STATUS_RADIO[$jobOfferCandidate->status] ?? '' }}
                                </td>
                                <td>
                                    <span style="display:none">{{ $jobOfferCandidate->is_favorite ?? '' }}</span>
                                    <input type="checkbox" disabled="disabled" {{ $jobOfferCandidate->is_favorite ? 'checked' : '' }}>
                                </td>
                                <td width="150">
                                <form action="{{ route('admin.job-offer-candidates.destroy', $jobOfferCandidate->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;" autocomplete="0">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                    <div class="btn-group" role="group" aria-label="Acciones">
                                        @can('job_offer_candidate_show')
                                        <a class="btn btn-xs btn-primary" href="{{ route('admin.job-offer-candidates.show', $jobOfferCandidate->id) }}">{{ trans('global.view') }}</a>
                                        @endcan
                                        @can('job_offer_candidate_edit')
                                        <a class="btn btn-xs btn-info" href="{{ route('admin.job-offer-candidates.edit', $jobOfferCandidate->id) }}">{{ trans('global.edit') }}</a>
                                        @endcan
                                        @can('job_offer_candidate_delete')
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
@can('job_offer_candidate_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.job-offer-candidates.massDestroy') }}",
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
  let table = $('.datatable-candidateJobOfferCandidates:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
