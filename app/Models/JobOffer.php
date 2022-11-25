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

class JobOffer extends Model implements HasMedia
{
    use SoftDeletes;
    use InteractsWithMedia;
    use Auditable;
    use HasFactory;

    public $table = 'job_offers';

    protected $appends = [
        'attachments',
    ];

    protected $dates = [
        'date_start',
        'date_end',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'title',
        'user_id',
        'candidate_id',
        'program_id',
        'active',
        'date_start',
        'date_end',
        'recruiter_type_id',
        'company',
        'contact_name',
        'contact_email',
        'contact_phone',
        'url',
        'city_id',
        'description',
        'educational_level_id',
        'professional_level_id',
        'functional_area_id',
        'skill_id',
        'industry_sector_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function jobOfferJobOfferCandidates()
    {
        return $this->hasMany(JobOfferCandidate::class, 'job_offer_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function candidate()
    {
        return $this->belongsTo(Candidate::class, 'candidate_id');
    }

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }

    public function getDateStartAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setDateStartAttribute($value)
    {
        $this->attributes['date_start'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getDateEndAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setDateEndAttribute($value)
    {
        $this->attributes['date_end'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function tags()
    {
        return $this->belongsToMany(JobOfferTag::class);
    }

    public function recruiter_type()
    {
        return $this->belongsTo(RecruiterType::class, 'recruiter_type_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function educational_level()
    {
        return $this->belongsTo(EducationLevel::class, 'educational_level_id');
    }

    public function professional_level()
    {
        return $this->belongsTo(ProfessionalLevel::class, 'professional_level_id');
    }

    public function functional_area()
    {
        return $this->belongsTo(FunctionalArea::class, 'functional_area_id');
    }

    public function languages()
    {
        return $this->belongsToMany(Language::class);
    }

    public function skill()
    {
        return $this->belongsTo(Skill::class, 'skill_id');
    }

    public function industry_sector()
    {
        return $this->belongsTo(IndustrySector::class, 'industry_sector_id');
    }

    public function getAttachmentsAttribute()
    {
        return $this->getMedia('attachments');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
