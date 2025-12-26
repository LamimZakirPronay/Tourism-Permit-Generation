<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PermitVehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'permit_id',
        'vehicle_ownership',
        'vehicle_reg_no',
        'driver_name',
        'driver_contact',
        'driver_emergency_contact',
        'driver_blood_group',
        'driver_license_no',
        'driver_nid',
    ];

    public function permit(): BelongsTo
    {
        return $this->belongsTo(Permit::class);
    }
}
