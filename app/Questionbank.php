<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Questionbank extends Model
{
    protected $primaryKey = 'qwId';
    
    protected $fillable = ['qbId', 'pqbId','qtId', 'pqtId', 'qlId', 'qwType', 'qwTitle', 'totalOptions', 'qwOptions', 'qwCorrectAnswer',  'qwLevel', 'qwHint', 'qwStatus', 'qwCreatedBy'];
}
