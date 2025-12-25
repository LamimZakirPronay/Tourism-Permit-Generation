<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'is_active'];

    /**
     * Relationship: Many areas can belong to many permits.
     */
    public function permits()
    {
        return $this->belongsToMany(Permit::class, 'area_permit', 'area_id', 'permit_id');
    }
}