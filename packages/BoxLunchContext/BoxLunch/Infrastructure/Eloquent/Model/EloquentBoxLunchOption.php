<?php
namespace Packages\BoxLunchContext\BoxLunch\Infrastructure\Eloquent\Model;

use Illuminate\Database\Eloquent\Model;

class EloquentBoxLunchOption extends Model
{
    protected $table = 'box_lunch_options';
    
    protected $primaryKey = 'option_id';
    
    public $incrementing = false;
    
    protected $keyType = 'string';
    
    protected $fillable = [
        'option_id',
        'box_lunch_id',
        'name',
        'price_delta',
        'is_required',
    ];
    
    protected $casts = [
        'price_delta' => 'decimal:2',
        'is_required' => 'boolean',
    ];
}

