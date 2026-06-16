<?php
// app/Exports/LaptopEvaluationsExport.php

namespace App\Exports;

use App\Models\LaptopDeviceEvaluation;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LaptopEvaluationsExport implements FromQuery, WithHeadings, WithMapping
{
    public function query()
    {
        return LaptopDeviceEvaluation::with(['brand', 'model', 'variant']);
    }

    public function headings(): array
    {
        return [
            'ID',
            'Customer Name',
            'Mobile',
            'Brand',
            'Model',
            'Variant',
            'Processor',
            'RAM',
            'Storage',
            'Base Price',
            'Deduction',
            'Final Price',
            'Status',
            'OTP Verified',
            'Created At',
        ];
    }

    public function map($eval): array
    {
        $answers = $eval->answers;
        
        return [
            $eval->id,
            $eval->customer_name,
            $eval->customer_mobile,
            $eval->brand->name ?? '—',
            $eval->model->name ?? '—',
            $eval->variant ? "{$eval->variant->storage} / {$eval->variant->ram}" : '—',
            $answers['processor'] ?? '—',
            $answers['ram'] ?? '—',
            $answers['storage'] ?? '—',
            $eval->base_price,
            $eval->total_deduction,
            $eval->estimated_price,
            ucfirst($eval->status),
            $eval->otp_verified ? 'Yes' : 'No',
            $eval->created_at->format('d-m-Y H:i'),
        ];
    }
}