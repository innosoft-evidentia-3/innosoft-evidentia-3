<?php

namespace App\Http\Controllers;

use App\Exports\MyEvidencesExport;
use App\Models\Comittee;
use App\Models\Task;
use App\Models\File;
use App\Models\Proof;
use App\Rules\CheckHoursAndMinutes;
use App\Rules\MaxCharacters;
use App\Rules\MinCharacters;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class TaskController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checkroles:PRESIDENT|COORDINATOR|REGISTER_COORDINATOR|SECRETARY|STUDENT');
    }

    public function view($instance,$id)
    {
        $instance = \Instantiation::instance();
        $task = Task::find($id);

        return view('task.view',
            ['instance' => $instance, 'task' => $task]);
    }

    public function list()
    {

        $comittees = Comittee::all();
        $tasks = Task::where(['user_id' => Auth::id()])->get();
        $instance = \Instantiation::instance();

        return view('task.list',[
            'comittees' => $comittees,
            'tasks' => $tasks,
            'instance' => $instance
        ]);
    }

    public function create()
    {

        $comittees = Comittee::all();
        $tasks = Task::where(['user_id' => Auth::id()])->get();
        $instance = \Instantiation::instance();

        return view('task.list',[
            'comittees' => $comittees,
            'tasks' => $tasks,
            'instance' => $instance
        ]);
    }

    public function draft(Request $request)
    {
        return $this->new($request,"DRAFT");
    }

    public function publish(Request $request)
    {
        return $this->new($request);
    }

    private function new($request,$status)
    {

        $instance = \Instantiation::instance();

        $task = $this->new_task($request,$status);

        return redirect()->route('task.list',$task)->with('success', 'Tarea creada con éxito.');

    }

    private function new_task($request,$status)
    {

        $request->validate([
            'title' => 'required|min:5|max:255',
            'start_date' => 'required|date_format:"Y-m-dH:i"',
            'end_date' => 'required|date_format:"Y-m-dH:i"',
            'description' => ['required',new MinCharacters(10),new MaxCharacters(20000)],
        ]);

        // datos necesarios para crear tareas
        $user = Auth::user();

        // creación de una nueva tarea
        $task = Task::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'hours' => $request->input('hours'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'user_id' => $user->id,
            'comittee_id' => $request->input('comittee')
        ]);

        $task->save();

        return $task;
    }

    /****************************************************************************
     * EDIT A TASK
     ****************************************************************************/

    public function edit($instance,$id)
    {
        $user = Auth::user();
        $instance = \Instantiation::instance();
        $token = session()->token();

        $task = Task::find($id);
        $comittees = Comittee::all();

        $tmp = $instance.'/tmp/'.$user->username.'/'.$token.'/';

        Storage::deleteDirectory($tmp);

        // generamos un nuevo token
        session()->regenerate();


        return view('task.edit', ['task' => $task, 'instance' => $instance,
            'comittees' => $comittees,
            'route_save' => route('task.save',$instance)]);
    }


    private function save($request)
    {
        $instance = \Instantiation::instance();
            
        // tarea desde la que hemos decidido partir
        $task_previous = Evidence::find($request->_id);

        // creamos la nueva tarea a partir de la seleccionada para editar
        $task_new = $this->new_task($request,$status);

        $evidence_new->save();

        // copiamos ahora los archivos de la carpeta temporal a la nueva evidencia
        $this->save_files($request,$evidence_new);

        return redirect()->route('task.list', $instance)->with('success', 'Evidencia publicada con éxito.');
    }

    /****************************************************************************
     * REMOVE A TASK
     ****************************************************************************/

    public function remove(Request $request)
    {
        $id = $request->_id;
        $task = Task::find($id);
        $instance = \Instantiation::instance();

        $task->delete();

        return redirect()->route('task.list',$instance)->with('success', 'Tarea borrada con éxito.');
    }
}
