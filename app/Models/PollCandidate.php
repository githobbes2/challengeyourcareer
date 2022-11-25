<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PollCandidate extends Model
{
    use SoftDeletes;
    use Auditable;
    use HasFactory;

    public const COMPANY_SIZE_RADIO = [
        '1' => '1 a 10 empleados',
        '2' => '11 a 50 empleados',
        '3' => '51-200 empleados',
        '4' => '201-1000 empleados',
        '5' => 'Más de 1000 empleados',
    ];

    public $table = 'poll_candidates';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'poll_id',
        'candidate_id',
        'score',
        'experience_points',
        'age',
        'company',
        'city_id',
        'professional_level_id',
        'educational_level_id',
        'functional_area_id',
        'company_size',
        'candidate_program_id',
        'is_initial',
        'is_final',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function poll()
    {
        return $this->belongsTo(Poll::class, 'poll_id');
    }

    public function candidate()
    {
        return $this->belongsTo(Candidate::class, 'candidate_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function professional_level()
    {
        return $this->belongsTo(ProfessionalLevel::class, 'professional_level_id');
    }

    public function languages()
    {
        return $this->belongsToMany(Language::class);
    }

    public function educational_level()
    {
        return $this->belongsTo(EducationLevel::class, 'educational_level_id');
    }

    public function functional_area()
    {
        return $this->belongsTo(FunctionalArea::class, 'functional_area_id');
    }

    public function candidate_program()
    {
        return $this->belongsTo(CandidateProgram::class, 'candidate_program_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
