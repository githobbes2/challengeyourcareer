<aside class="main-sidebar sidebar-dark-primary elevation-4" style="min-height: 917px;">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <span class="brand-text font-weight-light">{{ trans('panel.site_title') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route("admin.home") }}">
                        <i class="fas fa-fw fa-tachometer-alt nav-icon">
                        </i>
                        <p>{{ trans('global.dashboard') }}</p>
                    </a>
                </li>
                @if(Auth::user()->is_consultant && !Auth::user()->is_admin)
                {{-- Menu CONSULTOR --}}

                @can('candidate_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.candidates.index") }}" class="nav-link {{ request()->is("admin/candidates") || request()->is("admin/candidates/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-users"></i>
                            <p>{{ trans('cruds.candidate.title') }}</p>
                        </a>
                    </li>
                @endcan
                @can('session_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.sessions.index") }}" class="nav-link {{ request()->is("admin/sessions") || request()->is("admin/sessions/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon far fa-calendar-check"></i>
                            <p>{{ trans('cruds.session.title') }}</p>
                        </a>
                    </li>
                @endcan
                @can('program_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.programs.index") }}" class="nav-link {{ request()->is("admin/programs") || request()->is("admin/programs/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-book-open"></i>
                            <p>{{ trans('cruds.program.title') }}</p>
                        </a>
                    </li>
                @endcan
                @can('event_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.events.index") }}" class="nav-link {{ request()->is("admin/events") || request()->is("admin/events/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-calendar-alt"></i>
                            <p>{{ trans('cruds.event.title') }}</p>
                        </a>
                    </li>
                @endcan
                @can('company_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.companies.index") }}" class="nav-link {{ request()->is("admin/companies") || request()->is("admin/companies/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon far fa-building"></i>
                            <p>{{ trans('cruds.company.title') }}</p>
                        </a>
                    </li>
                @endcan
                @can('job_offer_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.job-offers.index") }}" class="nav-link {{ request()->is("admin/job-offers") || request()->is("admin/job-offers/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-briefcase"></i>
                            <p>{{ trans('cruds.jobOffer.title') }}</p>
                        </a>
                    </li>
                @endcan

                @else
                {{-- Menu ADMIN --}}
                @can('user_management_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/consultants*") ? "menu-open" : "" }} {{ request()->is("admin/candidates*") ? "menu-open" : "" }} {{ request()->is("admin/users*") ? "menu-open" : "" }} {{ request()->is("admin/roles*") ? "menu-open" : "" }} {{ request()->is("admin/permissions*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="fa-fw nav-icon fas fa-users"></i>
                            <p>{{ trans('cruds.userManagement.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('consultant_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.consultants.index") }}" class="nav-link {{ request()->is("admin/consultants") || request()->is("admin/consultants/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-users">

                                        </i>
                                        <p>{{ trans('cruds.consultant.title') }}</p>
                                    </a>
                                </li>
                            @endcan
                            @can('candidate_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.candidates.index") }}" class="nav-link {{ request()->is("admin/candidates") || request()->is("admin/candidates/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-users">

                                        </i>
                                        <p>{{ trans('cruds.candidate.title') }}</p>
                                    </a>
                                </li>
                            @endcan
                            @can('user_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.users.index") }}" class="nav-link {{ request()->is("admin/users") || request()->is("admin/users/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-user">

                                        </i>
                                        <p>{{ trans('cruds.user.title') }}</p>
                                    </a>
                                </li>
                            @endcan
                            @can('role_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.roles.index") }}" class="nav-link {{ request()->is("admin/roles") || request()->is("admin/roles/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-briefcase">

                                        </i>
                                        <p>{{ trans('cruds.role.title') }}</p>
                                    </a>
                                </li>
                            @endcan
                            @can('permission_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.permissions.index") }}" class="nav-link {{ request()->is("admin/permissions") || request()->is("admin/permissions/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-unlock-alt">

                                        </i>
                                        <p>{{ trans('cruds.permission.title') }}</p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('program_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.programs.index") }}" class="nav-link {{ request()->is("admin/programs") || request()->is("admin/programs/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-book-open"></i>
                            <p>{{ trans('cruds.program.title') }}</p>
                        </a>
                    </li>
                @endcan
                @can('candidate_program_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.candidate-programs.index") }}" class="nav-link {{ request()->is("admin/candidate-programs") || request()->is("admin/candidate-programs/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-award"></i>
                            <p>{{ trans('cruds.candidateProgram.title') }}</p>
                        </a>
                    </li>
                @endcan
                @can('session_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.sessions.index") }}" class="nav-link {{ request()->is("admin/sessions") || request()->is("admin/sessions/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon far fa-calendar-check"></i>
                            <p>{{ trans('cruds.session.title') }}</p>
                        </a>
                    </li>
                @endcan
                @can('session_user_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.session-users.index") }}" class="nav-link {{ request()->is("admin/session-users") || request()->is("admin/session-users/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-users"></i>
                            <p>{{ trans('cruds.sessionUser.title') }}</p>
                        </a>
                    </li>
                @endcan
                @can('candidate_commitment_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.candidate-commitments.index") }}" class="nav-link {{ request()->is("admin/candidate-commitments") || request()->is("admin/candidate-commitments/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-check-double"></i>
                            <p>{{ trans('cruds.candidateCommitment.title') }}</p>
                        </a>
                    </li>
                @endcan
                @can('user_note_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.user-notes.index") }}" class="nav-link {{ request()->is("admin/user-notes") || request()->is("admin/user-notes/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon far fa-sticky-note"></i>
                            <p>{{ trans('cruds.userNote.title') }}</p>
                        </a>
                    </li>
                @endcan
                @can('candidate_service_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.candidate-services.index") }}" class="nav-link {{ request()->is("admin/candidate-services") || request()->is("admin/candidate-services/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-concierge-bell"></i>
                            <p>{{ trans('cruds.candidateService.title') }}</p>
                        </a>
                    </li>
                @endcan
                @can('event_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.events.index") }}" class="nav-link {{ request()->is("admin/events") || request()->is("admin/events/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-calendar-alt"></i>
                            <p>{{ trans('cruds.event.title') }}</p>
                        </a>
                    </li>
                @endcan
                @can('event_candidate_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.event-candidates.index") }}" class="nav-link {{ request()->is("admin/event-candidates") || request()->is("admin/event-candidates/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon far fa-calendar-check"></i>
                            <p>{{ trans('cruds.eventCandidate.title') }}</p>
                        </a>
                    </li>
                @endcan
                @can('job_offer_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.job-offers.index") }}" class="nav-link {{ request()->is("admin/job-offers") || request()->is("admin/job-offers/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-briefcase"></i>
                            <p>{{ trans('cruds.jobOffer.title') }}</p>
                        </a>
                    </li>
                @endcan
                @can('job_offer_candidate_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.job-offer-candidates.index") }}" class="nav-link {{ request()->is("admin/job-offer-candidates") || request()->is("admin/job-offer-candidates/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-user-md"></i>
                            <p>{{ trans('cruds.jobOfferCandidate.title') }}</p>
                        </a>
                    </li>
                @endcan
                @can('candidate_curriculum_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.candidate-curriculums.index") }}" class="nav-link {{ request()->is("admin/candidate-curriculums") || request()->is("admin/candidate-curriculums/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon far fa-file"></i>
                            <p>{{ trans('cruds.candidateCurriculum.title') }}</p>
                        </a>
                    </li>
                @endcan
                @can('company_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.companies.index") }}" class="nav-link {{ request()->is("admin/companies") || request()->is("admin/companies/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon far fa-building"></i>
                            <p>{{ trans('cruds.company.title') }}</p>
                        </a>
                    </li>
                @endcan
                @can('user_alert_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.user-alerts.index") }}" class="nav-link {{ request()->is("admin/user-alerts") || request()->is("admin/user-alerts/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-bell"></i>
                            <p>{{ trans('cruds.userAlert.title') }}</p>
                        </a>
                    </li>
                @endcan
                @can('cuestionario_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/polls*") ? "menu-open" : "" }} {{ request()->is("admin/question-groups*") ? "menu-open" : "" }} {{ request()->is("admin/questions*") ? "menu-open" : "" }} {{ request()->is("admin/poll-age-scores*") ? "menu-open" : "" }} {{ request()->is("admin/poll-language-scores*") ? "menu-open" : "" }} {{ request()->is("admin/poll-candidates*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="fa-fw nav-icon far fa-file-alt"></i>
                            <p>{{ trans('cruds.cuestionario.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('poll_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.polls.index") }}" class="nav-link {{ request()->is("admin/polls") || request()->is("admin/polls/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-list-ol">

                                        </i>
                                        <p>{{ trans('cruds.poll.title') }}</p>
                                    </a>
                                </li>
                            @endcan
                            @can('question_group_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.question-groups.index") }}" class="nav-link {{ request()->is("admin/question-groups") || request()->is("admin/question-groups/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-th">

                                        </i>
                                        <p>{{ trans('cruds.questionGroup.title') }}</p>
                                    </a>
                                </li>
                            @endcan
                            @can('question_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.questions.index") }}" class="nav-link {{ request()->is("admin/questions") || request()->is("admin/questions/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-question">

                                        </i>
                                        <p>{{ trans('cruds.question.title') }}</p>
                                    </a>
                                </li>
                            @endcan
                            @can('poll_age_score_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.poll-age-scores.index") }}" class="nav-link {{ request()->is("admin/poll-age-scores") || request()->is("admin/poll-age-scores/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-stopwatch">

                                        </i>
                                        <p>{{ trans('cruds.pollAgeScore.title') }}</p>
                                    </a>
                                </li>
                            @endcan
                            @can('poll_language_score_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.poll-language-scores.index") }}" class="nav-link {{ request()->is("admin/poll-language-scores") || request()->is("admin/poll-language-scores/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-language">

                                        </i>
                                        <p>{{ trans('cruds.pollLanguageScore.title') }}</p>
                                    </a>
                                </li>
                            @endcan
                            @can('poll_candidate_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.poll-candidates.index") }}" class="nav-link {{ request()->is("admin/poll-candidates") || request()->is("admin/poll-candidates/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon far fa-file-alt">

                                        </i>
                                        <p>{{ trans('cruds.pollCandidate.title') }}</p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('configuration_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/program-types*") ? "menu-open" : "" }} {{ request()->is("admin/service-groups*") ? "menu-open" : "" }} {{ request()->is("admin/service-items*") ? "menu-open" : "" }} {{ request()->is("admin/service-types*") ? "menu-open" : "" }} {{ request()->is("admin/session-types*") ? "menu-open" : "" }} {{ request()->is("admin/consultant-types*") ? "menu-open" : "" }} {{ request()->is("admin/recruiter-types*") ? "menu-open" : "" }} {{ request()->is("admin/countries*") ? "menu-open" : "" }} {{ request()->is("admin/states*") ? "menu-open" : "" }} {{ request()->is("admin/cities*") ? "menu-open" : "" }} {{ request()->is("admin/languages*") ? "menu-open" : "" }} {{ request()->is("admin/genders*") ? "menu-open" : "" }} {{ request()->is("admin/offices*") ? "menu-open" : "" }} {{ request()->is("admin/education-levels*") ? "menu-open" : "" }} {{ request()->is("admin/professional-levels*") ? "menu-open" : "" }} {{ request()->is("admin/functional-areas*") ? "menu-open" : "" }} {{ request()->is("admin/skills*") ? "menu-open" : "" }} {{ request()->is("admin/industry-sectors*") ? "menu-open" : "" }} {{ request()->is("admin/skill-tags*") ? "menu-open" : "" }} {{ request()->is("admin/candidate-tags*") ? "menu-open" : "" }} {{ request()->is("admin/job-offer-tags*") ? "menu-open" : "" }} {{ request()->is("admin/candidate-program-tags*") ? "menu-open" : "" }} {{ request()->is("admin/commitment-tags*") ? "menu-open" : "" }} {{ request()->is("admin/user-note-tags*") ? "menu-open" : "" }} {{ request()->is("admin/audit-logs*") ? "menu-open" : "" }} {{ request()->is("admin/session-templates*") ? "menu-open" : "" }} {{ request()->is("admin/development-areas*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="fa-fw nav-icon fas fa-cogs"></i>
                            <p>{{ trans('cruds.configuration.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('program_type_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.program-types.index") }}" class="nav-link {{ request()->is("admin/program-types") || request()->is("admin/program-types/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-list-ul">

                                        </i>
                                        <p>{{ trans('cruds.programType.title') }}</p>
                                    </a>
                                </li>
                            @endcan
                            @can('service_group_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.service-groups.index") }}" class="nav-link {{ request()->is("admin/service-groups") || request()->is("admin/service-groups/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-concierge-bell">

                                        </i>
                                        <p>{{ trans('cruds.serviceGroup.title') }}</p>
                                    </a>
                                </li>
                            @endcan
                            @can('service_item_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.service-items.index") }}" class="nav-link {{ request()->is("admin/service-items") || request()->is("admin/service-items/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-list">

                                        </i>
                                        <p>{{ trans('cruds.serviceItem.title') }}</p>
                                    </a>
                                </li>
                            @endcan
                            @can('service_type_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.service-types.index") }}" class="nav-link {{ request()->is("admin/service-types") || request()->is("admin/service-types/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-list">

                                        </i>
                                        <p>{{ trans('cruds.serviceType.title') }}</p>
                                    </a>
                                </li>
                            @endcan
                            @can('session_type_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.session-types.index") }}" class="nav-link {{ request()->is("admin/session-types") || request()->is("admin/session-types/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-list-ul">

                                        </i>
                                        <p>{{ trans('cruds.sessionType.title') }}</p>
                                    </a>
                                </li>
                            @endcan
                            @can('consultant_type_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.consultant-types.index") }}" class="nav-link {{ request()->is("admin/consultant-types") || request()->is("admin/consultant-types/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-list-ul">

                                        </i>
                                        <p>{{ trans('cruds.consultantType.title') }}</p>
                                    </a>
                                </li>
                            @endcan
                            @can('recruiter_type_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.recruiter-types.index") }}" class="nav-link {{ request()->is("admin/recruiter-types") || request()->is("admin/recruiter-types/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-users">

                                        </i>
                                        <p>{{ trans('cruds.recruiterType.title') }}</p>
                                    </a>
                                </li>
                            @endcan
                            @can('country_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.countries.index") }}" class="nav-link {{ request()->is("admin/countries") || request()->is("admin/countries/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-flag">

                                        </i>
                                        <p>{{ trans('cruds.country.title') }}</p>
                                    </a>
                                </li>
                            @endcan
                            @can('state_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.states.index") }}" class="nav-link {{ request()->is("admin/states") || request()->is("admin/states/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-globe-americas">

                                        </i>
                                        <p>{{ trans('cruds.state.title') }}</p>
                                    </a>
                                </li>
                            @endcan
                            @can('city_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.cities.index") }}" class="nav-link {{ request()->is("admin/cities") || request()->is("admin/cities/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-cogs">

                                        </i>
                                        <p>{{ trans('cruds.city.title') }}</p>
                                    </a>
                                </li>
                            @endcan
                            @can('language_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.languages.index") }}" class="nav-link {{ request()->is("admin/languages") || request()->is("admin/languages/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-language">

                                        </i>
                                        <p>{{ trans('cruds.language.title') }}</p>
                                    </a>
                                </li>
                            @endcan
                            @can('gender_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.genders.index") }}" class="nav-link {{ request()->is("admin/genders") || request()->is("admin/genders/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-list-ul">

                                        </i>
                                        <p>{{ trans('cruds.gender.title') }}</p>
                                    </a>
                                </li>
                            @endcan
                            @can('office_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.offices.index") }}" class="nav-link {{ request()->is("admin/offices") || request()->is("admin/offices/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon far fa-building">

                                        </i>
                                        <p>{{ trans('cruds.office.title') }}</p>
                                    </a>
                                </li>
                            @endcan
                            @can('education_level_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.education-levels.index") }}" class="nav-link {{ request()->is("admin/education-levels") || request()->is("admin/education-levels/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-graduation-cap">

                                        </i>
                                        <p>{{ trans('cruds.educationLevel.title') }}</p>
                                    </a>
                                </li>
                            @endcan
                            @can('professional_level_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.professional-levels.index") }}" class="nav-link {{ request()->is("admin/professional-levels") || request()->is("admin/professional-levels/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-user-tie">

                                        </i>
                                        <p>{{ trans('cruds.professionalLevel.title') }}</p>
                                    </a>
                                </li>
                            @endcan
                            @can('functional_area_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.functional-areas.index") }}" class="nav-link {{ request()->is("admin/functional-areas") || request()->is("admin/functional-areas/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-puzzle-piece">

                                        </i>
                                        <p>{{ trans('cruds.functionalArea.title') }}</p>
                                    </a>
                                </li>
                            @endcan
                            @can('skill_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.skills.index") }}" class="nav-link {{ request()->is("admin/skills") || request()->is("admin/skills/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-wrench">

                                        </i>
                                        <p>{{ trans('cruds.skill.title') }}</p>
                                    </a>
                                </li>
                            @endcan
                            @can('industry_sector_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.industry-sectors.index") }}" class="nav-link {{ request()->is("admin/industry-sectors") || request()->is("admin/industry-sectors/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-industry">

                                        </i>
                                        <p>{{ trans('cruds.industrySector.title') }}</p>
                                    </a>
                                </li>
                            @endcan
                            @can('skill_tag_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.skill-tags.index") }}" class="nav-link {{ request()->is("admin/skill-tags") || request()->is("admin/skill-tags/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-tags">

                                        </i>
                                        <p>{{ trans('cruds.skillTag.title') }}</p>
                                    </a>
                                </li>
                            @endcan
                            @can('candidate_tag_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.candidate-tags.index") }}" class="nav-link {{ request()->is("admin/candidate-tags") || request()->is("admin/candidate-tags/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-tags">

                                        </i>
                                        <p>{{ trans('cruds.candidateTag.title') }}</p>
                                    </a>
                                </li>
                            @endcan
                            @can('job_offer_tag_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.job-offer-tags.index") }}" class="nav-link {{ request()->is("admin/job-offer-tags") || request()->is("admin/job-offer-tags/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-tags">

                                        </i>
                                        <p>{{ trans('cruds.jobOfferTag.title') }}</p>
                                    </a>
                                </li>
                            @endcan
                            @can('candidate_program_tag_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.candidate-program-tags.index") }}" class="nav-link {{ request()->is("admin/candidate-program-tags") || request()->is("admin/candidate-program-tags/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-tags">

                                        </i>
                                        <p>{{ trans('cruds.candidateProgramTag.title') }}</p>
                                    </a>
                                </li>
                            @endcan
                            @can('commitment_tag_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.commitment-tags.index") }}" class="nav-link {{ request()->is("admin/commitment-tags") || request()->is("admin/commitment-tags/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-tags">

                                        </i>
                                        <p>{{ trans('cruds.commitmentTag.title') }}</p>
                                    </a>
                                </li>
                            @endcan
                            @can('user_note_tag_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.user-note-tags.index") }}" class="nav-link {{ request()->is("admin/user-note-tags") || request()->is("admin/user-note-tags/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-tags">

                                        </i>
                                        <p>{{ trans('cruds.userNoteTag.title') }}</p>
                                    </a>
                                </li>
                            @endcan
                            @can('audit_log_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.audit-logs.index") }}" class="nav-link {{ request()->is("admin/audit-logs") || request()->is("admin/audit-logs/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-file-alt">

                                        </i>
                                        <p>{{ trans('cruds.auditLog.title') }}</p>
                                    </a>
                                </li>
                            @endcan
                            @can('session_template_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.session-templates.index") }}" class="nav-link {{ request()->is("admin/session-templates") || request()->is("admin/session-templates/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon far fa-calendar-check">

                                        </i>
                                        <p>{{ trans('cruds.sessionTemplate.title') }}</p>
                                    </a>
                                </li>
                            @endcan
                            @can('development_area_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.development-areas.index") }}" class="nav-link {{ request()->is("admin/development-areas") || request()->is("admin/development-areas/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-graduation-cap">

                                        </i>
                                        <p>{{ trans('cruds.developmentArea.title') }}</p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @endif

                <li class="nav-item">
                    <a href="{{ route("admin.systemCalendar") }}" class="nav-link {{ request()->is("admin/system-calendar") || request()->is("admin/system-calendar/*") ? "active" : "" }}">
                        <i class="fas fa-fw fa-calendar nav-icon">

                        </i>
                        <p>{{ trans('global.systemCalendar') }}</p>
                    </a>
                </li>
                @php($unread = \App\Models\QaTopic::unreadCount())
                <li class="nav-item">
                    <a href="{{ route("admin.messenger.index") }}" class="{{ request()->is("admin/messenger") || request()->is("admin/messenger/*") ? "active" : "" }} nav-link">
                        <i class="fa-fw fa fa-envelope nav-icon {{ $unread > 0 ? 'text-warning' : '' }}">

                        </i>
                        <p>{{ trans('global.messages') }}</p>
                        @if($unread > 0)
                            <strong>( {{ $unread }} )</strong>
                        @endif

                    </a>
                </li>
                @if(file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')))
                    @can('profile_password_edit')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('profile/password') || request()->is('profile/password/*') ? 'active' : '' }}" href="{{ route('profile.password.edit') }}">
                                <i class="fa-fw fas fa-key nav-icon">
                                </i>
                                <p>
                                    {{ trans('global.change_password') }}
                                </p>
                            </a>
                        </li>
                    @endcan
                @endif
                <li class="nav-item">
                    <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                        <p>
                            <i class="fas fa-fw fa-sign-out-alt nav-icon"></i>
                            <p>{{ trans('global.logout') }}</p>
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
