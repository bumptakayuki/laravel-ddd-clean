<?php
namespace Packages\StoreContext\Store\Infrastructure\Eloquent\Model;

use Illuminate\Database\Eloquent\Model;

class EloquentStoreBoxLunch extends Model
{
    protected $table = 'store_box_lunches';
    
    // 複合主キーのため、Eloquentの主キー機能は使用しない
    public $incrementing = false;
    
    public $timestamps = false;
    
    protected $fillable = [
        'store_id',
        'box_lunch_id',
        'is_available',
    ];
    
    protected $casts = [
        'is_available' => 'boolean',
    ];
}

