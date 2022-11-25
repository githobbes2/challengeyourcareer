@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.userNote.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                @can('user_note_edit')
                <a class="btn btn-info float-right ml-1" href="{{ route('admin.user-notes.edit', $userNote->id) }}">{{ trans('global.edit') }}</a>
                @endcan
                <a href="#" onclick="window.history.back();" class="btn btn-default float-right mb-2">{{ trans('global.back_to_list') }}</a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th width="180">{{ trans('cruds.userNote.fields.user') }}</th>
                        <td>{{ $userNote->user->name ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.userNote.fields.title') }}</th>
                        <td>{{ $userNote->title }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.userNote.fields.session_user') }}</th>
                        <td>{{ $userNote->session_user->session->title ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.userNote.fields.tag') }}</th>
                        <td>
                            @foreach($userNote->tags as $key => $tag)
                                <span class="badge badge-info">{{ $tag->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.userNote.fields.note') }}</th>
                        <td>{{ $userNote->note }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.userNote.fields.notes') }}</th>
                        <td>{{ $userNote->notes }}</td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                @can('user_note_edit')
                <a class="btn btn-info float-right ml-1" href="{{ route('admin.user-notes.edit', $userNote->id) }}">{{ trans('global.edit') }}</a>
                @endcan
                <a href="#" onclick="window.history.back();" class="btn btn-default float-right mb-2">{{ trans('global.back_to_list') }}</a>
            </div>
        </div>
    </div>
</div>



@endsection
