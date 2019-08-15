<?php

namespace App\Http\Controllers;

use App\Task;
use App\Jobs\ProcessTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $user = Auth::user();
      return view('welcome',['user' => $user->name]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
      $tasks =  Task::all();
      return view('tasks',['tasks' => $tasks]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('create-task',['msg' => '']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function store(Request $request, Task $task)
     {
       // Get the currently authenticated user
        $user = Auth::user();
       // Get the currently authenticated user's ID
        $submitter_id = Auth::id();

       // validate input
       $validated = $request->validate([
         'title' => 'required|min:5',
         'description' => 'required|min:5',
         'priority' => 'required'
       ]);

       // store list of jobs
        $task->submitter_id = $submitter_id;
        $task->title = request('title');
        $task->description = request('description');
        $task->priority = request('priority');
        $task->state = 'pending'; // pending, queued, processing, done

        $task->save();

       $msg = "$user->name, Please save your Job ID: $task->id";

       return view('create-task', ['msg' => $msg]);
     }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $task = DB::table('tasks')
              ->where('id', '=', $id)
              ->get();

      unset($task->created_at);
      unset($task->updated_at);

      print_r(json_encode($task));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
      //this is manually but we've applied a route model binding
      return view('edit-task',['task' => $task, 'msg' => '']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
      $validated = $request->validate([
        'title' => 'required|min:5',
        'description' => 'required|min:5',
        'priority' => 'required'
      ]);

      $task->state = 'pending';

      $task->update($validated);

      return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
