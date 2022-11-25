<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CandidateService extends Model
{
    use SoftDeletes;
    use Auditable;
    use HasFactory;

    public $table = 'candidate_services';

    protected $dates = [
        'date_service',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'candidate_id',
        'service_item_id',
        'date_service',
        'user_id',
        'attendance',
        'notes',
        'candidate_program_id',
        'session_user_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function candidate()
    {
        return $this->belongsTo(Candidate::class, 'candidate_id');
    }

    public function service_item()
    {
        return $this->belongsTo(ServiceItem::class, 'service_item_id');
    }

    public function getDateServiceAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setDateServiceAttribute($value)
    {
        $this->attributes['date_service'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function candidate_program()
    {
        return $this->belongsTo(CandidateProgram::class, 'candidate_program_id');
    }

    public function session_user()
    {
        return $this->belongsTo(SessionUser::class, 'session_user_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
