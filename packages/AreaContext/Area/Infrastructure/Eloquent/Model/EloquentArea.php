<?php
namespace Packages\AreaContext\Area\Infrastructure\Eloquent\Model;

use Illuminate\Database\Eloquent\Model;

class EloquentArea extends Model
{
    protected $table = 'areas';
    
    protected $primaryKey = 'area_id';
    
    public $incrementing = false;
    
    protected $keyType = 'string';
    
    protected $fillable = [
        'area_id',
        'name',
    ];
    
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}



