<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceType extends Model
{
    use SoftDeletes;
    use Auditable;
    use HasFactory;

    public const TYPE_RADIO = [
        'E' => 'Embajada',
        'F' => 'Facilidad',
    ];

    public $table = 'service_types';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'code',
        'name',
        'type',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function serviceTypeServiceItems()
    {
        return $this->hasMany(ServiceItem::class, 'service_type_id', 'id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
