<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceItem extends Model
{
    use SoftDeletes;
    use Auditable;
    use HasFactory;

    public const TYPE_RADIO = [
        'E' => 'Embajada',
        'F' => 'Facilidad',
    ];

    public $table = 'service_items';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'type',
        'service_type_id',
        'name',
        'description',
        'objective',
        'phase',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function serviceItemsServiceGroups()
    {
        return $this->belongsToMany(ServiceGroup::class);
    }

    public function service_type()
    {
        return $this->belongsTo(ServiceType::class, 'service_type_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
