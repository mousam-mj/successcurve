<?php

namespace App\Exports;

use App\Tsenroll;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TestSeriesUserExport implements FromCollection, WithHeadings
{
    private $tsId;

    public function  __construct($tsId)
    {
        $this->tsId= $tsId;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Tsenroll::join('users', 'users.id', '=', 'tsenrolls.uId')->select('tsenrolls.tsId', 'users.id', 'users.name', 'users.email','users.contact', 'tsenrolls.updated_at')->where('tsId', $this->tsId)->get();
    }

    public function headings(): array
    {
        return [
            'Test Series ID',
            'User ID',
            'Name',
            'Email',
            'Contact',
            'Enrolled At',
        ];
    }
}
