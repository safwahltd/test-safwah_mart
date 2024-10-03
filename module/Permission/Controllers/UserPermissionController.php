<?php

namespace Module\Permission\Controllers;

use Exception;

use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Models\UserCredential;
use App\Traits\CheckPermission;
use Module\PosErp\Models\Branch;
use Module\HRM\Models\Department;
use Illuminate\Support\Facades\DB;
use Module\HRM\Models\Designation;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Module\Permission\Models\Module;
use Module\Production\Models\Factory;
use Illuminate\Support\Facades\Schema;
use Module\HRM\Models\Employee\Employee;
use Module\Permission\Models\PermissionUser;
use Module\Permission\Models\PermissionFeature;
use Module\Permission\Models\EmployeePermission;

class UserPermissionController extends Controller
{
    use CheckPermission;








    /*
     |--------------------------------------------------------------------------
     | PERMITTED USER LIST
     |--------------------------------------------------------------------------
    */
    public function view_permitted_users(Request $request)
    {
        $this->updateEmployeeId($request);


        if(class_exists('Module\HRM\Models\Employee\Employee'))
        {
            $users = User::orderByDesc('id')
                            ->with('company', 'employee.department', 'employee.designation')
                            ->where('status', '>', 0)
                            ->where('id', '>', 1)
                            ->get();
        } else {

            $users = User::orderByDesc('id')
                            ->with('company')
                            ->where('status', '>', 0)
                            ->where('id', '>', 1)
                            ->get();
        }


        return view('users.index', compact('users'));
    }







    /*
     |--------------------------------------------------------------------------
     | CREATE USER
     |--------------------------------------------------------------------------
    */
    public function createUser()
    {
        $branches = Branch::pluck('name', 'id');

        return view('users.create', compact('branches'));
    }







    /*
     |--------------------------------------------------------------------------
     | STORE USER
     |--------------------------------------------------------------------------
    */
    public function storeUser(Request $request)
    {
        $request->validate([

            'name'              => 'required',
            'email'             => 'required|unique:users,email',
            'password'          => 'required|min:5',
            'confirm_password'  => 'required|same:password',
        ]);


        try {

            DB::transaction(function () use ($request) {
                $user = User::create([

                    'branch_id'     => $request->branch_id,
                    'name'          => $request->name,
                    'email'         => $request->email,
                    'password'      => Hash::make($request->password),
                    'company_id'    => auth()->user()->company_id
                ]);


                // set visible password into user_credentials table
                UserCredential::updateOrCreate(['user_id' => $user->id], ['secrete' => $request->password]);
            });

        } catch (\Exception $ex) {

            return redirect()->back()->withInput()->withError($ex->getMessage());
        }

        return redirect()->route('permitted.users')->withMessage('User Successfully Created');
    }







    /*
     |--------------------------------------------------------------------------
     | EDIT USER
     |--------------------------------------------------------------------------
    */
    public function editUser($id)
    {
        $data['branches']   = Branch::pluck('name', 'id');
        $data['user']       = User::find($id);

        return view('users.edit', $data);
    }







    /*
     |--------------------------------------------------------------------------
     | UPDATE USER
     |--------------------------------------------------------------------------
    */
    public function updateUser(Request $request, $id)
    {
        $user = User::find($id);

        $request->validate([

            'name'              => 'required',
            'email'             => 'required|unique:users,email,'.$user->id,
        ]);


        try {

            DB::transaction(function () use ($request, $user) {
                $user->update([

                    'branch_id'     => $request->branch_id,
                    'name'          => $request->name,
                    'email'         => $request->email,
                ]);
            });

        } catch (\Exception $ex) {

            return redirect()->back()->withInput()->withError($ex->getMessage());
        }

        return redirect()->route('permitted.users')->withMessage('User Successfully Updated');
    }




