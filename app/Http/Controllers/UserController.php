<?php

namespace App\Http\Controllers;

use App\Http\Functions\FunctionController;
use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Kodeine\Acl\Models\Eloquent\Role;
use Kodeine\Acl\Models\Eloquent\Permission;
use Validator;
use Crypt;
use Illuminate\Support\Facades\Input;
use Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Dispatcher;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{

    /**
     * Return the view to create a new admin
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $rolesArrays = FunctionController::getRoles();
        $users = FunctionController::getUsers();
        return view("users.index" , compact( "users", "rolesArrays"));
    }

    public function getName( User $user )
    {
        $user = User::where( "users.id" , "=" , $user->id )
                    ->join( "role_user" , "user_id" , "=" , "users.id" )
                    ->join( "roles" , "role_id" , "=" , "roles.id" )
                    ->select( "users.id", "users.name" , "users.email", "slug", "roles.name as role" )
                    ->get()
                    ->first();
        return Response::json( $user );
    }

    /**
     * Get the user names by the ID
     * @param Request $request
     * @return mixed
     */
    public function getNames( Request $request )
    {
        $return = array();
        $items  = $request["selected_items"];
        for( $i = 0; $i < count( $items ) ; $i++ )
        {
            $name = User::where( "id" , "=" , $items[$i] )->get()->first()->name;
            array_push( $return , $name );
        }
        return Response::json( $return );
    }

    /**
     * Get the JSON data to the DataTable
     * @param Request $params
     * @return mixed
     */
    public function getJson( Request $params )
    {

        $api_Result = array();
        // Create a mapping of our query fields in the order that will be shown in datatable.
        $columnsMapping = array("users.id", "users.name","email", "roles.name", "users.created_at");

        // Initialize query (get all)
        $userQueriable = DB::table('users');
        $user_Result['recordsTotal'] = $userQueriable->count();
        $user_Result['recordsTotal'] = $user_Result['recordsTotal'] - 1;

        $createdAtQueryString       = '(select DATE_FORMAT(users.created_at, "%Y-%m-%d %h:%i:%s %p"))';

        $query = 'Select users.id as id, users.name as name, users.email, roles.name as role, '.$createdAtQueryString.' as date
        from role_user
        inner join users on users.id=role_user.user_id inner join roles on role_user.role_id=roles.id
        where (roles.slug="administrator" or roles.slug="operador" or roles.slug="finanzas" or roles.slug="consulta_central") ';

        //Filters
        $where = "";
        if (isset($params->search['value']) && !empty($params->search['value'])){

            foreach ($columnsMapping as $column) {
                if ($column == 'users.created_at') {
                    if (strlen($where) == 0) {
                        $where .=" and (".$createdAtQueryString." like  '%".$params->search['value']."%' ";
                    } else {
                        $where .=" or ".$createdAtQueryString." like  '%".$params->search['value']."%' ";
                    }
                }
                else
                {
                    if (strlen($where) == 0) {
                        $where .=" and (".$column." like  '%".$params->search['value']."%' ";
                    } else {
                        $where .=" or ".$column." like  '%".$params->search['value']."%' ";
                    }
                }

            }
            $where .= ') ';
        }
        $query = $query . $where;

        // Sorting
        $sort = "";
        foreach ($params->order as $order) {
            if (strlen($sort) == 0) {
                $sort .= 'order by ' . $columnsMapping[$order['column']] . ' '. $order['dir']. ' ';
            } else {
                $sort .= ', '. $columnsMapping[$order['column']] . ' '. $order['dir']. ' ';
            }
        }
        $result = DB::select($query);
        $user_Result['recordsFiltered'] = count($result);

        $filter = " limit ".$params->length." offset ".$params->start."";

        $query .= $sort . $filter;
        // var_dump($result);
        $result = DB::select($query);
        $user_Result['data'] = $result;

        return Response::json( $user_Result );
    }

    /**
     * Verify the email and the name to update the user
     * @param User $user
     * @param Request $request
     * @return mixed
     * @throws \Illuminate\Foundation\Validation\ValidationException
     */

    public function getInformationByUser( User $user )
    {

        $userData['name']= Auth::user()->name;
        $userData['email']= Auth::user()->email;
        return Response::json($userData);
    }



    public function update( User $user, Request $request )
    {
        if( $user->email != $request["email"]  )
            $validator = $this->updateValidator($request->all());
        else
            $validator = $this->updateValidatorWithoutEmail($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
                );
        }

        return Response::json( $this->updateUser( $user , $request->all() ) );
    }


    /**
     * Update an user in the database
     * @param User $user
     * @param array $data
     * @return User
     */
    public function updateUser( User $user , array $data )
    {
        $id= $user->id;
        $user->name = $data["name"];
        $user->email = $data["email"];
        $user->save();
        $roleAdmin = $data["role"];
        $updateRole = ('update role_user set role_id = '.$roleAdmin.' where user_id= '.$id.'');
        $results= DB::update($updateRole);
        $user->role = $data['role'];

        return $user;
    }

    /**
     * Create a new user
     * @param $request
     * @throws \Illuminate\Foundation\Validation\ValidationException
     */

    public function createUser( $request )
    {
        $validator = $this->validator($request->all());
        $roleAdm = $request->role;

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
                );
        }
        $user = $this->create($request->all() );    


        $action='Creación de Usuario';
        $bitacora = HomeController::bitacora($action);

        if($roleAdm == "2")
        {
            $user->assignRole( $roleAdm );
        }
        else if($roleAdm == "3"){
            $user->assignRole($roleAdm);
        }
        else if($roleAdm == "4"){
            $user->assignRole($roleAdm);
        }
        else if($roleAdm == "5"){
            $user->assignRole($roleAdm);
        }
        return $user;
    }

    /**
     * Create a new admin
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Foundation\Validation\ValidationException
     */
    public function store( Request $request )
    {
        $user = FunctionController::getUser($this->createUser( $request )->id);

        //return redirect('/user');
        return Response::json( $user );

    }

    /** Verify if the role exists or not
     * @param $name
     * @return mixed
     */
    public function verifyRole( $name )
    {
        return Role::where("name","=",$name)->get();
    }


    /**
     * Delete multiple users
     * @param Request $request
     * @return mixed
     */
    public function multipleDestroy( Request $request )
    {
        $user= Auth::user()->password;

        if ($request["password_delete"] == "")
        {
            $response["password_delete"]  = "The contraseña es requeridad";
            return Response::json( $response  , 422 );
        }
        else if( password_verify( $request["password_delete"] , $user))
        {
            $users = $request["id"];
            for( $i = 0; $i < count( $users ) ; $i++ )
            {
                $userToDelete = User::where( "id" , "=" , $users[$i] );
                $userToDelete->delete();
            }
            $response["response"] = "El registro ha sido borrado";
            return Response::json( $response );
        }
        else {
            $response["password_delete"] = "La contraseña no coincide";
            return Response::json( $response  , 422 );
        }
    }

    /**
     * Delete an user
     * @param User $user
     */
    public function destroy( User $user, Request $request)
    {
        $user1= Auth::user()->password;

        if ($request["password_delete"] == "")
        {
            $response["password_delete"]  = "La contraseña es requerida";
            return Response::json( $response  , 422 );
        }
        else if( password_verify( $request["password_delete"] , $user1))
        {
            $user->delete();
            $response["response"] = "El registro ha sido borrado";
            return Response::json( $response );
        }
        else {
            $response["password_delete"] = "La contraseña no coincide";
            return Response::json( $response  , 422 );
        }

    }

    /**
     * @param User $user
     * @param Request $request
     * @return mixed
     * @throws \Illuminate\Foundation\Validation\ValidationException
     */


    public function changeInformation ( User $user , Request $request) {

        $validator = $this->validatorProfile($request->all());
        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
                );
        }

        $user1= Auth::user()->id;
        $exists = User::where("id","!=",$user1)
        ->where("email","=",$request["old_email"])
        ->get();

        if( count($exists) == 0 )
        {
            $user->name = $request['old_name'];
            $user->email = $request['old_email'];
            $user->save();
            $response["response"] = "La información ha sido cambiada";
        }
        else
        {
            $response["old_email"] = "El correo electrónico existe actualmente";
            return Response::json( $response, 422 );
        }
        return ($response);

    }
    public function changePassword( User $user , Request $request)
    {
        $response = [];
        $validator = $this->validatorPassword($request->all());
        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
                );
        }
        if( password_verify( $request["old_password"] , $user->getAuthPassword() ) )
        {
            $validator = $this->validateNewPassword($request->all());
            if ($validator->fails()) {
                $this->throwValidationException(
                    $request, $validator
                    );
            }
            if ( $request["new_password"] == $request["old_verify"] ) {
                $user->password = bcrypt( $request["new_password"] );
                $user->save();

                $response["response"] = "La contraseña ha sido cambiada";
                return Response::json( $response );
            } else {
                $response["old_verify"] = "La contraseña de confirmación no coincide";
                return Response::json( $response  , 422 );
            }
        }
        else {
            $response["old_password"] = "La contraseña no coincide";
            return Response::json( $response  , 422 );
        }
    }


    /**
     * Verify the password field
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validateNewPassword(array $data)
    {
        return Validator::make($data, [
            'new_password' => 'required|min:6|max:255'
            ]);
    }


    protected function validatorPassword(array $data)
    {
        return Validator::make($data, [
            'new_password' => 'required|min:6|max:255',
            'old_password' => 'required',
            'old_verify' => 'required',
            ],
            $messages = [
            'required' => 'El campo es requerido',
            'min' => 'El minimo son 6 caracteres',
            ]);
    }

    /**
     * Validate the email
     * @param array $data
     * @return mixed
     */
    protected function validateEmail( $email )
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            return false;

        return true;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function updateValidatorWithoutEmail(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255'
            ]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function updateValidator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            ]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6',
            ],
            $messages = [
            'confirmed' => 'La contraseña de confirmación no coincide',
            ]
            );
    }

    protected function validatorProfile(array $data)
    {
        return Validator::make($data, [
            'old_name' => 'required|max:255',
            'old_email' => 'required|email|max:255',
            ],
            $messages = [
            'required' => 'El campo es requerido',
            'email' => 'El correo electrónico no es válido',
            ]
            );
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            ]);
    }

}
