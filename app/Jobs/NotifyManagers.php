<?php

namespace App\Jobs;

// use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\User;
use App\Notifications\RegularUserJobCreated;

class NotifyManagers extends Job
{

    protected $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data = [])
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = $this->data;
        $users = User::where('is_manager', true)->get();
        if ($users) {
            foreach ($users as $user) {
                $user->notify(new RegularUserJobCreated($data));
            }
        }
    }
}
