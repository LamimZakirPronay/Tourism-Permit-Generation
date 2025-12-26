<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; // <--- 1. MUST IMPORT THIS

class Permit extends Model
{
    use HasFactory, HasUuids; // <--- 2. MUST USE THIS TRAIT

    protected $fillable = [
        // Basic Trip Info
        'group_name',
        'tour_guide_id',
        'arrival_datetime',
        'departure_datetime',

        // Lead Applicant Info
        'leader_name',
        'leader_nid',
        'email',
        'contact_number',

        // Vehicle & Driver Details
        'vehicle_ownership',
        'vehicle_reg_no',
        'driver_name',
        'driver_contact',
        'driver_emergency_contact',
        'driver_blood_group',
        'driver_license_no',
        'driver_nid',

        // Application Metadata
        'document_path',
        'total_members',
        'amount',
        'payment_status',
        'bkash_trx_id',
        'bkash_payment_id',
        'status',
        'is_defense',
    ];

    // Important for UUID support
    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    /**
     * Relationship: A Permit has many Team Members
     */
    public function teamMembers()
    {
        // Explicitly map the foreign key 'permit_id' and local key 'id'
        return $this->hasMany(TeamMember::class, 'permit_id', 'id');
    }

    /**
     * Relationship: A Permit belongs to a Tour Guide
     */
    public function tourGuide()
    {
        return $this->belongsTo(TourGuide::class, 'tour_guide_id');
    }

    // Remove 'area_name' from $fillable since it's now a relationship
    public function areas()
    {
        return $this->belongsToMany(Area::class);
    }

    /**
     * Calculate the daily serial rank for this specific permit.
     * Returns a padded string like "005"
     */
    public function getDailySerialAttribute()
    {
        $count = self::whereDate('created_at', $this->created_at->format('Y-m-d'))
            ->where('created_at', '<=', $this->created_at)
            ->count();

        return str_pad($count, 3, '0', STR_PAD_LEFT);
    }

    public function vehicles()
    {
        // Ensure the class name matches your actual Vehicle model
        return $this->hasMany(PermitVehicle::class, 'permit_id');
    }
}
