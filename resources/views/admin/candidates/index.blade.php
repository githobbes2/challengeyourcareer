@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
        {{ trans('cruds.candidate.title') }}
        @can('candidate_create')
            <a class="btn btn-sm btn-primary float-right" href="{{ route('admin.candidates.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.candidate.title_singular') }}
            </a>
        @endcan
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Candidate">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>{{ trans('global.name') }}</th>
                        <th>{{ trans('cruds.candidate.fields.company') }}</th>
                        <th>{{ trans('cruds.candidate.fields.city') }}</th>
                        <th>{{ trans('cruds.candidate.fields.curriculum') }}</th>
                        <th>{{ trans('cruds.candidate.fields.tag') }}</th>
                        <th>{{ trans('cruds.candidate.fields.education_level') }}</th>
                        <th>{{ trans('cruds.candidate.fields.professional_level') }}</th>
                        <th>{{ trans('cruds.candidate.fields.functional_area') }}</th>
                        <th>{{ trans('cruds.candidate.fields.industry_sector') }}</th>
                        <th>{{ trans('cruds.candidate.fields.position') }}</th>
                        <th>{{ trans('cruds.candidate.fields.target_companies') }}</th>
                        <th>{{ trans('cruds.candidate.fields.gender') }}</th>
                        <th>{{ trans('cruds.candidate.fields.disability') }}</th>
                        <th>{{ trans('cruds.candidate.fields.immigrant') }}</th>
                        <th>{{ trans('global.score') }}</th>
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
                            <select class="search">
                                <option value>{{ trans('global.all') }}</option>
                                @foreach($companies as $key => $item)
                                    <option value="{{ $item->name }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
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
                        </td>
                        <td>
                            <select class="search">
                                <option value>{{ trans('global.all') }}</option>
                                @foreach($candidate_tags as $key => $item)
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
                                @foreach($industry_sectors as $key => $item)
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
                                @foreach($companies as $key => $item)
                                    <option value="{{ $item->name }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select class="search">
                                <option value>{{ trans('global.all') }}</option>
                                @foreach($genders as $key => $item)
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
                        </td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($candidates as $key => $candidate)
                        <tr data-entry-id="{{ $candidate->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $candidate->full_name ?? '' }}
                            </td>
                            <td>
                                {{ $candidate->company->name ?? '' }}
                            </td>
                            <td>
                                {{ $candidate->city->name ?? '' }}
                            </td>
                            <td>
                                @if($candidate->curriculum)
                                    <a href="{{ $candidate->curriculum->getUrl() }}" target="_blank">
                                        {{ trans('global.view_file') }}
                                    </a>
                                @endif
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
                                {{ $candidate->target_companies ?? '' }}
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



@endsection
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
    order: [[ 1, 'asc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-Candidate:not(.ajaxTable)').DataTable({ buttons: dtButtons })
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
