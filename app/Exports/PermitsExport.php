<?php

namespace App\Exports;

use App\Models\Permit;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PermitsExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Load with team members to count them if needed
        return Permit::with('teamMembers')->get();
    }

    /**
    * Define the headers for the Excel file
    */
    public function headings(): array
    {
        return [
            'ID',
            'Group Name',
            'Area',
            'Leader Name',
            'Contact',
            'Arrival',
            'Departure',
            'Total Members',
            'Status'
        ];
    }

    /**
    * Map the data to the specific columns
    */
    public function map($permit): array
    {
        return [
            $permit->id,
            $permit->group_name,
            $permit->area_name,
            $permit->leader_name,
            $permit->contact_number,
            $permit->arrival_datetime,
            $permit->departure_datetime,
            $permit->teamMembers->count(),
            'PAID'
        ];
    }
}