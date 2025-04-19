<?php
namespace Packages\Order\Order\Infrastructure\Eloquent\Model;

use Illuminate\Database\Eloquent\Model;

class EloquentOrder extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'id',
        'status',
        'items',
    ];

    protected $casts = [
        'items' => 'array',
    ];

    public $incrementing = false;
    protected $keyType = 'string';
}
