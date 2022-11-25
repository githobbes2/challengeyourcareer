<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Poll extends Model
{
    use SoftDeletes;
    use Auditable;
    use HasFactory;

    public $table = 'polls';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'label_1',
        'label_2',
        'label_3',
        'label_4',
        'label_5',
        'use_age_score',
        'use_language_score',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function question_groups()
    {
        return $this->belongsToMany(QuestionGroup::class);
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
