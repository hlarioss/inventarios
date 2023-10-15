<?php

namespace App\Http\Functions;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use Kodeine\Acl\Models\Eloquent\Role;
use Kodeine\Acl\Models\Eloquent\Permission;
use DB;
use Kodeine\Acl\Traits;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Kodeine\Acl\Traits\HasPermission;

class FunctionController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Return user with role
     * @param $user
     * @return mixed
     */

    public static function getUsers()
    {
        $userSelect = ('Select users.id, users.name, users.email, roles.name as role from role_user inner join users
            on users.id=role_user.user_id inner join roles on role_user.role_id=roles.id
            where roles.slug="administrator" or roles.slug="viewer"');
        $results= DB::select($userSelect);
        return $results;
    }


    public static function getRoles()
    {
        $userSelect = ('Select roles.id, roles.name from roles where roles.name!="SuperAdmin"');
        $results= DB::select($userSelect);
        return $results;
    }

    public static function getUser( $user )
    {

        $userSelect = ('Select users.id, users.name, users.email, roles.name as role from role_user inner join users
            on users.id=role_user.user_id inner join roles on role_user.role_id=roles.id
            where users.id = '.$user.' and (roles.slug="administrator" or roles.slug="consulta" or roles.slug="vendedor" or roles.slug="consulta_central")');
        $results= DB::select($userSelect);
        return $results;

    }
    public static function createMaster(  )
    {
        $exists = User::get();
        if( count( $exists ) == 0 )
        {
            $user = new User;
            $user->name = "Demo";
            $user->password = bcrypt('demo');
            $user->email = "demo@inventarios.com";
            $user->save();

            $role = FunctionController::createRole( array(
                "name" => "SuperAdmin",
                "slug" => "superadmin",
                "description" => "manage all privileges"
                ));


            $permission = array( 
                FunctionController::createPermission("users"),
                FunctionController::createPermission("role_user"),
                FunctionController::createPermission("roles"),
                FunctionController::createPermission("permission_role"),
                FunctionController::createPermission("permission_user"),
                FunctionController::createPermission("permissions"),
                FunctionController::createPermission("migrations"),
                FunctionController::createPermission("password_resets"),
                FunctionController::createPermission("bitacoras")
  
                );
            $role->assignPermission(  $permission );
            $user->assignRole($role);
            $role2 = FunctionController::createRole( array(
                "name" => "Administrator",
                "slug" => "administrator",
                "description" => "manage all privileges"
                ));
            $permission2 = array( 

                FunctionController::createPermission("bitacoras")

                );
            $role2->assignPermission($permission2);
            $role3 = FunctionController::createRole( array(
                "name" => "Operador",
                "slug" => "operador",
                "description" => "manage all privileges"
                ));
            $permission3 = array( 

                FunctionController::createPermission("bitacoras")

                );
            $role3->assignPermission($permission3);

            $role4 = FunctionController::createRole( array(
                "name" => "Finanzas",
                "slug" => "finanzas",
                "description" => "manage all privileges"
                ));
            $permission4 = array( 
                FunctionController::createPermission("users"),
                FunctionController::createPermission("role_user"),
                FunctionController::createPermission("roles"),
                FunctionController::createPermission("permission_role"),
                FunctionController::createPermission("permission_user"),
                FunctionController::createPermission("permissions"),
                FunctionController::createPermission("migrations"),
                FunctionController::createPermission("password_resets"),
                FunctionController::createPermission("bitacoras")
              
                );
            $role4->assignPermission($permission4);

            $role5 = FunctionController::createRole( array(
                "name" => "Consulta Central",
                "slug" => "consulta_central",
                "description" => "manage all privileges"
                ));
            $permission5 = array( 
                FunctionController::createPermission("users"),
                FunctionController::createPermission("role_user"),
                FunctionController::createPermission("roles"),
                FunctionController::createPermission("permission_role"),
                FunctionController::createPermission("permissions"),
                FunctionController::createPermissionRead("bitacoras")

                );
            $role5->assignPermission($permission5);
        }
    }
    



    public static function createRole(array $data)
    {
        return Role::create([
            'name' => $data['name'],
            'slug' => $data['slug'],
            'description' => $data['description'],
            ]);
    }

    /**
     * Create a new permission
     * @param $name
     * @return static
     */

    public static function createPermission( $name )
    {
        $permission = new Permission();
        return $permission->create([
            'name'        => $name,
            'slug'        => [          // pass an array of permissions.
            'create'     => true,
            'view'       => true,
            'update'     => true,
            'delete'     => true
            ],
            'description' => 'manage '.$name.' permissions'
            ]);
    }

    public static function createPermissionRead( $name )
    {
        $permission = new Permission();
        return $permission->create([
            'name'        => $name,
            'slug'        => [          // pass an array of permissions.
            'view'       => true
            ],
            'description' => 'manage '.$name.' permissions'
            ]);
    }

    public function assignRole($role)
    {
        return $this->roles()->save(
            Role::whereName($role)->firstOrFail()
            );
    }

}
