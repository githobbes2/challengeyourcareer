@extends('layouts.admin')
@section('content')
@can('candidate_commitment_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-primary" href="{{ route('admin.candidate-commitments.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.candidateCommitment.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.candidateCommitment.title') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-CandidateCommitment">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>{{ trans('cruds.candidateCommitment.fields.title') }}</th>
                        <th>{{ trans('cruds.candidateCommitment.fields.candidate') }}</th>
                        <th>{{ trans('cruds.candidateCommitment.fields.session_user') }}</th>
                        <th>{{ trans('cruds.candidateCommitment.fields.complete') }}</th>
                        <th>{{ trans('cruds.candidateCommitment.fields.completion_date') }}</th>
                        <th>{{ trans('cruds.candidateCommitment.fields.tag') }}</th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($candidateCommitments as $key => $candidateCommitment)
                        <tr data-entry-id="{{ $candidateCommitment->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $candidateCommitment->title ?? '' }}
                            </td>
                            <td>
                                {{ $candidateCommitment->candidate->full_name ?? '' }}
                            </td>
                            <td>
                                {{ $candidateCommitment->session_user->session->title ?? '' }}
                            </td>
                            <td>
                                <span style="display:none">{{ $candidateCommitment->complete ?? '' }}</span>
                                <input type="checkbox" disabled="disabled" {{ $candidateCommitment->complete ? 'checked' : '' }}>
                            </td>
                            <td>
                                {{ $candidateCommitment->completion_date ?? '' }}
                            </td>
                            <td>
                                @foreach($candidateCommitment->tags as $key => $item)
                                    <span class="badge badge-info">{{ $item->name }}</span>
                                @endforeach
                            </td>
                            <td width="150">
                                <form action="{{ route('admin.candidate-commitments.destroy', $candidateCommitment->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;" autocomplete="0">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                    <div class="btn-group" role="group" aria-label="Acciones">
                                        @can('candidate_commitment_show')
                                        <a class="btn btn-xs btn-primary" href="{{ route('admin.candidate-commitments.show', $candidateCommitment->id) }}">{{ trans('global.view') }}</a>
                                        @endcan
                                        @can('candidate_commitment_edit')
                                        <a class="btn btn-xs btn-info" href="{{ route('admin.candidate-commitments.edit', $candidateCommitment->id) }}">{{ trans('global.edit') }}</a>
                                        @endcan
                                        @can('candidate_commitment_delete')
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
@can('candidate_commitment_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.candidate-commitments.massDestroy') }}",
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
  let table = $('.datatable-CandidateCommitment:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
