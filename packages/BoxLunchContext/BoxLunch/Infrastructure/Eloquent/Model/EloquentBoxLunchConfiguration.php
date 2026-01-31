<?php
namespace Packages\BoxLunchContext\BoxLunch\Infrastructure\Eloquent\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EloquentBoxLunchConfiguration extends Model
{
    protected $table = 'box_lunch_configurations';
    
    protected $primaryKey = 'configuration_id';
    
    public $incrementing = false;
    
    protected $keyType = 'string';
    
    protected $fillable = [
        'configuration_id',
        'box_lunch_id',
        'availability_status',
        'total_price',
    ];
    
    protected $casts = [
        'total_price' => 'decimal:2',
    ];
    
    /**
     * オプション選択とのリレーション
     */
    public function selections(): HasMany
    {
        return $this->hasMany(EloquentOptionSelection::class, 'configuration_id', 'configuration_id');
    }
}



