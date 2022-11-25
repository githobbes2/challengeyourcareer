<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceGroup extends Model
{
    use SoftDeletes;
    use Auditable;
    use HasFactory;

    public const TYPE_RADIO = [
        'E' => 'Embajada',
        'F' => 'Facilidad',
    ];

    public $table = 'service_groups';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'type',
        'name',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function serviceGroupsProgramTypes()
    {
        return $this->belongsToMany(ProgramType::class);
    }

    public function service_items()
    {
        return $this->belongsToMany(ServiceItem::class);
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
