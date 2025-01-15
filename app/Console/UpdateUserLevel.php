<?php

namespace App\Console\Commands;

use App\Models\Level;
use App\Models\User;
use Illuminate\Console\Command;

class UpdateUserLevel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-user-level';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is for updating the user level badges';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::active()->get();

        foreach ($users as $user) {
            $userRating = $user->rating;

            $level = Level::where('points', '<=', $userRating)
                ->orderBy('points', 'desc')
                ->with('badge')
                ->first();

            if ($level && $level->badge) {
                $user->addBadge($level->badge);
            }
        }

        $this->info('User levels updated successfully');
    }
}
