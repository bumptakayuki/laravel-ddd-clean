<?php
namespace Packages\BoxLunchContext\BoxLunch\Infrastructure\Eloquent\Model;

use Illuminate\Database\Eloquent\Model;

class EloquentStoreBoxLunch extends Model
{
    protected $table = 'store_box_lunches';
    
    protected $primaryKey = ['store_id', 'box_lunch_id'];
    
    public $incrementing = false;
    
    protected $fillable = [
        'store_id',
        'box_lunch_id',
        'is_available',
    ];
    
    protected $casts = [
        'is_available' => 'boolean',
    ];
}