    /*
     |--------------------------------------------------------------------------
     | INDEX METHOD
     |--------------------------------------------------------------------------
    */
    public function index($id)
    {
        $this->hasAccess("permission.accesses.create");     // check permission

        $data['user']               = $user = User::where('employee_id', $id)->where('status', 1)->first();

        $data['user']               = $user;
        $data['modules']            = Module::with('submodules.parent_permissions.permissions')->get();
        $data['companies']          = Company::pluck('name', 'id');

        class_exists('Module\HRM\Models\Department')
            ? $data['departments']        = Department::pluck('name', 'id')
            : $data['departments'] = [];


        class_exists('Module\HRM\Models\Designation')
            ? $data['departments']        = Designation::pluck('name', 'id')
            : $data['departments'] = [];

        $data['isPermitted']        = $user->permissions()->pluck('slug')->toArray();
        $data['hasCompanies']       = $user->companies()->pluck('name')->toArray();
        $data['hasFactories']       = $user->factories()->pluck('name')->toArray();
        class_exists('Module\HRM\Models\Department')
            ?   $data['hasDepartments']     = $user->departments()->pluck('name')->toArray()
            :   $data['hasDepartments']     = [];

        class_exists('Module\HRM\Models\Designation')
            ?   $data['hasDesignations']     = $user->designations()->pluck('name')->toArray()
            :   $data['hasDesignations']     = [];
        $data['hasFeatures']        = PermissionFeature::where('status', 1)->pluck('name')->toArray();
        $data['branches']           = (Schema::hasTable('branches')) ? Branch::pluck('name', 'id') : [];



        class_exists('Module\HRM\Models\Employee\Employee')
            ? $data['employee_ids'] = Employee::whereDoesntHave('user')
                                        ->select('employee_full_id', 'email', 'company_id', 'department_id', 'designation_id', 'id','name')
                                        ->with('department:name,id', 'designation:name,id')
                                        ->get()
            : $data['employee_ids'] = [];


        class_exists('Module\HRM\Models\Employee')
            ? $data['existing_employee']  = Employee::whereHas('user', function ($q) {
                                        $q->where('status', 1);
                                    })
                                    ->get(['employee_full_id', 'id','name'])
            : $data['existing_employee']  = [];

            return $data;
        return view('access.create', $data);
    }












    /*
     |--------------------------------------------------------------------------
     | CREATE METHOD
     |--------------------------------------------------------------------------
    */
    public function create(Request $request)
    {
        $this->hasAccess("permission.accesses.create");     // check permission

        $users_id               = $request->user_id ?? null;

        $data['users']          = User::where('status', 1)->where('id', $users_id)->get();

        $data['modules']        = Module::where('name', '!=', 'Employee Permission')->with('submodules.parent_permissions.permissions')->active()->get();
        $data['companies']      = Company::pluck('name', 'id');


        return view('access/create', $data);
    }












    /*
     |--------------------------------------------------------------------------
     | STORE METHOD
     |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'user_id'    => 'required',
        ]);


        try {

            $user = User::find($request->user_id);

            $user->permissions()->sync($request->permissions);

            return back()->with('message', 'Permission create success');

        } catch (Exception $ex) {

            return back()->with('error', $ex->getMessage());
        }
    }




















    /*
     |--------------------------------------------------------------------------
     | EDIT USER PERMISSION
     |--------------------------------------------------------------------------
    */
    public function edit($id)
    {
        $this->hasAccess("permission.accesses.edit");     // check permission

        $data['user'] = User::find($id);
        $data['isPermitted']            = User::find($id)->permissions()->pluck('slug')->toArray();

        $data['modules']                = Module::where('name', '!=', 'Employee Permission')->with('submodules.parent_permissions.permissions')->active()->get();
        $data['companies']              = Company::pluck('name', 'id');

        return view('access/edit', $data);
    }













