<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Permission\Models\Permission;

class Module extends Model
{
    use HasFactory;



    public function permissions(): HasMany
    {
        return $this->hasMany(Permission::class, 'module_id');
    }



}
