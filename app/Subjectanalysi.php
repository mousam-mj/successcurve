<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subjectanalysi extends Model
{
    protected $primaryKey = 'saId';
    
    protected $fillable = ['resultId','tsecId','userId','total_marks', 'right_marks', 'wrong_marks', 'your_marks'];
}
