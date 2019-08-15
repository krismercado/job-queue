<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Task;

class ProcessTask implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    protected $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $start = microtime(true);
        Log::info('Queued to ProcessTask',['task' => $this->task]);
        $this->task->state = 'processing';
        $this->task->save();

        // lets do something random here to process the request
        $this->task->description = strrev($this->task->description);

        $this->task->state = 'completed';
        $this->task->save();

        $end = microtime(true);
        $time = $end - $start;

        Log::info('time to process',[
          'start' => $start,
          'end' => $end,
          'total' => $time
        ]);
    }
}
