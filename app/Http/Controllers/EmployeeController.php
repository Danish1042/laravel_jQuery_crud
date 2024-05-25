<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

use function Laravel\Prompts\alert;

class EmployeeController extends Controller
{
    public function index(){
        return view('singlePageApp');
    }

    public function getData(){
        return Employee::orderBy('id', 'desc')->get();
    }

    public function saveData(Request $request){
        // echo $request->input('data');
        $employee = new Employee;
        parse_str($request->input('data'), $formData); // name=Muhammad%20Danish&email=usmaninstitute%40daresni.net&pswd=password&mobile=3115042

        $employee->name = $formData['name'];
        $employee->email = $formData['email'];
        $employee->password = $formData['pswd'];
        $employee->mobile = $formData['mobile'];

        if(empty($formData['id']) || ($formData['id'] == "")){
            $employee->save();
        }else{
            // for update record
            $employee = Employee::find($formData['id']);
            $employee->name = $formData['name'];
            $employee->email = $formData['email'];
            $employee->password = $formData['pswd'];
            $employee->mobile = $formData['mobile'];

            $employee->update();
        }
        echo "Changes Made Successfully";
    }

    public function editData(Request $request){
        return Employee::find($request->id);
    }

    public function deleteData(Request $request){
        Employee::where('id', $request->id)->delete();
        echo "Data Deleted Successfully";
    }
}
