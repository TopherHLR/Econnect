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
                'eco_action' => $ecoAction && $ecoAction->ecoAction ? [
                    'id' => $ecoAction->ecoAction->action_id,
                    'title' => $ecoAction->ecoAction->title,
                ] : null,
                'eco_topic' => $ecoTopic && $ecoTopic->ecoLibrary ? [
                    'id' => $ecoTopic->ecoLibrary->library_id,
                    'title' => $ecoTopic->ecoLibrary->title,
                ] : null,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }



}
