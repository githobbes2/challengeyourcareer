<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SkillTag extends Model
{
    use SoftDeletes;
    use Auditable;
    use HasFactory;

    public const COLOR_RADIO = [
        '#a6acaf' => 'color 1',
        '#2e4053' => 'color 2',
        '#cb4335' => 'color 3',
        '#7d3c98' => 'color 4',
        '#2471a3' => 'color 5',
        '#17a589' => 'color 6',
        '#d4ac0d' => 'color 7',
        '#e67e22' => 'color 8',
    ];

    public $table = 'skill_tags';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'color',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function skillTagsConsultants()
    {
        return $this->belongsToMany(Consultant::class);
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
