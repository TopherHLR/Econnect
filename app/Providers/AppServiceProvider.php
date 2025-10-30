<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\UserPointsHistory;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('account.*', function ($view) {
            if ($user = Auth::user()) {
                $totalPoints = UserPointsHistory::where('user_id', $user->user_id)
                    ->sum('points_change');

                $earnedBadges = 0;
                $badgeLevel = null;

                if ($totalPoints >= 1000) {
                    $earnedBadges = 3;
                    $badgeLevel = '🌿 Eco Legend (1000+ pts)';
                } elseif ($totalPoints >= 500) {
                    $earnedBadges = 2;
                    $badgeLevel = '🌱 Green Guardian (500+ pts)';
                } elseif ($totalPoints >= 200) {
                    $earnedBadges = 1;
                    $badgeLevel = '🌸 Eco Starter (200+ pts)';
                } else {
                    $badgeLevel = 'Keep going! Earn more points to unlock your first badge.';
                }

                $completedQuests = 0;

                $view->with(compact('user', 'totalPoints', 'earnedBadges', 'badgeLevel', 'completedQuests'));
            }
        });
    }
}
