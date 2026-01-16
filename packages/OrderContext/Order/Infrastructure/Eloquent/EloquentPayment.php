<?php
namespace Packages\OrderContext\Order\Infrastructure\Eloquent\Model;

use Illuminate\Database\Eloquent\Model;

class EloquentPayment extends Model
{
    protected $table = 'payments';
    
    protected $primaryKey = 'payment_id';
    
    public $incrementing = false;
    
    protected $keyType = 'string';
    
    protected $fillable = [
        'payment_id',
        'order_id',
        'method',
        'status',
        'transaction_id',
        'paid_at',
    ];
    
    protected $casts = [
        'paid_at' => 'datetime',
    ];
}


