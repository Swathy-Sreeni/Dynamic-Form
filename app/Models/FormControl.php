<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormControl extends Model
{
    protected $table = 'forms';

     public function form_control_labels()
    {
        return $this->hasMany('App\Models\FormControlLabels','form_id');
    }
}
