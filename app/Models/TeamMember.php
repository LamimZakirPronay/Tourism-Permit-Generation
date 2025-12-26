<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeamMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'permit_id', 'name', 'fathers_name', 'age', 'gender',
        'age_category', 'address', 'profession', 'contact_number',
        'emergency_contact', 'blood_group', 'nid_or_passport',
    ];

    /**
     * Relationship: A Team Member belongs to a Permit
     */
    public function permit(): BelongsTo
    {
        return $this->belongsTo(Permit::class, 'permit_id', 'id');
    }
}
