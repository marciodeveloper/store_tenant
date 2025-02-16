<?php

namespace App\Models;

use App\Traits\BelongsTenantScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory, BelongsTenantScope;

    protected $fillable = ['name', 'description'];

    public function setNameAttribute($prop)
    {
        $this->attributes['name'] = $prop;
        $this->attributes['slug'] = \Illuminate\Support\Str::slug($prop);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
