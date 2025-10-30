<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserPointsHistory;
use Illuminate\Support\Facades\Auth;

class EcoController extends Controller
{
    
    public function getRandomWidgets()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        try {
            $ecoAction = \App\Models\UserEcoAction::with('ecoAction')
                ->where('user_id', $user->user_id)
                ->inRandomOrder()
                ->first();

            $ecoTopic = \App\Models\UserLibrary::with('ecoLibrary')
                ->where('user_id', $user->user_id)
                ->inRandomOrder()
                ->first();

            return response()->json([
                'eco_action' => $ecoAction?->ecoAction?->title ?? 'No saved actions yet',
                'eco_topic'  => $ecoTopic?->ecoLibrary?->title ?? 'No saved topics yet',
            ]);
        } catch (\Exception $e) {
            // Catch the actual problem
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }

}
