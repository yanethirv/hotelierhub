<?php

namespace App\Http\Controllers\Admin;

use DB;
use Hash;
use App\User;
use App\Hotel;
use App\Position;
use App\UserLoginLog;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

class UsersController extends Controller
{
    protected $tenantName = null;
     /**
    *
    * allow admin only
    *
    */
    public function __construct() {
        $this->middleware(['role:super-admin|admin']);
        //$this->middleware(['role:admin']);

        $hostname  = app(\Hyn\Tenancy\Environment::class)->hostname();
        if ($hostname) {
            $fqdn = $hostname->fqdn;
            $this->tenantName = explode(".", $fqdn)[0];
        }
    }

    /**
     * Display a listing of User.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$users = User::paginate(10);
        //return view('admin.users.index', compact('users'));

        if ($this->tenantName) {
            //dd('tenant');
            $users = \App\Models\Tenant\User::paginate(10);
            return view('admin.users.index', compact('users'));
        }else {
            $users = User::paginate(10);
            return view('admin.users.index', compact('users'));
        }
    }

    /**
     * Display a listing of User.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexLoginLogs()
    {
        $userLoginActivities = UserLoginLog::paginate(10);

        return view('admin.activity.logs', compact('userLoginActivities'));
    }

    /**
     * Show the form for creating new User.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name','name')->all();

        $positions = Position::pluck('name', 'id')->all();

        return view('livewire.admin.users.create', compact('roles', 'positions'));
    }

    /**
     * Store a newly created User in storage.
     *
     * @param  \App\Http\Requests\StoreUsersRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|alpha|max:255',
            'email' => 'required|email|unique:users,email',
            'mobile' => 'required|string|max:20',
            'country' => 'required',
            'password' => 'required|min:5',
            'roles' => 'required',
            'position_id' => 'required',
        ]);

        if ($this->tenantName) {
            //$user = \App\Models\Tenant\User::create(array_merge($request->all(),['password' => bcrypt($request->password)]));
            //$roles = $request->input('roles') ? $request->input('roles') : [];
            //$user->assignRole($roles);

            $input = $request->all();
            $input['password'] = Hash::make($input['password']);
        
            $user = \App\Models\Tenant\User::create($input);
            $user->assignRole($request->input('roles'));

            return redirect()->route('users.index')->with('success', "The $user->name was saved successfully");
        }else {
            //$user = User::create(array_merge($request->all(),['password' => bcrypt($request->password)]));
            //$roles = $request->input('roles') ? $request->input('roles') : [];
            //$user->assignRole($roles);

            $status = 'success';
            $content = 'User Created!';

            $input = $request->all();
            $input['email_verified_at'] = now(); //Carbon instance

            //dd($request->roles);

            $input['password'] = Hash::make($input['password']);

            if ($request->input('position_id') != '1') {
                $input['type'] = 'client';
            }else{
                $input['type'] = 'platform';
            }
            
        
            $user = User::create($input);
            $user->assignRole($request->input('roles'));

            if ($user->type == 'client') {

                $hotel = new Hotel ([
                    'user_id' => $user->id
                ]);
        
                $hotel->save();
            }

            return redirect('users')->with('process_result',['status' => $status, 'content' => $content]);

            //return redirect()->route('users.index')->with('success', "The $user->name was saved successfully");
        }

        //$user = User::create(array_merge($request->all(),['password' => bcrypt($request->password)]));
        //$roles = $request->input('roles') ? $request->input('roles') : [];
        //$user->assignRole($roles);

        //return redirect()->route('users.index')->with('success', "The $user->name was saved successfully");
    }

        /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        $position = Position::select('name')
                            ->where('id', '=', $user->position_id)
                            ->first();

        return view('livewire.admin.users.show',compact('user', 'position'));
    }


    /**
     * Show the form for editing User.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
        $positions = Position::pluck('name', 'id')->all();
        $userPosition = $user->position_id;

        return view('livewire.admin.users.edit', compact('user', 'roles','userRole', 'positions', 'userPosition'));
    }

    /**
     * Update User in storage.
     *
     * @param  \App\Http\Requests\UpdateUsersRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $status = 'success';
        $content = __("Updated User");

        $request->validate([
            'name' => 'required|alpha|max:255',
            'email' => 'required|email|unique:users,email,'.$id,
            'mobile' => 'required|string|max:20',
            'country' => 'required',
            'roles' => 'required',
            'status' => 'required',
            'position_id' => 'required',
        ]);

        $input = $request->all();
 
        $user = User::findOrFail($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();
    
        $user->assignRole($request->input('roles'));

        return redirect('users')->with('process_result',['status' => $status, 'content' => $content]);
    }

    /**
     * Remove User from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('danger', "The $user->name was deleted successfully");
    }

    /**
     * Delete all selected User at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if ($request->input('ids')) {
            $entries = User::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }

}
