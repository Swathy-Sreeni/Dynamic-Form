<?php

namespace App\Http\Controllers;

use App\Models\FormControl;
use App\Repositories\FormRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Validator;

class FormController extends Controller
{
    protected $viewNameSpace = 'admin.';
    protected $formRepo;
    public function __construct()
    {
        $this->formRepo = new FormRepository();
    }
    public function index()
    {

        $forms = FormControl::paginate();

        return view($this->viewNameSpace . 'forms-list', [
            'forms' => $forms,
        ]);

    }
    public function add(Request $request)
    {

        return view($this->viewNameSpace . 'forms-add');

    }
    public function createForm(Request $request)
    {
        $aRequest = $request->all();
        $aRules = [
            'form_name' => 'max:100',
        ];
        $v = Validator::make($aRequest, $aRules);

        if ($v->fails()) {
            Session::flash('error', Common::prepareValidationErrorMsg($v->errors()));
            return redirect()->back()->withInput($request->all());
        }

        $form = $this->formRepo->addForm($aRequest);
        if (isset($aRequest['form_id']) && !isset($aRequest['label'])) {
            return response()->json([
                'status' => true,
                'message' => 'Form updated successfully',
            ]);

        } else if ($form) {
            Session::flash('success', 'Successfully added form details!');
            return redirect(url('admin/forms/edit/' . $form));
        } else {
            Session::flash('error', 'Technical error!');
            return redirect(url('/forms/add'));
        }

    }
    public function editForm(Request $request, $form_id)
    {
        try {

            $formData = $this->formRepo->fetchFormEdit($form_id);
            if ($formData) {

                return view($this->viewNameSpace . 'forms-add', [
                    'isEdit' => true,
                    'form_id' => $form_id,
                    'formData' => $formData,
                ]);

            } else {
                return redirect(404);
            }
        } catch (Exception $e) {
            ErrorLog::log($e->getMessage(), 'error', __METHOD__);
            Session::flash('error', 'Internal server error');
            return redirect()->back();
        }

    }
    public function deleteForm($id, Request $request)
    {
        try {

            $status = $this->formRepo->deleteForm($id);

            if ($status) {
                return response()->json([
                    'status' => true,
                    'message' => 'Form deleted successfully',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Something went wrong',
                ]);
            }

        } catch (Exception $e) {
            ErrorLog::log($e->getMessage(), 'error', __METHOD__);
            return response()->json([
                'status' => false,
                'message' => 'Internal server error',
            ]);

        }
    }
    public function deleteFormControl($id, Request $request)
    {
        try {

            $status = $this->formRepo->deleteFormControl($id);

            if ($status) {
                return response()->json([
                    'status' => true,
                    'message' => 'Form Control deleted successfully',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Something went wrong',
                ]);
            }

        } catch (Exception $e) {
            ErrorLog::log($e->getMessage(), 'error', __METHOD__);
            return response()->json([
                'status' => false,
                'message' => 'Internal server error',
            ]);

        }
    }
    public function view()
    {
        $forms = FormControl::get();

        return view('forms-view', [
            'forms' => $forms,
        ]);
    }
    public function viewFormDetail(Request $request, $form_id)
    {
        try {

            $formData = $this->formRepo->fetchFormEdit($form_id);
            if ($formData) {

                return view('form-detail-view', [
                    'form_id' => $form_id,
                    'formData' => $formData,
                ]);

            } else {
                return redirect(404);
            }
        } catch (Exception $e) {
            ErrorLog::log($e->getMessage(), 'error', __METHOD__);
            Session::flash('error', 'Internal server error');
            return redirect()->back();
        }

    }
}
