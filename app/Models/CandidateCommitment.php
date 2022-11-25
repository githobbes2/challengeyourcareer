<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CandidateCommitment extends Model
{
    use SoftDeletes;
    use Auditable;
    use HasFactory;

    public $table = 'candidate_commitments';

    protected $dates = [
        'completion_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'title',
        'candidate_id',
        'session_user_id',
        'complete',
        'completion_date',
        'note',
        'comments',
        'development_area_id',
        'experience_points',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function candidate()
    {
        return $this->belongsTo(Candidate::class, 'candidate_id');
    }

    public function session_user()
    {
        return $this->belongsTo(SessionUser::class, 'session_user_id');
    }

    public function getCompletionDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setCompletionDateAttribute($value)
    {
        $this->attributes['completion_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function tags()
    {
        return $this->belongsToMany(CommitmentTag::class);
    }

    public function development_area()
    {
        return $this->belongsTo(DevelopmentArea::class, 'development_area_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
