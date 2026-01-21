<?php

namespace App\Exports;

use App\Test;
use App\Testenroll;
use App\Result;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class testUserExport implements FromCollection, WithHeadings
{
    private $test_id;
    
    public function  __construct($test_id)
    {
        $this->test_id= $test_id;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $tusers = Testenroll::join('users','users.id', '=', 'testenrolls.userId')->select('testenrolls.testId', 'users.id', 'users.name', 'users.email', 'users.contact', 'testenrolls.updated_at')->where('testId', $this->test_id)->get();

        $test = Test::select('total_marks')->where('tId', $this->test_id)->first();
        $i = 0;
        $testUsers = [];
        foreach($tusers as $tuser){
            $testUsers[$i]['Test ID'] = $tuser->testId;
            $testUsers[$i]['User ID'] = $tuser->id;
            $testUsers[$i]['Name'] = $tuser->name;
            $testUsers[$i]['Email'] = $tuser->email;
            $testUsers[$i]['Contact'] = $tuser->contact;

            $result = Result::select('final_marks')->where('examId', $this->test_id)->where('userId', $tuser->id)->first();

            if (!empty($result)) {
                $testUsers[$i]['Marks Gained'] = $result->final_marks;
            } else {
                $testUsers[$i]['Marks Gained'] = 0;
            }
            
            $testUsers[$i]['Total Marks'] = $test->total_marks;

            $testUsers[$i]['TestID'] = $tuser->updated_at;

            $i++;
        }

        return collect($testUsers);
    }

    public function headings(): array
    {
        return [
            'Test ID',
            'User ID',
            'Name',
            'Email',
            'Contact',
            'Marks',
            'Total Marks',
            'Enrolled At',
        ];
    }
}
