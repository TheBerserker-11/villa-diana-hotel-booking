<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReferenceExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Order::select(
            'reference_code',
            'check_in',
            'check_out',
            'room_id',
            'user_id',
            'created_at'
        )->whereNotNull('reference_code')->get();
    }

    public function headings(): array
    {
        return [
            'Reference Code',
            'Check In',
            'Check Out',
            'Room ID',
            'User ID',
            'Created At'
        ];
    }
}
