<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CandidateProgram extends Model
{
    use SoftDeletes;
    use Auditable;
    use HasFactory;

    public $table = 'candidate_programs';

    public const STATUS_RADIO = [
        '0' => 'Sesiones activas',
        '1' => 'En seguimiento',
        '2' => 'Suspendido',
        '3' => 'Resuelto',
        '4' => 'Recolocado',
        '5' => 'Finalizado',
        '6' => 'Inactivo',
    ];

    protected $dates = [
        'program_start_date',
        'program_end_date',
        'relocation_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'candidate_id',
        'program_id',
        'status',
        'program_start_date',
        'program_end_date',
        'relocation_date',
        'relocation_company',
        'relocation_company_id',
        'functional_area_id',
        'profesional_level_id',
        'industry_sector_id',
        'internal_notes',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function candidateProgramCandidateServices()
    {
        return $this->hasMany(CandidateService::class, 'candidate_program_id', 'id');
    }

    public function candidateProgramPollCandidates()
    {
        return $this->hasMany(PollCandidate::class, 'candidate_program_id', 'id');
    }

    public function candidate()
    {
        return $this->belongsTo(Candidate::class, 'candidate_id');
    }

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }

    public function tags()
    {
        return $this->belongsToMany(CandidateProgramTag::class);
    }

    public function getProgramStartDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setProgramStartDateAttribute($value)
    {
        $this->attributes['program_start_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getProgramEndDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setProgramEndDateAttribute($value)
    {
        $this->attributes['program_end_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getRelocationDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setRelocationDateAttribute($value)
    {
        $this->attributes['relocation_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    //public function relocation_company()
    //{
    //    return $this->belongsTo(Company::class, 'relocation_company_id');
    //}

    public function functional_area()
    {
        return $this->belongsTo(FunctionalArea::class, 'functional_area_id');
    }

    public function profesional_level()
    {
        return $this->belongsTo(ProfessionalLevel::class, 'profesional_level_id');
    }

    public function industry_sector()
    {
        return $this->belongsTo(IndustrySector::class, 'industry_sector_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
