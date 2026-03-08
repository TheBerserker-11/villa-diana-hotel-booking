<?php

namespace App\Exports;

use App\Models\Order;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AdminBookingsExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    public function __construct(
        private readonly string $search = '',
        private readonly string $referenceCode = '',
        private readonly string $statusFilter = '',
        private readonly int $roomTypeId = 0,
        private readonly string $checkInFrom = '',
        private readonly string $checkInTo = ''
    ) {
    }

    public function collection()
    {
        $query = Order::with(['user', 'room.roomtype']);

        if ($this->search !== '') {
            $query->where(function ($main) {
                $main->whereHas('user', function ($q) {
                    $q->where('name', 'LIKE', "%{$this->search}%")
                      ->orWhere('phone', 'LIKE', "%{$this->search}%")
                      ->orWhere('email', 'LIKE', "%{$this->search}%");
                })->orWhere('reference_code', 'LIKE', "%{$this->search}%");
            });
        }

        if ($this->referenceCode !== '') {
            $query->where('reference_code', $this->referenceCode);
        }

        if (in_array($this->statusFilter, ['pending', 'confirmed', 'cancelled'], true)) {
            $query->where('status', $this->statusFilter);
        }

        if ($this->roomTypeId > 0) {
            $query->whereHas('room', function ($roomQuery) {
                $roomQuery->where('room_type_id', $this->roomTypeId);
            });
        }

        if ($this->checkInFrom !== '') {
            $query->whereDate('check_in', '>=', $this->checkInFrom);
        }

        if ($this->checkInTo !== '') {
            $query->whereDate('check_in', '<=', $this->checkInTo);
        }

        return $query->latest()->get()->map(function (Order $order) {
            return [
                $order->id,
                (string) data_get($order, 'user.name', ''),
                (string) data_get($order, 'user.email', ''),
                (string) data_get($order, 'user.phone', ''),
                (string) data_get($order, 'room.roomtype.name', ''),
                (string) data_get($order, 'reference_code', ''),
                $this->formatDate(data_get($order, 'check_in')),
                $this->formatDate(data_get($order, 'check_out')),
                (string) data_get($order, 'status', ''),
                (float) data_get($order, 'sub_total', 0),
                (float) data_get($order, 'vat_amount', 0),
                (float) data_get($order, 'total_amount', 0),
                $this->formatDateTime(data_get($order, 'created_at')),
                (string) data_get($order, 'cancel_reason', ''),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Booking ID',
            'Guest Name',
            'Guest Email',
            'Guest Phone',
            'Room Type',
            'Reference Code',
            'Check In',
            'Check Out',
            'Status',
            'Sub Total',
            'VAT',
            'Total Amount',
            'Booked At',
            'Cancel Reason',
        ];
    }

    private function formatDate(mixed $value): string
    {
        if (empty($value)) {
            return '';
        }

        try {
            return Carbon::parse($value)->format('Y-m-d');
        } catch (\Throwable) {
            return (string) $value;
        }
    }

    private function formatDateTime(mixed $value): string
    {
        if (empty($value)) {
            return '';
        }

        try {
            return Carbon::parse($value)->format('Y-m-d H:i:s');
        } catch (\Throwable) {
            return (string) $value;
        }
    }
}
