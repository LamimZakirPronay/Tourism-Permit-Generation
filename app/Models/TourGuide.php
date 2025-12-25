<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourGuide extends Model
{
    use HasFactory;

    protected $fillable = [
    'name', 'license_id', 'contact', 'is_active',
    'parent_name', 'marital_status', 'spouse_name', 
    'email', 'nid_number', 'address', 
    'emergency_contact', 'blood_group', 'attachment_path'
    ];
}