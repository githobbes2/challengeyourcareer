@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.commitmentTag.title') }}
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
                            {{ trans('cruds.commitmentTag.fields.name') }}
                        </th>
                        <td>
                            {{ $commitmentTag->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.commitmentTag.fields.color') }}
                        </th>
                        <td>
                            {{ App\Models\CommitmentTag::COLOR_RADIO[$commitmentTag->color] ?? '' }}
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
