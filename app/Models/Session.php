<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Session extends Model implements HasMedia
{
    use SoftDeletes;
    use InteractsWithMedia;
    use Auditable;
    use HasFactory;

    public const STATUS_RADIO = [
        'p' => 'Programada',
        's' => 'Reagendada',
        'd' => 'Realizada',
        'r' => 'Rechazada',
        'c' => 'Cancelada',
    ];

    public $table = 'sessions';

    protected $appends = [
        'attachments',
    ];

    protected $dates = [
        'start_time',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'title',
        'user_id',
        'session_type_id',
        'start_time',
        'duration',
        'location',
        'status',
        'description',
        'private_notes',
        'manager_score',
        'program_id',
        'company_id',
        'development_area_id',
        'experience_points',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function session_users()
    {
        return $this->hasMany(SessionUser::class, 'session_id', 'id');
    }

    public function sessions()
    {
        return $this->hasMany(SessionUser::class, 'session_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function session_type()
    {
        return $this->belongsTo(SessionType::class, 'session_type_id');
    }

    public function getStartTimeAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format_nosecs')) : null;
    }

    public function setStartTimeAttribute($value)
    {
        $this->attributes['start_time'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format_nosecs'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function getAttachmentsAttribute()
    {
        return $this->getMedia('attachments');
    }

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
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
