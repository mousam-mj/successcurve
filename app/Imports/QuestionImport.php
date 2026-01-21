<?php

namespace App\Imports;

use App\Questionbank;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Session;

class QuestionImport implements ToModel, WithHeadingRow
{
    /** 
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Questionbank([
            'qbId' => $row['f2'],
            'pqbId' => $row['f1'],
            'qtId' => $row['f4'],
            'pqtId'=> $row['f3'],
            'qlId'=> $row['f5'],
            'qwType' => $row['type'],
            'qwTitle' => $row['question'],
            'totalOptions' => $row['totaloptions'],
            'qwOptions' => '{"option1":"'. $row["option1"] .'","option2":"'. $row["option2"] .'","option3":"'. $row["option3"] .'","option4":"'. $row["option4"] .'"}',
            'qwCorrectAnswer' => $row['cans'],
            'qwlevel' => $row['level'],
            'qwHint' => $row['hint'],
            'qwCreatedBy' => Session::get('auserId')
        ]);
    }
}
 