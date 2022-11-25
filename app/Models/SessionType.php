<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SessionType extends Model
{
    use SoftDeletes;
    use Auditable;
    use HasFactory;

    public $table = 'session_types';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'description',
        'score_required',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function sessionTypesQuestions()
    {
        return $this->belongsToMany(Question::class);
    }

    public function sessionTypesProgramTypes()
    {
        return $this->belongsToMany(ProgramType::class);
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
