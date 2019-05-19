<?php

namespace App\Http\Controllers;


    use Illuminate\Http\Request;
    use App;


class AdminController extends Controller
{

    public function all(Request $request)
    {
        /**$t = $request->input('t');*/
        $sortBy = $request->input('sortBy');
        $direction = $request->input('direction');
        if ($sortBy === 'ID')
            $sortBy = 'id '  .$direction;
        if ($sortBy === 'Name')
            $sortBy = 'name ' .$direction;
        if ($sortBy === 'Email')
            $sortBy = 'email ' .$direction;
        if ($sortBy === 'Right')
            $sortBy = 'right_name ' .$direction;

        $limit = $request->input('limit');
        $count = App\Admin::all()->count();
        $users = App\Admin::when($sortBy, function ($query) use ($sortBy) {
            return $query->orderByRaw($sortBy);
        })->paginate($limit);
        return view('users', compact('users', 'count'));
    }

    public function update_user(Request $request)
    {
        $id = $request->input('dataRow.id');
        $name = $request->input('dataRow.name');
        $email = $request->input('dataRow.email');
        $id_right = $request->input('dataRow.id_right');

        $affectedRows = App\Admin::where('id', '=', $request->input('dataRow.id') )->
        update([ 'id' => $id,
            'name' => $name,
            'email' => $email,
            'id_right' => $id_right]);
        //сколько строк проапдейтилось
        if ($affectedRows)
            return 'success';
        else
            return false;
    }

    public function delete_user(Request $request)
    {
        $id = $request->input('dataRow.id');
        $deleteUser = App\Admin::where('id', '=', $id)->delete();

        if($deleteUser)
            return $deleteUser;
        else
            return false;
    }

    public function validateEmail($email){
        preg_match('~^.{1,60}@.{1,20}\..{1,10}$~', $email);
    }
}