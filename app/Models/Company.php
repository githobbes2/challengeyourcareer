<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Company extends Model implements HasMedia
{
    use SoftDeletes;
    use InteractsWithMedia;
    use HasFactory;

    public $table = 'companies';

    protected $appends = [
        'logo',
        'attachments',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'tax_number',
        'contact_name',
        'contact_phone',
        'contact_email',
        'industry_sector_id',
        'notes',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function companyUsers()
    {
        return $this->hasMany(User::class, 'company_id', 'id');
    }

    public function companyPrograms()
    {
        return $this->hasMany(Program::class, 'company_id', 'id');
    }

    public function companyCandidates()
    {
        return $this->hasMany(Candidate::class, 'company_id', 'id');
    }

    //public function relocationCompanyCandidatePrograms()
    //{
    //    return $this->hasMany(CandidateProgram::class, 'relocation_company_id', 'id');
    //}

    public function targetCompanyCandidates()
    {
        return $this->belongsToMany(Candidate::class);
    }

    public function companiesEvents()
    {
        return $this->belongsToMany(Event::class);
    }

    public function industry_sector()
    {
        return $this->belongsTo(IndustrySector::class, 'industry_sector_id');
    }

    public function countries()
    {
        return $this->belongsToMany(Country::class);
    }

    public function getLogoAttribute()
    {
        $file = $this->getMedia('logo')->last();
        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview   = $file->getUrl('preview');
        }

        return $file;
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
