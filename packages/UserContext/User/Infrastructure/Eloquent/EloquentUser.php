<?php
namespace Packages\User\User\Infrastructure\Eloquent\Model;

use Illuminate\Database\Eloquent\Model;

class EloquentUser extends Model
{
    protected $fillable = ['name', 'email', 'password'];
    protected $hidden = ['password'];
}
