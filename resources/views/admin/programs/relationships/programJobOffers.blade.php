<div class="m-3">
    @can('job_offer_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-primary" href="{{ route('admin.job-offers.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.jobOffer.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.jobOffer.title') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-programJobOffers">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>
                        <th>
                                {{ trans('cruds.jobOffer.fields.title') }}
                            </th>
                            <th>
                                {{ trans('cruds.jobOffer.fields.user') }}
                            </th>
                            <th>
                                {{ trans('cruds.jobOffer.fields.active') }}
                            </th>
                            <th>
                                {{ trans('cruds.jobOffer.fields.date_start') }}
                            </th>
                            <th>
                                {{ trans('cruds.jobOffer.fields.date_end') }}
                            </th>
                            <th>
                                {{ trans('cruds.jobOffer.fields.tag') }}
                            </th>
                            <th>
                                {{ trans('cruds.jobOffer.fields.recruiter_type') }}
                            </th>
                            <th>
                                {{ trans('cruds.jobOffer.fields.company') }}
                            </th>
                            <th>
                                {{ trans('cruds.jobOffer.fields.city') }}
                            </th>
                            <th>
                                {{ trans('cruds.jobOffer.fields.educational_level') }}
                            </th>
                            <th>
                                {{ trans('cruds.jobOffer.fields.professional_level') }}
                            </th>
                            <th>
                                {{ trans('cruds.jobOffer.fields.functional_area') }}
                            </th>
                            <th>
                                {{ trans('cruds.jobOffer.fields.language') }}
                            </th>
                            <th>
                                {{ trans('cruds.jobOffer.fields.skill') }}
                            </th>
                            <th>
                                {{ trans('cruds.jobOffer.fields.industry_sector') }}
                            </th>
                            <th>
                                {{ trans('cruds.jobOffer.fields.attachments') }}
                            </th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jobOffers as $key => $jobOffer)
                            <tr data-entry-id="{{ $jobOffer->id }}">
                                <td> </td>
                                <td>
                                    {{ $jobOffer->title ?? '' }}
                                </td>
                                <td>
                                    {{ $jobOffer->user->name ?? '' }}
                                </td>
                                <td>
                                    <span style="display:none">{{ $jobOffer->active ?? '' }}</span>
                                    <input type="checkbox" disabled="disabled" {{ $jobOffer->active ? 'checked' : '' }}>
                                </td>
                                <td>
                                    {{ $jobOffer->date_start ?? '' }}
                                </td>
                                <td>
                                    {{ $jobOffer->date_end ?? '' }}
                                </td>
                                <td>
                                    @foreach($jobOffer->tags as $key => $item)
                                        <span class="badge badge-info">{{ $item->name }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    {{ $jobOffer->recruiter_type->name ?? '' }}
                                </td>
                                <td>
                                    {{ $jobOffer->company ?? '' }}
                                </td>
                                <td>
                                    {{ $jobOffer->city->name ?? '' }}
                                </td>
                                <td>
                                    {{ $jobOffer->educational_level->name ?? '' }}
                                </td>
                                <td>
                                    {{ $jobOffer->professional_level->name ?? '' }}
                                </td>
                                <td>
                                    {{ $jobOffer->functional_area->name ?? '' }}
                                </td>
                                <td>
                                    @foreach($jobOffer->languages as $key => $item)
                                        <span class="badge badge-info">{{ $item->name }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    {{ $jobOffer->skill->name ?? '' }}
                                </td>
                                <td>
                                    {{ $jobOffer->industry_sector->name ?? '' }}
                                </td>
                                <td>
                                    @foreach($jobOffer->attachments as $key => $media)
                                        <a href="{{ $media->getUrl() }}" target="_blank">
                                            {{ trans('global.view_file') }}
                                        </a>
                                    @endforeach
                                </td>
                                <td width="150">
                                <form action="{{ route('admin.job-offers.destroy', $jobOffer->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;" autocomplete="0">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                    <div class="btn-group" role="group" aria-label="Acciones">
                                        @can('job_offer_show')
                                        <a class="btn btn-xs btn-primary" href="{{ route('admin.job-offers.show', $jobOffer->id) }}">{{ trans('global.view') }}</a>
                                        @endcan
                                        @can('job_offer_edit')
                                        <a class="btn btn-xs btn-info" href="{{ route('admin.job-offers.edit', $jobOffer->id) }}">{{ trans('global.edit') }}</a>
                                        @endcan
                                        @can('job_offer_delete')
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
@can('job_offer_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.job-offers.massDestroy') }}",
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
  let table = $('.datatable-programJobOffers:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
