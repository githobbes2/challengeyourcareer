<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuestionGroup extends Model
{
    use SoftDeletes;
    use Auditable;
    use HasFactory;

    public $table = 'question_groups';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'order',
        'weight',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function questionGroupPolls()
    {
        return $this->belongsToMany(Poll::class);
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class);
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
