<?php

namespace App\Repositories;

use App\Models\FormControl;
use Carbon\Carbon;
use App\Models\FormControlLabels;
use App\Models\FormControlOptions;

class FormRepository
{
    public function __construct()
    {
        //
    }
    public function addForm($aData)
    {
        if (isset($aData['form_id']) && $aData['form_id']) {
            $oForm = FormControl::find($aData['form_id']);
        } else {
            $oForm = new FormControl();
        }
        $oForm->form_name = $aData['form_name'];

        $oForm->save();
        if (isset($aData['label']) && $aData['label'] != null && $aData['label'] != '' 
        || isset($aData['form_control_id'])) {
            if (isset($aData['form_control_id']) && $aData['form_control_id']) {
                $oFormControlLabels = FormControlLabels::find($aData['form_control_id']);
                FormControlOptions::where('form_control_id', $aData['form_control_id'])->delete();

            }
            else {
                $oFormControlLabels = new FormControlLabels();
            }
            $oFormControlLabels->form_id = $oForm->id;
            $oFormControlLabels->label = $aData['label'];
            $oFormControlLabels->type = $aData['type'];
            $oFormControlLabels->save();
            if (isset($aData['type']) && $aData['type'] == 3 && isset($aData['options']) && count(array_filter($aData['options'])) > 0) {
                foreach($aData['options'] as $option){
                    if(isset($option) && $option != null){
                        $oFormControlOptions = new FormControlOptions();
                        $oFormControlOptions->form_control_id = $oFormControlLabels->id;
                        $oFormControlOptions->option = $option;
                        $oFormControlOptions->save();

                    }
                    

                }
                

            }
        }
        return $oForm->id;

    }
    public function fetchFormEdit($formId)
    {

        $form = FormControl::find($formId);
        $form['form_controls'] = $form->form_control_labels;
        
        foreach($form['form_controls'] as $key => $label){
            $form['form_controls'][$key]['options'] = $label->form_control_options;
        }

        return $form->toArray();

    }
      public function deleteFormControl($id)
    {
        FormControlOptions::where('form_control_id',$id)->delete();
        return FormControlLabels::destroy($id);
    }
     public function deleteForm($id)
    {
        $form = FormControl::find($id);
        $form_controls= $form->form_control_labels;
        foreach($form_controls as $control){
            $control->form_control_options()->delete();
        }
        $form->form_control_labels()->delete();
        return $form->delete();
        
    }

}
