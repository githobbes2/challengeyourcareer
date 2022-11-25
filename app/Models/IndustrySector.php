<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IndustrySector extends Model
{
    use SoftDeletes;
    use Auditable;
    use HasFactory;

    public $table = 'industry_sectors';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function industrySectorJobOffers()
    {
        return $this->hasMany(JobOffer::class, 'industry_sector_id', 'id');
    }

    public function industrySectorCompanies()
    {
        return $this->hasMany(Company::class, 'industry_sector_id', 'id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
