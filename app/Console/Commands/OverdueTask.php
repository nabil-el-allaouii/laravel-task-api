<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Task;
use Illuminate\Console\Command;
use App\Notifications\TaskOverdue;

class OverdueTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:overdue-task';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::now();
        $tasks = Task::where('due_date', '<',$today)->where('status','!=','completed')->get();
        foreach($tasks as $task){
            $task->user->notify(new TaskOverdue($task));
            $this->info('Task Overdue For '.$task->user->name);
        }
        $this->info('Task Overdue Email Sent');
    }
}
