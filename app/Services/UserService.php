<?php
namespace App\Services;
use App\Models\User;
use Spatie\Permission\Models\Role;
use DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
class UserService {
    public function __construct() {}
    public function users(string $view_deleted = null): LengthAwarePaginator 
    {
        $users = User::with('roles')->exceptCurrentUser()->latest();

        if($view_deleted) 
        {
            $users->onlyTrashed();
        }

        $users = $users->paginate(20);
        return $users;
    }

    public function roles(): Collection 
    {
        return Role::all();
    }

    public function store(array $data): User
    {
        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'address' => $data['address'],
            'phone_number' => $data['phone_number'],
            'email' => $data['email'],
            'password' => bcrypt($data['password'])
        ]);

        $user->assignRole($data['role']);
        return $user;
    }

    public function restore(int $id): bool
    {
        User::withTrashed()->findOrFail($id)->restore();
        return true;
    }

    public function restoreAll() 
    {
        return tap(User::onlyTrashed()->restore());
    }

    public function forceDelete(int $id): bool 
    {
        return tap(User::withTrashed()->findOrFail($id)->forceDelete());
    }

    public function forceDeleteAll() 
    {
        return tap(User::onlyTrashed()->forceDelete());
    }

    public function upsert(array $data, int $id = null) 
    {
        try {
            DB::beginTransaction();

                if($id) {
                    DB::table('model_has_roles')->where('model_id', $id)->delete();
                }
                
                $user = User::findOrFail($id);
                $user->first_name = $data['first_name'];
                $user->last_name = $data['last_name'];
                $user->address = $data['address'];
                $user->phone_number = $data['phone_number'];
                $user->email = $data['email'];

                if(isset($data['password']) && !empty($data['password'])) {
                    $user->password = bcrypt($data['password']);
                }

                $user->save();

                $user->assignRole($data['role']);
            DB::commit();
            return $user;
        } catch(\Exception $e) {
            DB::rollBack();
            abort(400, $e->getMessage());
        }
       
    }
}