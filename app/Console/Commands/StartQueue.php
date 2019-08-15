<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Jobs\ProcessTask;
use App\Task;
class StartQueue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'start:queue {priority}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initiate priority queue: [ normal, low, medium, high ]';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        switch($this->argument('priority')){
          case 'normal':
            $priority = 0;
            break;
          case 'low':
            $priority = 1;
            break;
          case 'medium':
            $priority = 2;
            break;
          case 'high':
            $priority = 3;
            break;
        }

        Log::info('Command executed',['priority' => $this->argument('priority').":".$priority]);

        // lets pull all pending jobs based on priority args passed
        if ( $priority > 0) {
          $tasks = DB::table('tasks')
                  ->where('priority', '=', $this->argument('priority'))
                  ->where('state', '=', 'pending') // pending, queued, processing, done
                  ->orderByRaw('updated_at - created_at DESC')
                  ->get();
        }
        else { // if normal queue, we pull all pending job and order by submission and priority
          $tasks = DB::table('tasks')
                  ->where('state', '=', 'pending') // pending, queued, processing, done
                  ->orderByRaw('created_at - priority DESC')
                  ->get();
        }

        // lets queue each tasks
        $tasks->each(function($task){
              Log::info('Tasks: '.json_encode($task));
              $task = Task::findOrFail($task->id);
              $task->state = 'queued';
              $task->save();

              dispatch(new ProcessTask($task));
        });


    }
}
