<?php

namespace App\Models;

use \DateTimeInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Support\Facades\DB;

class Candidate extends Model implements HasMedia
{
    use SoftDeletes;
    use InteractsWithMedia;
    use HasFactory;

    public $table = 'candidates';

    private $MainProgram = null;
    private $CandidateProgram = null;
    private $ProgramCompletion = null;

    protected $appends = [
        'curriculum',
    ];

    protected $dates = [
        'employability_score_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'user_id',
        'company_id',
        'city_id',
        'address',
        'postalcode',
        'profile',
        'education_level_id',
        'professional_level_id',
        'functional_area_id',
        'industry_sector_id',
        'position',
        'gender_id',
        'disability',
        'immigrant',
        'employability_score',
        'employability_score_date',
        'challenge_card',
        'target_companies',
        'created_by',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function getFullNameAttribute()
    {
        return $this->user ? $this->user->full_name : '';
    }

    public function candidateCandidatePrograms()
    {
        return $this->hasMany(CandidateProgram::class, 'candidate_id', 'id');
    }

    public function getProgramAttribute()
    {
        if(!$this->MainProgram) {
            $candidateProgram = $this->hasOne(CandidateProgram::class)->latest()->first();
            if($candidateProgram)
            {
                $this->CandidateProgram = $candidateProgram;
                $this->MainProgram = $this->CandidateProgram->program;
                if($this->MainProgram) {
                    $this->MainProgram->load('program_type');
                }
            }
        }
        return $this->MainProgram;
    }

    public function getCandidateProgramAttribute()
    {
        if(!$this->CandidateProgram) {
            $candidateProgram = $this->hasOne(CandidateProgram::class)->latest()->first();
            if($candidateProgram)
            {
                $this->CandidateProgram = $candidateProgram;
                $this->MainProgram = $this->CandidateProgram->program;
                $this->MainProgram->load('program_type');
            }
        }
        return $this->CandidateProgram;
    }

    //Porcentaje de avance en el programa
    public function getProgramCompletionAttribute()
    {
        if(!$this->ProgramCompletion) {
            if($this->MainProgram) {
                $this->ProgramCompletion = 0;

                $template_sessions = $this->MainProgram->session_template_count;
                $sessions_completed= \App\Models\SessionUser::select(DB::raw('COUNT(sessions.id) as sessions_count'))
                    ->join('sessions', 'session_users.session_id', '=', 'sessions.id')
                    ->where('session_users.user_id', $this->user->id)
                    ->where('session_users.attendance', 1)
                    ->where('sessions.program_id', $this->MainProgram->id)
                    ->first();

                if($template_sessions > 0 && $sessions_completed) {
                    //sesiones completadas entre numero de sesiones del template del programa
                    $this->ProgramCompletion = round(100 * $sessions_completed->sessions_count / $template_sessions);
                    if($this->ProgramCompletion > 100) {
                        //topar a 100
                        $this->ProgramCompletion = 100;
                    }
                }
            }
        }
        return $this->ProgramCompletion;
    }

    public function candidateCandidateCommitments()
    {
        return $this->hasMany(CandidateCommitment::class, 'candidate_id', 'id');
    }

    public function candidateCandidateServices()
    {
        return $this->hasMany(CandidateService::class, 'candidate_id', 'id');
    }

    public function candidateJobOfferCandidates()
    {
        return $this->hasMany(JobOfferCandidate::class, 'candidate_id', 'id');
    }

    public function candidateEventCandidates()
    {
        return $this->hasMany(EventCandidate::class, 'candidate_id', 'id');
    }

    public function candidatePollCandidates()
    {
        return $this->hasMany(PollCandidate::class, 'candidate_id', 'id');
    }

    public function candidateCandidateCurriculums()
    {
        return $this->hasMany(CandidateCurriculum::class, 'candidate_id', 'id');
    }

    public function candidateJobOffers()
    {
        return $this->hasMany(JobOffer::class, 'candidate_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function getCurriculumAttribute()
    {
        return $this->getMedia('curriculum')->last();
    }

    public function tags()
    {
        return $this->belongsToMany(CandidateTag::class);
    }

    public function education_level()
    {
        return $this->belongsTo(EducationLevel::class, 'education_level_id');
    }

    public function professional_level()
    {
        return $this->belongsTo(ProfessionalLevel::class, 'professional_level_id');
    }

    public function functional_area()
    {
        return $this->belongsTo(FunctionalArea::class, 'functional_area_id');
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class);
    }

    public function industry_sector()
    {
        return $this->belongsTo(IndustrySector::class, 'industry_sector_id');
    }

    public function related_companies()
    {
        return $this->belongsToMany(Company::class);
    }

    public function gender()
    {
        return $this->belongsTo(Gender::class, 'gender_id');
    }

    public function getEmployabilityScoreDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setEmployabilityScoreDateAttribute($value)
    {
        $this->attributes['employability_score_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
