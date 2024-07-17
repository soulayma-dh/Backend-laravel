<?php 
namespace App\Services;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Maison;
use App\Models\Resident;
class RoleService
{

    public function assignRole($user, Request $request)
    {
        switch ($request->role) {
            case 'admin':
                return $this->assignAdminRole($user,$request);
            case 'tutor':
                return $this->assignTutorRole($user, $request);
            
        }
    }

    protected function assignTutorRole($user, $request)
    {   
        if ($this->verifyResident($request->id_resident, $request->id_maison)) {
        return Role::create([
            'user_id' => $user->id,
            'role' => 'tutor',
            'is_pending' => false 
        ]);
    } else {
        abort(400, 'Verification of Resident failed.');
    }
 
    }

    protected function assignAdminRole($user, $request)
    {   


        $maison = Maison::create([
            'name' => $request->maison_name,
            'adresse' => $request->maison_adresse,
            'is_pending' => true, // Maison en attente de validation par le super admin.
            //'fichier_enregistrement' => $request->file('maison_fichier_enregistrement')->store('maison_files')
        ]);
        $user->maison_id = $maison->_id;
        $user->save();
        // Crée une nouvelle entrée de rôle pour l'admin avec is_pending à true.
        $role = Role::create([
            'user_id' => $user->id,
            'role' => 'admin',
            'is_pending' => true 
        ]);
         
        // Envoyer une notification au super admin pour la validation
       

        return $role;

      
    }

    
    protected function verifyResident($idResident, $idMaison)
    {
        $resident = Resident::where('_id', $idResident)->where('maison_id', $idMaison)->first();
        return $resident ? true : false;
    }
    
    
}