<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgramType extends Model
{
    use SoftDeletes;
    use Auditable;
    use HasFactory;

    public $table = 'program_types';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'description',
        'outplacement',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function programTypePrograms()
    {
        return $this->hasMany(Program::class, 'program_type_id', 'id');
    }

    public function programTypesEvents()
    {
        return $this->belongsToMany(Event::class);
    }

    public function service_groups()
    {
        return $this->belongsToMany(ServiceGroup::class);
    }

    public function session_types()
    {
        return $this->belongsToMany(SessionType::class);
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
