<?php
namespace Packages\OrderContext\Order\Infrastructure\Eloquent\Model;

use Illuminate\Database\Eloquent\Model;

class EloquentPurchase extends Model
{
    protected $table = 'purchases';
    
    protected $primaryKey = 'purchase_id';
    
    public $incrementing = false;
    
    protected $keyType = 'string';
    
    protected $fillable = [
        'purchase_id',
        'order_id',
        'confirmed_at',
    ];
    
    protected $casts = [
        'confirmed_at' => 'datetime',
    ];
}