    /*
     |--------------------------------------------------------------------------
     | UPDATE METHOD
     |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {

        try {

            $user_created = User::find($id);

            $user_created->permissions()->sync($request->permissions);

            if (auth()->id() == $id) {

                session()->forget('slugs');
            }


            return redirect()->route('permitted.users')->with('message', 'Permission Update Successfull');

        } catch (Exception $ex) {

            return redirect()->back()->with('error', 'Some error, please check');
        }
    }







    /*
     |--------------------------------------------------------------------------
     | DESTROY METHOD
     |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        $user_created = PermissionUser::where('user_id', $id)->delete();

        return redirect()->route('permitted.users')->with('message', 'Permission Deleted Successfully');

    }











    /*
     |--------------------------------------------------------------------------
     | EMPLOYEE LIST BY AJAX
     |--------------------------------------------------------------------------
    */
    public function employee_list(Request $request)
    {
        $employees_info = Employee::with(['company', 'department', 'designation', 'bank_information'])
            ->where('id', $request->id)
            ->orWhere('employee_full_id', $request->id)
            ->where('status', 1)->first();
        return response()->json($employees_info);
    }











    /*
     |--------------------------------------------------------------------------
     | PERMITTED EMPLOYEE LIST
     |--------------------------------------------------------------------------
    */
    public function permittedEmployeeList()
    {
        $employees = Employee::whereStatus(1)
            ->whereIn('company_id', Company::userCompanyId())
            ->whereIn('department_id', Department::userDepartmentId())
            ->whereIn('designation_id', Designation::userDesignationId())
            ->orderBy('name')
            ->select('employee_full_id', 'name')
            ->get();
        return response()->json($employees);
    }











    /*
     |--------------------------------------------------------------------------
     | SHOW EMPLOYEE PERMISSION PANEL
     |--------------------------------------------------------------------------
    */
    public function employeePermission(Request $request)
    {
        $this->hasAccess("permission.accesses.create");     // check permission


        $data['isEmployeePermitted']    = EmployeePermission::with('permission')->get()->pluck('permission.slug')->toArray();
        $data['modules']                = Module::where('name', 'Employee Permission')->with('submodules.parent_permissions.permissions')->active()->get();

        return view('access.employee-permission', $data);
    }











    /*
     |--------------------------------------------------------------------------
     | EMPLOYEE PERMISSION STORE
     |--------------------------------------------------------------------------
    */
    public function employeePermissionStore(Request $request)
    {
        
        $this->hasAccess("permission.accesses.create");     // check permission

        try {


            EmployeePermission::whereNotIn('permission_id', $request->employee_permissions ?? [])->delete();

            $old_employee_permissions = EmployeePermission::pluck('permission_id')->toArray() ?? [];

            $new_items = array_diff(array_filter($request->employee_permissions), $old_employee_permissions);
            $employee_permissions = [];

            foreach ($new_items as $key => $new_item) {

                $employee_permissions[] = [
                    'permission_id' => $new_item
                ];
            }

            if (count($employee_permissions)) {
                EmployeePermission::insert($employee_permissions);
            }

            return back()->with('message', 'Permission assign successfully');
        } catch (Exception $ex) {

            return back()->with('error', $ex->getMessage());
        }
    }









    /*
     |--------------------------------------------------------------------------
     | ADD EMPLOYEE FULL ID IN USER TABLE
     |--------------------------------------------------------------------------
    */
    public function updateEmployeeId($request)
    {
        if ($request->filled('update_type')) {

            $users = User::active()
                        ->whereNotNull('employee_id')
                        ->whereNull('employee_full_id')
                        ->with('employee:id,employee_full_id')
                        ->get();

            foreach($users ?? [] as $user) {

                $user->update(['employee_full_id' => optional($user->employee)->employee_full_id]);
            }
        }
    }


    public function permittedUserList(Request $request){

        $data['users'] = User::whereHas('permissions')
                         ->when($request->filled('name'), function($q) use ($request){
                            $q->where('name', 'like', '%'.$request->name.'%');
                         })->get();

        return view('access/permitted-user', $data);
    }
}
