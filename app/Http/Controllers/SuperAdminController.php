<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Maison;
use App\Models\Role;


class SuperAdminController extends Controller
{
    public function approveMaison(Request $request, $id)
    {
        $maison = Maison::findOrFail($id);
        $maison->is_pending = false;
        $maison->save();

        // Mettre à jour le rôle admin associé pour is_pending à false
        Role::where('user_id', $maison->user_id)->where('role', 'admin')->update(['is_pending' => false]);

        return response()->json(['message' => 'Maison approved and admin role updated'], 200);
    }

    public function rejectMaison(Request $request, $id)
    {
        $maison = Maison::findOrFail($id);
        $maison->delete();

        // Supprimer le rôle admin associé
        Role::where('user_id', $maison->user_id)->where('role', 'admin')->delete();

        return response()->json(['message' => 'Maison rejected and admin role removed'], 200);
    }
}

