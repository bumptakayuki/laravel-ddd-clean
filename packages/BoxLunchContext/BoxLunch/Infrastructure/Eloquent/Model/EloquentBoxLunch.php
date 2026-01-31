<?php
namespace Packages\BoxLunchContext\BoxLunch\Infrastructure\Eloquent\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EloquentBoxLunch extends Model
{
    protected $table = 'box_lunches';
    
    protected $primaryKey = 'box_lunch_id';
    
    public $incrementing = false;
    
    protected $keyType = 'string';
    
    protected $fillable = [
        'box_lunch_id',
        'name',
        'description',
        'base_price',
        'is_active',
    ];
    
    protected $casts = [
        'base_price' => 'decimal:2',
        'is_active' => 'boolean',
    ];
    
    /**
     * オプションとのリレーション
     */
    public function options(): HasMany
    {
        return $this->hasMany(EloquentBoxLunchOption::class, 'box_lunch_id', 'box_lunch_id');
    }
}



