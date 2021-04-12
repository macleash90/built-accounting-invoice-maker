<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class UsersController extends Controller
{
    public function index()
    {
        return view('users.index.index');
    }

    public function paginate(Request $request)
    {
        $search_key = $request->search['value'] ?? '';
        $status = $request->status;

        $query = User::select("id", "name", "email", "is_active", "created_at")
            ->orderBy("name", "ASC");

        if (!empty($status)) {
            if ($status == 1) {
                $query->where("is_active", 1);
            } elseif ($status == 2) {
                $query->where("is_active", 0);
            }
        }

        if (!empty($search_key)) {
            $query->where(function ($k) use ($search_key) {
                $k->where('name', 'like', '%' . $search_key . '%')
                    ->orWhere('email', 'like', '%' . $search_key . '%');
            });
        }

        return Datatables::of(
            $query
        )

            ->editColumn('created_at', function (User $user) {
                return date2sql($user->created_at);
            })
            ->addColumn('actions', function () {
                return null;
            })
            // ->setRowData([
            //     'data-id' => function($user) {
            //         return $user->email;
            //     },
            //     'data-name' => function($user) {
            //         return $user->name;
            //     },
            // ])
            ->setRowId(function ($user) {
                return $user->id;
            })
            
            ->make(true);
    }

    public function disableAccount($id)
    {
        $user = User::findOrFail($id);
        $user->is_active = 0;
        $user->save();
        return response()->json(["status" => "success", "message" => "User Account Successfully de-activated"]);
    }

    public function enableAccount($id)
    {
        $user = User::findOrFail($id);
        $user->is_active = 1;
        $user->save();
        return response()->json(["status" => "success", "message" => "User Account Successfully Activated"]);
    }
}
