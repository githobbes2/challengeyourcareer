<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobOfferCandidate extends Model
{
    use SoftDeletes;
    use Auditable;
    use HasFactory;

    public const MEDIATION_STATUS_SELECT = [
        '0' => 'No validado',
        '1' => 'Validado',
        '2' => 'Intermediado',
    ];

    public const STATUS_RADIO = [
        '1' => 'Postulado',
        '2' => 'Contactado',
        '3' => 'Entrevistado',
        '4' => 'Contratado',
        '9' => 'Descartado',
    ];

    public $table = 'job_offer_candidates';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'job_offer_id',
        'candidate_id',
        'status',
        'is_favorite',
        'curriculum_id',
        'request_mediation',
        'mediation_status',
        'mediation_notes',
        'mediation_private_notes',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function job_offer()
    {
        return $this->belongsTo(JobOffer::class, 'job_offer_id');
    }

    public function candidate()
    {
        return $this->belongsTo(Candidate::class, 'candidate_id');
    }

    public function curriculum()
    {
        return $this->belongsTo(CandidateCurriculum::class, 'curriculum_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
