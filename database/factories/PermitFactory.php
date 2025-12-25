<?php

namespace Database\Factories;

use App\Models\Permit;
use App\Models\TourGuide;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PermitFactory extends Factory
{
    protected $model = Permit::class;

    public function definition(): array
    {
        return [
            'id' => (string) Str::uuid(),
            'group_name' => $this->faker->company().' Travelers',
            'tour_guide_id' => TourGuide::inRandomOrder()->first()?->id ?? 1,
            'arrival_datetime' => $this->faker->dateTimeBetween('now', '+1 month'),
            'departure_datetime' => $this->faker->dateTimeBetween('+1 month', '+2 months'),

            'leader_name' => $this->faker->name(),
            'leader_nid' => $this->faker->numerify('###########'),
            'email' => $this->faker->unique()->safeEmail(),
            'contact_number' => $this->faker->phoneNumber(),

            'vehicle_ownership' => $this->faker->randomElement(['Personal', 'Rental', 'Office']),
            'vehicle_reg_no' => 'DHAKA-'.$this->faker->bothify('??-####'),
            'driver_name' => $this->faker->name('male'),
            'driver_contact' => $this->faker->phoneNumber(),

            'total_members' => $this->faker->numberBetween(1, 10),
            'amount' => $this->faker->randomFloat(2, 500, 5000),
            'payment_status' => $this->faker->randomElement(['Paid', 'Unpaid', 'Pending']),
            'status' => $this->faker->randomElement(['Pending', 'Approved', 'Rejected']),
            'is_defense' => $this->faker->boolean(20), // 20% chance of being true
        ];
    }
}
