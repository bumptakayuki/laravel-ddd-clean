<?php
namespace Packages\StoreContext\Store\Infrastructure\Eloquent\Model;

use Illuminate\Database\Eloquent\Model;

class EloquentStoreArea extends Model
{
    protected $table = 'store_areas';
    
    // 複合主キーのため、Eloquentの主キー機能は使用しない
    public $incrementing = false;
    
    public $timestamps = false;
    
    protected $fillable = [
        'store_id',
        'area_id',
        'is_deliverable',
    ];
    
    protected $casts = [
        'is_deliverable' => 'boolean',
    ];
}

