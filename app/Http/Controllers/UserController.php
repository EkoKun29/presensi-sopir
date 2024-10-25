<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(){
        $user = User::query()->orderby('id','desc')->paginate(10);

        return view('tambah-user.index', compact('user'));
    }

    public function create(){
        // return view('user.create');
    }

    public function store(Request $request){
        $user                           = new User();
        $user->name                     = $request->nama;
        $user->email                    = $request->email;
        $user->password                 = Hash::make($request->password);
        $user->role                     = $request->role;
        $user->save();
        return redirect()->route('tambah-user.index')->with('success', 'User berhasil di tambahkan');
    }

    public function delete($id)
    {
    $user = User::findOrFail($id); // Find the resource by its ID or throw a 404 error if not found
    $user->delete(); // Delete the resource
    return redirect()->back()->with('success', 'Data berhasil dihapus');
    }

    public function search(Request $request)
    {
        if ($request->has('search')) {
            $searchTerm = $request->search;

            $user = User::where(function ($query) use ($searchTerm) {
                $query->where('name', 'like', '%' . $searchTerm . '%')
                ->orWhere('email', 'like', '%' . $searchTerm . '%')
                    ->orWhere('role', 'like', '%' . $searchTerm . '%');
            })
            ->paginate(10);

            // Keep the search term when paginating
            $user->appends(['search' => $searchTerm]);
        } else {

        }

        return view('tambah-user.index', compact('user'))->with('i', (request()->input('page', 1) - 1) * 10);
    }
}
