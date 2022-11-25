<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Program extends Model implements HasMedia
{
    use SoftDeletes;
    use InteractsWithMedia;
    use Auditable;
    use HasFactory;

    public const INDIVIDUAL_RADIO = [
        '1' => 'Grupal',
        '0' => 'Individual',
    ];

    public $table = 'programs';

    private $SessionTemplateCount = null;

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'internal_name',
        'program_type_id',
        'session_template_id',
        'user_id',
        'individual',
        'service_group_id',
        'company_id',
        'invoice',
        'reference',
        'internal_notes',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function sessions()
    {
        return $this->hasMany(Session::class);
    }

    public function serviceGroup()
    {
        return $this->belongsTo(ServiceGroup::class, 'service_group_id');
    }

    public function candidates()
    {
        return $this->belongsToMany(Candidate::class, 'candidate_programs');
    }

    public function programJobOffers()
    {
        return $this->hasMany(JobOffer::class, 'program_id', 'id');
    }

    public function joboffers()
    {
        return $this->hasMany(JobOffer::class, 'program_id', 'id');
    }

    public function programCandidatePrograms()
    {
        return $this->hasMany(CandidateProgram::class, 'program_id', 'id');
    }

    public function programsEvents()
    {
        return $this->belongsToMany(Event::class);
    }

    public function program_type()
    {
        return $this->belongsTo(ProgramType::class, 'program_type_id');
    }

    public function session_template()
    {
        return $this->belongsTo(SessionTemplate::class, 'session_template_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function getSessionTemplateCountAttribute() {
        if($this->SessionTemplateCount === null) {
            $count = 0;
            if($this->session_template) {
                foreach($this->session_template->session_types as $item) {
                    $count = $count + $item->pivot->quantity;
                }
            }
            $this->SessionTemplateCount = $count;
        }
        return $this->SessionTemplateCount;
    }

    public function getAttachmentsAttribute()
    {
        return $this->getMedia('attachments');
    }
}
