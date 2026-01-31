<?php
namespace Packages\OrderContext\Order\Infrastructure\Eloquent\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EloquentOrder extends Model
{
    protected $table = 'orders';
    
    protected $primaryKey = 'order_id';
    
    public $incrementing = false;
    
    protected $keyType = 'string';
    
    protected $fillable = [
        'order_id',
        'member_id',
        'store_id',
        'status',
        'total_amount',
        'ordered_at',
    ];
    
    protected $casts = [
        'total_amount' => 'decimal:2',
        'ordered_at' => 'datetime',
    ];
    
    /**
     * 注文明細とのリレーション
     */
    public function items(): HasMany
    {
        return $this->hasMany(EloquentOrderItem::class, 'order_id', 'order_id');
    }
}



