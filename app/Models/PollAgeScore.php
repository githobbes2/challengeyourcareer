<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PollAgeScore extends Model
{
    use SoftDeletes;
    use Auditable;
    use HasFactory;

    public $table = 'poll_age_scores';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'order',
        'age_start',
        'end_range',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function professional_levels()
    {
        return $this->belongsToMany(ProfessionalLevel::class);
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
