<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PollLanguageScore extends Model
{
    use SoftDeletes;
    use Auditable;
    use HasFactory;

    public $table = 'poll_language_scores';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'language_id',
        'education_level_id',
        'points',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }

    public function education_level()
    {
        return $this->belongsTo(EducationLevel::class, 'education_level_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
