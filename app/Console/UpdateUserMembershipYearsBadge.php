<?php

namespace App\Console\Commands;

use App\Models\Badge;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateUserMembershipYearsBadge extends Command
{
    protected $signature = 'app:update-user-membership-years-badge';

    protected $description = 'This command is to update membership years badge for users';

    public function handle()
    {
        $membershipYearsBadges = Badge::membershipYearsBadge()->get();

        foreach ($membershipYearsBadges as $badge) {
            $users = User::whereDoesntHave('badges', function ($query) use ($badge) {
                $query->where('badge_id', $badge->id);
            })->where('created_at', '<=', Carbon::now()->subYears($badge->membership_years))
                ->active()
                ->get();

            foreach ($users as $user) {
                $user->addBadge($badge);
            }
        }

        $this->info('User membership years badge has been updated successfully');
    }
}
