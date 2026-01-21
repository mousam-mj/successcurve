<?php

namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ClassUserExport implements FromCollection, WithHeadings
{
    private $classId;

    public function  __construct($classId)
    {
        $this->classId= $classId;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::select('userClass', 'id', 'name', 'email', 'contact', 'userStatus')->where('userClass', $this->classId)->get();
    }

    public function headings(): array
    {
        return [
            'Class Id',
            'User ID',
            'Name',
            'Email',
            'Contact',
            'Status'
        ];
    }

}
