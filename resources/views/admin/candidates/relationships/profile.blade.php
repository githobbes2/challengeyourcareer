<div class="row">
    <div class="col-lg-4">
        <div class="card mb-3">
            <div class="card-body text-center">
                <img src="{{ $candidate->user->photo_default->preview }}" class="rounded-circle img-fluid" style="width: 150px;">
                <h5 class="my-1">{{ $candidate->full_name }}</h5>
                <p class="text-muted mb-3">{{ $candidate->company->name ?? '' }}</p>
                <h6 class="mb-1">{{ $candidate->program->name ?? '' }}</h6>
                <p class="text-muted mb-4">
                    @if($candidate->employability_score)
                    {{ trans('cruds.candidate.fields.employability_score') }}: {{ $candidate->employability_score }} <span class="small">({{ $candidate->employability_score_date }})</span>
                    @else
                    <em>{{ trans('cruds.candidate.fields.no_employability_score') }}</em>
                    @endif
                </p>
                <div class="row">
                    <div class="col-12">
                        <a href="{{ route('admin.candidates.dossier', [$candidate]) }}" class="btn btn-outline-primary ms-1 ml-2 float-right">{{ trans('global.dossier') }}</a>
                        <button type="button" class="btn btn-outline-primary ms-1 float-right">{{ trans('global.message') }}</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-4 mb-lg-0">
            <div class="card-header">
                <h4 class="mb-0">{{ trans('cruds.candidate.cards.personal') }}</h4>
            </div>
            <div class="card-body">

                <p class="mb-1" style="font-size: .77rem;">{{ trans('cruds.candidate.fields.gender') }}</p>
                <p class="text-muted mb-0">{{ $candidate->gender->name ?? '' }}</p>
                <hr>
                <p class="mb-1" style="font-size: .77rem;">{{ trans('cruds.user.fields.birthday') }}</p>
                <p class="text-muted mb-0">{{ $candidate->user->birthday }}</p>
                <hr>
                <p class="text-muted mb-0"><input type="checkbox" disabled="disabled" {{ $candidate->disability ? 'checked' : '' }}> {{ trans('cruds.candidate.fields.disability') }}</p>
                <p class="text-muted mb-0"><input type="checkbox" disabled="disabled" {{ $candidate->immigrant ? 'checked' : '' }}> {{ trans('cruds.candidate.fields.immigrant') }}</p>
                <hr>
                <p class="mb-1" style="font-size: .77rem;">{{ trans('cruds.user.fields.phone') }}</p>
                <p class="text-muted mb-0">{{ $candidate->user->phone }}</p>
                <hr>
                <p class="mb-1" style="font-size: .77rem;">{{ trans('cruds.candidate.fields.city') }}</p>
                <p class="text-muted mb-0">{{ $candidate->city->name ?? '' }}</p>
                <hr>
                <p class="mb-1" style="font-size: .77rem;">{{ trans('cruds.candidate.fields.address') }}</p>
                <p class="text-muted mb-0">{{ $candidate->address }}</p>
                <hr>
                <p class="mb-1" style="font-size: .77rem;">{{ trans('cruds.candidate.fields.postalcode') }}</p>
                <p class="text-muted mb-0">{{ $candidate->postalcode }}</p>
                <hr>
                <p class="mb-1" style="font-size: .77rem;">{{ trans('cruds.user.fields.government_number') }}</p>
                <p class="text-muted mb-0">{{ $candidate->user->government_number }}</p>
                <hr>
                <p class="mb-1" style="font-size: .77rem;">{{ trans('cruds.user.fields.passport') }}</p>
                <p class="text-muted mb-0">{{ $candidate->user->passport }}</p>
                <hr>
                <p class="mb-1" style="font-size: .77rem;">{{ trans('cruds.user.fields.language') }}</p>
                @foreach($candidate->user->languages as $key => $language)
                <span class="badge badge-info">{{ $language->name }}</span>
                @endforeach
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-3">
                        <p class="mb-0">{{ trans('cruds.user.fields.name') }}</p>
                    </div>
                    <div class="col-sm-9">
                        <p class="text-muted mb-0">{{ $candidate->full_name ?? '' }}</p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <p class="mb-0">{{ trans('cruds.candidate.fields.company') }}</p>
                    </div>
                    <div class="col-sm-9">
                        <a href="{{ route('admin.companies.show', $candidate->company->id) }}" class="btn btn-sm btn-outline-primary float-right">{{ trans('global.details') }}</a>
                        <p class="text-muted mb-0">{{ $candidate->company->name ?? '' }}</p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <p class="mb-0">{{ trans('cruds.candidateProgram.fields.program') }}</p>
                    </div>
                    <div class="col-sm-9">
                        @if($candidate->program)
                        <a href="{{ route('admin.programs.show', $candidate->program->id) }}" class="btn btn-sm btn-outline-primary float-right">{{ trans('global.details') }}</a>
                        <p class="text-muted mb-0">{{ $candidate->program->name ?? '' }}</p>
                        @else
                        <a href="{{ route('admin.candidate-programs.create', ['programID'=>0, 'candidateID'=>$candidate->id]) }}" class="btn btn-sm btn-success float-right">{{ __('Enroll in program') }}</a>
                        <p class="text-muted mb-0">{{ trans('cruds.candidate.program_null') }}</p>
                        @endif
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <p class="mb-0">{{ trans('cruds.user.fields.email') }}</p>
                    </div>
                    <div class="col-sm-9">
                        <p class="text-muted mb-0">{{ $candidate->user->email ?? '' }}</p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <p class="mb-0">{{ trans('cruds.user.fields.system_language') }}</p>
                    </div>
                    <div class="col-sm-9">
                        <p class="text-muted mb-0">{{ $candidate->user->system_language->name ?? '- ' .trans('global.defaultLanguage').' -' }}</p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <p class="mb-0">{{ trans('cruds.user.fields.last_login') }}</p>
                    </div>
                    <div class="col-sm-9">
                        <p class="text-muted mb-0">{{ $candidate->user->last_login ?? trans('cruds.user.fields.last_login_null') }}</p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-12">
                        <p class="mb-0"><input type="checkbox" class="mr-1" disabled="disabled" {{ $candidate->challenge_card ? 'checked' : '' }}> {{ trans('global.challenge_card_linked') }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="card mb-4 mb-md-0">
                    <div class="card-header">
                        <h4 class="mb-0">{{ trans('cruds.candidate.cards.professional') }}</h4>
                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">{{ trans('cruds.candidate.fields.profile') }}</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">{!! $candidate->profile !!}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">{{ trans('cruds.candidate.fields.tag') }}</p>
                            </div>
                            <div class="col-sm-9">
                                @foreach($candidate->tags as $key => $tag)
                                <span class="badge badge-info">{{ $tag->name }}</span>
                                @endforeach
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">{{ trans('cruds.candidate.fields.position') }}</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">{{ $candidate->position }}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">{{ trans('cruds.candidate.fields.target_companies') }}</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">{!! nl2br($candidate->target_companies) !!}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">{{ trans('cruds.user.fields.social_linkedin') }}</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">{{ $candidate->user->social_linkedin }}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">{{ trans('cruds.candidate.fields.education_level') }}</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">{{ $candidate->education_level->name ?? '' }}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">{{ trans('cruds.candidate.fields.professional_level') }}</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">{{ $candidate->professional_level->name ?? '' }}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">{{ trans('cruds.candidate.fields.functional_area') }}</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">{{ $candidate->functional_area->name ?? '' }}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">{{ trans('cruds.candidate.fields.skill') }}</p>
                            </div>
                            <div class="col-sm-9">
                                @foreach($candidate->skills as $key => $skill)
                                <span class="badge badge-info">{{ $skill->name }}</span>
                                @endforeach
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">{{ trans('cruds.candidate.fields.industry_sector') }}</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">{{ $candidate->industry_sector->name ?? '' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row mt-3">
        <div class="col">
            <div class="card">
                <div class="card-body pt-3 pb-2">
                    @can('candidate_delete')
                    <form action="{{ route('admin.candidates.destroy', $candidate->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;" autocomplete="0">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="submit" class="btn btn-danger" value="{{ trans('global.delete') }}">
                    </form>
                    @endcan
                    @can('candidate_edit')
                    <a class="btn btn-info float-right ml-1" href="{{ route('admin.candidates.edit', $candidate->id) }}">{{ trans('global.edit') }}</a>
                    @endcan
                    <a href="#" onclick="window.history.back();" class="btn btn-default float-right mb-2">{{ trans('global.back_to_list') }}</a>
                </div>
            </div>
        </div>
    </div>
