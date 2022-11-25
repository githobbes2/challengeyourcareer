<?php

Route::redirect('/', '/login');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    //Reports
    Route::get('/reports', 'ReportsController@index')->name('reports.index');

    //Candidate Screens
    Route::get('/program/{id?}', 'CandidateAppController@program')->name('candidate.program.show');
    Route::get('/poll/{id?}', 'CandidateAppController@polls')->name('candidate.poll.show');

    Route::get('/session/{id}', 'CandidateAppController@session')->name('candidate.session.show');
    Route::post('/session/{SessionUser}/update', 'CandidateAppController@sessionUpdate')->name('candidate.session.update');
    Route::post('/session/{SessionUser}/evaluate', 'CandidateAppController@sessionEvaluate')->name('candidate.session.evaluate');

    Route::get('/commitment/{candidateCommitment}', 'CandidateAppController@commitment')->name('candidate.commitment.show');

    Route::get('/opportunities', 'CandidateAppController@opportunities')->name('candidate.opportunities.show');
    Route::get('/analytics', 'CandidateAppController@analytics')->name('candidate.analytics.show');
    Route::get('/calendar', 'SystemCalendarController@index')->name('candidate.calendar.show');
    Route::get('/messages', 'MessengerController@index')->name('candidate.messages.show');
    Route::get('/profile', 'CandidateAppController@profile')->name('candidate.profile.show');
    Route::put('/profile/update/{candidate}', 'CandidateAppController@profileUpdate')->name('candidate.profile.update');
    Route::get('/event/{event}', 'CandidateAppController@event')->name('candidate.event.show');


    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::post('users/media', 'UsersController@storeMedia')->name('users.storeMedia');
    Route::post('users/ckmedia', 'UsersController@storeCKEditorImages')->name('users.storeCKEditorImages');
    Route::post('users/parse-csv-import', 'UsersController@parseCsvImport')->name('users.parseCsvImport');
    Route::post('users/process-csv-import', 'UsersController@processCsvImport')->name('users.processCsvImport');
    Route::resource('users', 'UsersController');

    // Audit Logs
    Route::resource('audit-logs', 'AuditLogsController', ['except' => ['create', 'store', 'edit', 'update', 'destroy']]);

    // User Alerts
    Route::delete('user-alerts/destroy', 'UserAlertsController@massDestroy')->name('user-alerts.massDestroy');
    Route::get('user-alerts/read', 'UserAlertsController@read');
    Route::resource('user-alerts', 'UserAlertsController', ['except' => ['edit', 'update']]);

    // Program
    Route::delete('programs/destroy', 'ProgramController@massDestroy')->name('programs.massDestroy');
    Route::post('programs/media', 'ProgramController@storeMedia')->name('programs.storeMedia');
    Route::post('programs/ckmedia', 'ProgramController@storeCKEditorImages')->name('programs.storeCKEditorImages');
    Route::resource('programs', 'ProgramController');
    Route::get('programs/{program}/dossier', 'ProgramController@getDossier')->name('programs.dossier');
    Route::post('programs/{program}/dossier-pdf', 'ProgramController@exportDossier')->name('programs.dossier-pdf');

    // Program Type
    Route::delete('program-types/destroy', 'ProgramTypeController@massDestroy')->name('program-types.massDestroy');
    Route::resource('program-types', 'ProgramTypeController');

    // Countries
    Route::delete('countries/destroy', 'CountriesController@massDestroy')->name('countries.massDestroy');
    Route::resource('countries', 'CountriesController');

    // States
    Route::delete('states/destroy', 'StatesController@massDestroy')->name('states.massDestroy');
    Route::resource('states', 'StatesController');

    // City
    Route::delete('cities/destroy', 'CityController@massDestroy')->name('cities.massDestroy');
    Route::resource('cities', 'CityController');

    // Company
    Route::delete('companies/destroy', 'CompanyController@massDestroy')->name('companies.massDestroy');
    Route::post('companies/media', 'CompanyController@storeMedia')->name('companies.storeMedia');
    Route::post('companies/ckmedia', 'CompanyController@storeCKEditorImages')->name('companies.storeCKEditorImages');
    Route::resource('companies', 'CompanyController');

    // Session
    Route::delete('sessions/destroy', 'SessionController@massDestroy')->name('sessions.massDestroy');
    Route::post('sessions/media', 'SessionController@storeMedia')->name('sessions.storeMedia');
    Route::post('sessions/ckmedia', 'SessionController@storeCKEditorImages')->name('sessions.storeCKEditorImages');
    Route::post('sessions/add-candidates', 'SessionController@addCandidates')->name('sessions.add-candidates');
    Route::get('sessions/create/{programID?}', 'SessionController@create')->name('sessions.create');
    Route::resource('sessions', 'SessionController')->except(['create']);

    // Session Type
    Route::delete('session-types/destroy', 'SessionTypeController@massDestroy')->name('session-types.massDestroy');
    Route::resource('session-types', 'SessionTypeController');

    // Session User
    Route::delete('session-users/destroy', 'SessionUserController@massDestroy')->name('session-users.massDestroy');
    Route::post('session-users/media', 'SessionUserController@storeMedia')->name('session-users.storeMedia');
    Route::post('session-users/ckmedia', 'SessionUserController@storeCKEditorImages')->name('session-users.storeCKEditorImages');
    Route::resource('session-users', 'SessionUserController');
    Route::get('session-users/{session}/{user}', 'SessionUserController@showNew')->name('session-users.show-new');
    Route::get('session-users/edit/{session}/{user}', 'SessionUserController@editNew')->name('session-users.edit-new');

    // Language
    Route::delete('languages/destroy', 'LanguageController@massDestroy')->name('languages.massDestroy');
    Route::post('languages/parse-csv-import', 'LanguageController@parseCsvImport')->name('languages.parseCsvImport');
    Route::post('languages/process-csv-import', 'LanguageController@processCsvImport')->name('languages.processCsvImport');
    Route::resource('languages', 'LanguageController');

    // Consultant Type
    Route::delete('consultant-types/destroy', 'ConsultantTypeController@massDestroy')->name('consultant-types.massDestroy');
    Route::resource('consultant-types', 'ConsultantTypeController');

    // Job Offer
    Route::delete('job-offers/destroy', 'JobOfferController@massDestroy')->name('job-offers.massDestroy');
    Route::post('job-offers/media', 'JobOfferController@storeMedia')->name('job-offers.storeMedia');
    Route::post('job-offers/ckmedia', 'JobOfferController@storeCKEditorImages')->name('job-offers.storeCKEditorImages');
    Route::post('job-offers/parse-csv-import', 'JobOfferController@parseCsvImport')->name('job-offers.parseCsvImport');
    Route::post('job-offers/process-csv-import', 'JobOfferController@processCsvImport')->name('job-offers.processCsvImport');
    Route::resource('job-offers', 'JobOfferController');

    // Recruiter Type
    Route::delete('recruiter-types/destroy', 'RecruiterTypeController@massDestroy')->name('recruiter-types.massDestroy');
    Route::resource('recruiter-types', 'RecruiterTypeController');

    // Education Level
    Route::delete('education-levels/destroy', 'EducationLevelController@massDestroy')->name('education-levels.massDestroy');
    Route::resource('education-levels', 'EducationLevelController');

    // Professional Level
    Route::delete('professional-levels/destroy', 'ProfessionalLevelController@massDestroy')->name('professional-levels.massDestroy');
    Route::resource('professional-levels', 'ProfessionalLevelController');

    // Functional Area
    Route::delete('functional-areas/destroy', 'FunctionalAreaController@massDestroy')->name('functional-areas.massDestroy');
    Route::resource('functional-areas', 'FunctionalAreaController');

    // Skill
    Route::delete('skills/destroy', 'SkillController@massDestroy')->name('skills.massDestroy');
    Route::resource('skills', 'SkillController');

    // Industry Sector
    Route::delete('industry-sectors/destroy', 'IndustrySectorController@massDestroy')->name('industry-sectors.massDestroy');
    Route::resource('industry-sectors', 'IndustrySectorController');

    // Office
    Route::delete('offices/destroy', 'OfficeController@massDestroy')->name('offices.massDestroy');
    Route::resource('offices', 'OfficeController');

    // Consultant
    Route::delete('consultants/destroy', 'ConsultantController@massDestroy')->name('consultants.massDestroy');
    Route::post('consultants/media', 'ConsultantController@storeMedia')->name('consultants.storeMedia');
    Route::post('consultants/ckmedia', 'ConsultantController@storeCKEditorImages')->name('consultants.storeCKEditorImages');
    Route::resource('consultants', 'ConsultantController');

    // Candidate
    Route::delete('candidates/destroy', 'CandidateController@massDestroy')->name('candidates.massDestroy');
    Route::post('candidates/media', 'CandidateController@storeMedia')->name('candidates.storeMedia');
    Route::post('candidates/ckmedia', 'CandidateController@storeCKEditorImages')->name('candidates.storeCKEditorImages');
    Route::resource('candidates', 'CandidateController');
    Route::get('candidates/{candidate}/dossier', 'CandidateController@getDossier')->name('candidates.dossier');
    Route::post('candidates/{candidate}/dossier-pdf', 'CandidateController@exportDossier')->name('candidates.dossier-pdf');

    // Gender
    Route::delete('genders/destroy', 'GenderController@massDestroy')->name('genders.massDestroy');
    Route::resource('genders', 'GenderController');

    // Candidate Tag
    Route::delete('candidate-tags/destroy', 'CandidateTagController@massDestroy')->name('candidate-tags.massDestroy');
    Route::resource('candidate-tags', 'CandidateTagController');

    // Job Offer Tag
    Route::delete('job-offer-tags/destroy', 'JobOfferTagController@massDestroy')->name('job-offer-tags.massDestroy');
    Route::resource('job-offer-tags', 'JobOfferTagController');

    // Candidate Program
    Route::delete('candidate-programs/destroy', 'CandidateProgramController@massDestroy')->name('candidate-programs.massDestroy');
    Route::get('candidate-programs/create/{programID?}/{candidateID?}', 'CandidateProgramController@create')->name('candidate-programs.create');
    Route::resource('candidate-programs', 'CandidateProgramController')->except(['create']);

    // Candidate Program Tag
    Route::delete('candidate-program-tags/destroy', 'CandidateProgramTagController@massDestroy')->name('candidate-program-tags.massDestroy');
    Route::resource('candidate-program-tags', 'CandidateProgramTagController');

    // Candidate Commitment
    Route::delete('candidate-commitments/destroy', 'CandidateCommitmentController@massDestroy')->name('candidate-commitments.massDestroy');
    Route::resource('candidate-commitments', 'CandidateCommitmentController');

    // Commitment Tag
    Route::delete('commitment-tags/destroy', 'CommitmentTagController@massDestroy')->name('commitment-tags.massDestroy');
    Route::resource('commitment-tags', 'CommitmentTagController');

    // User Note Tag
    Route::delete('user-note-tags/destroy', 'UserNoteTagController@massDestroy')->name('user-note-tags.massDestroy');
    Route::resource('user-note-tags', 'UserNoteTagController');

    // User Note
    Route::delete('user-notes/destroy', 'UserNoteController@massDestroy')->name('user-notes.massDestroy');
    Route::resource('user-notes', 'UserNoteController');

    // Service Item
    Route::delete('service-items/destroy', 'ServiceItemController@massDestroy')->name('service-items.massDestroy');
    Route::post('service-items/parse-csv-import', 'ServiceItemController@parseCsvImport')->name('service-items.parseCsvImport');
    Route::post('service-items/process-csv-import', 'ServiceItemController@processCsvImport')->name('service-items.processCsvImport');
    Route::resource('service-items', 'ServiceItemController');

    // Service Type
    Route::delete('service-types/destroy', 'ServiceTypeController@massDestroy')->name('service-types.massDestroy');
    Route::resource('service-types', 'ServiceTypeController');

    // Service Group
    Route::delete('service-groups/destroy', 'ServiceGroupController@massDestroy')->name('service-groups.massDestroy');
    Route::resource('service-groups', 'ServiceGroupController');

    // Candidate Service
    Route::delete('candidate-services/destroy', 'CandidateServiceController@massDestroy')->name('candidate-services.massDestroy');
    Route::resource('candidate-services', 'CandidateServiceController');

    // Event
    Route::delete('events/destroy', 'EventController@massDestroy')->name('events.massDestroy');
    Route::post('events/media', 'EventController@storeMedia')->name('events.storeMedia');
    Route::post('events/ckmedia', 'EventController@storeCKEditorImages')->name('events.storeCKEditorImages');
    Route::resource('events', 'EventController');
    Route::post('events/{event}/attendance', 'EventController@updateAttendance')->name('events.updateAttendance');

    // Poll
    Route::delete('polls/destroy', 'PollController@massDestroy')->name('polls.massDestroy');
    Route::resource('polls', 'PollController');

    // Question Group
    Route::delete('question-groups/destroy', 'QuestionGroupController@massDestroy')->name('question-groups.massDestroy');
    Route::resource('question-groups', 'QuestionGroupController');

    // Question
    Route::delete('questions/destroy', 'QuestionController@massDestroy')->name('questions.massDestroy');
    Route::resource('questions', 'QuestionController');

    // Poll Age Score
    Route::delete('poll-age-scores/destroy', 'PollAgeScoreController@massDestroy')->name('poll-age-scores.massDestroy');
    Route::resource('poll-age-scores', 'PollAgeScoreController');

    // Poll Language Score
    Route::delete('poll-language-scores/destroy', 'PollLanguageScoreController@massDestroy')->name('poll-language-scores.massDestroy');
    Route::resource('poll-language-scores', 'PollLanguageScoreController');

    // Skill Tags
    Route::delete('skill-tags/destroy', 'SkillTagsController@massDestroy')->name('skill-tags.massDestroy');
    Route::resource('skill-tags', 'SkillTagsController');

    // Session Template
    Route::delete('session-templates/destroy', 'SessionTemplateController@massDestroy')->name('session-templates.massDestroy');
    Route::resource('session-templates', 'SessionTemplateController');

    // Job Offer Candidate
    Route::delete('job-offer-candidates/destroy', 'JobOfferCandidateController@massDestroy')->name('job-offer-candidates.massDestroy');
    Route::resource('job-offer-candidates', 'JobOfferCandidateController');

    // Development Areas
    Route::delete('development-areas/destroy', 'DevelopmentAreasController@massDestroy')->name('development-areas.massDestroy');
    Route::resource('development-areas', 'DevelopmentAreasController');

    // Event Candidate
    Route::delete('event-candidates/destroy', 'EventCandidateController@massDestroy')->name('event-candidates.massDestroy');
    Route::resource('event-candidates', 'EventCandidateController');

    // Poll Candidate
    Route::delete('poll-candidates/destroy', 'PollCandidateController@massDestroy')->name('poll-candidates.massDestroy');
    Route::resource('poll-candidates', 'PollCandidateController');

    // Candidate Curriculum
    Route::delete('candidate-curriculums/destroy', 'CandidateCurriculumController@massDestroy')->name('candidate-curriculums.massDestroy');
    Route::post('candidate-curriculums/media', 'CandidateCurriculumController@storeMedia')->name('candidate-curriculums.storeMedia');
    Route::post('candidate-curriculums/ckmedia', 'CandidateCurriculumController@storeCKEditorImages')->name('candidate-curriculums.storeCKEditorImages');
    Route::resource('candidate-curriculums', 'CandidateCurriculumController');

    Route::get('system-calendar', 'SystemCalendarController@index')->name('systemCalendar');
    Route::get('messenger', 'MessengerController@index')->name('messenger.index');
    Route::get('messenger/create', 'MessengerController@createTopic')->name('messenger.createTopic');
    Route::post('messenger', 'MessengerController@storeTopic')->name('messenger.storeTopic');
    Route::get('messenger/inbox', 'MessengerController@showInbox')->name('messenger.showInbox');
    Route::get('messenger/outbox', 'MessengerController@showOutbox')->name('messenger.showOutbox');
    Route::get('messenger/{topic}', 'MessengerController@showMessages')->name('messenger.showMessages');
    Route::delete('messenger/{topic}', 'MessengerController@destroyTopic')->name('messenger.destroyTopic');
    Route::post('messenger/{topic}/reply', 'MessengerController@replyToTopic')->name('messenger.reply');
    Route::get('messenger/{topic}/reply', 'MessengerController@showReply')->name('messenger.showReply');
});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});
