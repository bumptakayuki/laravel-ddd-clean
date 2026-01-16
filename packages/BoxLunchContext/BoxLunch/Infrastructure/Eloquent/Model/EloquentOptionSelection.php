<?php
namespace Packages\BoxLunchContext\BoxLunch\Infrastructure\Eloquent\Model;

use Illuminate\Database\Eloquent\Model;

class EloquentOptionSelection extends Model
{
    protected $table = 'option_selections';
    
    protected $primaryKey = 'selection_id';
    
    public $incrementing = false;
    
    protected $keyType = 'string';
    
    protected $fillable = [
        'selection_id',
        'configuration_id',
        'option_id',
        'quantity',
    ];
    
    protected $casts = [
        'quantity' => 'integer',
    ];
}


