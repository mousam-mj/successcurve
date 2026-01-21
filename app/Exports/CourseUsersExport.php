<?php

namespace App\Exports;

use App\User;
use App\Courseenroll;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CourseUsersExport implements FromCollection, WithHeadings
{
    private $courseId;

    public function  __construct($courseId)
    {
        $this->courseId= $courseId;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Courseenroll::join('users', 'users.id', '=', 'courseenrolls.userId')->select('courseenrolls.courseId','users.id as userId', 'users.name as userName', 'users.contact as userContact', 'users.email as userEmail', 'courseenrolls.updated_at')->where('courseId', $this->courseId)->get();
    }

    public function headings(): array
    {
        return [
            'Course ID',
            'User ID',
            'Name',
            'Email',
            'Contact',
            'Enrolled At',
        ];
    }
}
