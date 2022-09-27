<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Task;
use App\Models\Stage;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class TrelloController extends Controller
{
    public function index()
    {
        $stages = Stage::query()->with('tasks')->get();

        foreach ($stages AS $key => $stage) 
        {   
            $id = $stage->id;         
            $name = $stage->stage;

            $cards[$key] = [
                'id' => $id,
                'name' => $name
            ];

            $cards[$key]['tasks'] = [];

            //Busca todas as tasks do relacionamento vindo na query 
            $tasks = $stage->tasks;

            foreach ($tasks AS $task)
            {
                array_push($cards[$key]['tasks'], 
                [
                    'id'    => $task->id,
                    'order'  => $task->order,
                    'title'   => $task->title,
                    'stage_id' => $task->stage_id
                ]);
            }

            $order = array_column($cards[$key]['tasks'], 'order');

            array_multisort($order, $cards[$key]['tasks']);

            $next_orders[$name] = end($cards[$key]['tasks'])['order'] + 1;
        }

        //dd($cards);

        //dd($cards);

        return Inertia::render('AppTrello', ['cards' => $cards, 'next_orders' => $next_orders]);
    }

    public function store(Request $request)
    {
        //dd($request);

        $task = new Task;

        if ($request->post('id'))
        {
            $task = Task::where('id', $request->post('id'))->firstOrFail();

            if ($request->post('delete'))
            {
                $task->delete();
                return true;
            }

        }

        $task->order    = $request->post('order');
        $task->title    = $request->post('title');
        $task->stage_id = $request->post('stage_id');

        $task->save();

    }

    public function storeOrder(Request $request)
    {
        //dd($request);
        if (!$request->post('cards'))
        {
            return false;
        }

        $cards = $request->post('cards');

        foreach ($cards AS $order => $infos) 
        {
            $task_id = $infos['task'];
            $stage_id = $infos['card'];

            if ( $order > 1 && ($stage_id != $cards[$order - 1]['card']) ) 
            {
                $order = 0;
            }

            Task::where('id', $task_id)
                ->update(['order' => $order, 'stage_id' => $stage_id ]);

        }

    }
}
