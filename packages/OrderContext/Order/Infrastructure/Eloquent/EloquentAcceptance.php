<?php
namespace Packages\OrderContext\Order\Infrastructure\Eloquent\Model;

use Illuminate\Database\Eloquent\Model;

class EloquentAcceptance extends Model
{
    protected $table = 'acceptances';
    
    protected $primaryKey = 'acceptance_id';
    
    public $incrementing = false;
    
    protected $keyType = 'string';
    
    protected $fillable = [
        'acceptance_id',
        'order_id',
        'accepted_at',
    ];
    
    protected $casts = [
        'accepted_at' => 'datetime',
    ];
}

