@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.pollAgeScore.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a href="#" onclick="window.history.back();" class="btn btn-default float-right mb-2">{{ trans('global.back_to_list') }}</a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th width="180">
                            {{ trans('cruds.pollAgeScore.fields.name') }}
                        </th>
                        <td>
                            {{ $pollAgeScore->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.pollAgeScore.fields.order') }}
                        </th>
                        <td>
                            {{ $pollAgeScore->order }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.pollAgeScore.fields.age_start') }}
                        </th>
                        <td>
                            {{ $pollAgeScore->age_start }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.pollAgeScore.fields.end_range') }}
                        </th>
                        <td>
                            {{ $pollAgeScore->end_range }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.pollAgeScore.fields.professional_levels') }}
                        </th>
                        <td>
                            @foreach($pollAgeScore->professional_levels as $key => $professional_levels)
                                <span class="badge badge-info">{{ $professional_levels->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a href="#" onclick="window.history.back();" class="btn btn-default float-right mb-2">{{ trans('global.back_to_list') }}</a>
            </div>
        </div>
    </div>
</div>



@endsection
