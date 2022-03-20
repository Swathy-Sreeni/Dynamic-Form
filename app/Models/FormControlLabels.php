<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormControlLabels extends Model
{
    protected $table = 'form_controls';
    public function form_control_options()
    {
        return $this->hasMany('App\Models\FormControlOptions','form_control_id')->orderBy('id');
    }
}
