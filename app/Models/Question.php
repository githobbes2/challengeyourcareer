<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use SoftDeletes;
    use Auditable;
    use HasFactory;

    public $table = 'questions';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'development_area_id',
        'points_1',
        'points_2',
        'points_3',
        'points_4',
        'points_5',
        'experience_points_1',
        'experience_points_2',
        'experience_points_3',
        'experience_points_4',
        'experience_points_5',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function questionsQuestionGroups()
    {
        return $this->belongsToMany(QuestionGroup::class);
    }

    public function score_session_type()
    {
        return $this->belongsToMany(SessionType::class, 'question_score_session_type')->withPivot('score');
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
