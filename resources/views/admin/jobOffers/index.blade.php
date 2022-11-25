@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
        {{ trans('cruds.jobOffer.title') }}
        @can('job_offer_create')
            <button class="btn btn-sm btn-warning float-right disabled" disabled data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'JobOffer', 'route' => 'admin.job-offers.parseCsvImport'])
            <a class="btn btn-sm btn-primary float-right mr-1" href="{{ route('admin.job-offers.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.jobOffer.title_singular') }}
            </a>
        @endcan
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-JobOffer">
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
                    <tr>
                        <td>
                        </td>
                        <td>
                            <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </td>
                        <td>
                            <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </td>
                        <td>
                            <select class="search">
                                <option value>{{ trans('global.all') }}</option>
                                @foreach($users as $key => $item)
                                    <option value="{{ $item->name }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                        <td>
                            <select class="search">
                                <option value>{{ trans('global.all') }}</option>
                                @foreach($job_offer_tags as $key => $item)
                                    <option value="{{ $item->name }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select class="search">
                                <option value>{{ trans('global.all') }}</option>
                                @foreach($recruiter_types as $key => $item)
                                    <option value="{{ $item->name }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </td>
                        <td>
                            <select class="search">
                                <option value>{{ trans('global.all') }}</option>
                                @foreach($cities as $key => $item)
                                    <option value="{{ $item->name }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select class="search">
                                <option value>{{ trans('global.all') }}</option>
                                @foreach($education_levels as $key => $item)
                                    <option value="{{ $item->name }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select class="search">
                                <option value>{{ trans('global.all') }}</option>
                                @foreach($professional_levels as $key => $item)
                                    <option value="{{ $item->name }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select class="search">
                                <option value>{{ trans('global.all') }}</option>
                                @foreach($functional_areas as $key => $item)
                                    <option value="{{ $item->name }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select class="search">
                                <option value>{{ trans('global.all') }}</option>
                                @foreach($languages as $key => $item)
                                    <option value="{{ $item->name }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select class="search">
                                <option value>{{ trans('global.all') }}</option>
                                @foreach($skills as $key => $item)
                                    <option value="{{ $item->name }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select class="search">
                                <option value>{{ trans('global.all') }}</option>
                                @foreach($industry_sectors as $key => $item)
                                    <option value="{{ $item->name }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jobOffers as $key => $jobOffer)
                        <tr data-entry-id="{{ $jobOffer->id }}">
                            <td>

                            </td>
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



@endsection
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
  let table = $('.datatable-JobOffer:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

let visibleColumnsIndexes = null;
$('.datatable thead').on('input', '.search', function () {
      let strict = $(this).attr('strict') || false
      let value = strict && this.value ? "^" + this.value + "$" : this.value

      let index = $(this).parent().index()
      if (visibleColumnsIndexes !== null) {
        index = visibleColumnsIndexes[index]
      }

      table
        .column(index)
        .search(value, strict)
        .draw()
  });
table.on('column-visibility.dt', function(e, settings, column, state) {
      visibleColumnsIndexes = []
      table.columns(":visible").every(function(colIdx) {
          visibleColumnsIndexes.push(colIdx);
      });
  })
})

</script>
@endsection
