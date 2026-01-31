<?php
namespace Packages\StoreContext\Store\Infrastructure\Eloquent\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EloquentStore extends Model
{
    protected $table = 'stores';
    
    protected $primaryKey = 'store_id';
    
    public $incrementing = false;
    
    protected $keyType = 'string';
    
    protected $fillable = [
        'store_id',
        'name',
        'address',
        'is_open',
    ];
    
    protected $casts = [
        'is_open' => 'boolean',
    ];
    
    /**
     * 店舗が提供する弁当とのリレーション
     */
    public function storeBoxLunches(): HasMany
    {
        return $this->hasMany(EloquentStoreBoxLunch::class, 'store_id', 'store_id');
    }
    
    /**
     * 店舗の配達可能エリアとのリレーション
     */
    public function storeAreas(): HasMany
    {
        return $this->hasMany(EloquentStoreArea::class, 'store_id', 'store_id');
    }
}



