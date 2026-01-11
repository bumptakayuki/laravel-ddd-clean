<?php
namespace Packages\OrderContext\Order\Infrastructure\Eloquent\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EloquentOrderItem extends Model
{
    protected $table = 'order_items';
    
    protected $primaryKey = 'order_item_id';
    
    public $incrementing = false;
    
    protected $keyType = 'string';
    
    protected $fillable = [
        'order_item_id',
        'order_id',
        'configuration_id',
        'unit_price',
        'quantity',
        'line_amount',
    ];
    
    protected $casts = [
        'unit_price' => 'decimal:2',
        'quantity' => 'integer',
        'line_amount' => 'decimal:2',
    ];
    
    /**
     * 注文とのリレーション
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(EloquentOrder::class, 'order_id', 'order_id');
    }
}

