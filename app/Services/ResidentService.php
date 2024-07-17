<?php
namespace App\Services;

use App\Models\Resident;
use Illuminate\Http\Request;
use Validator;

class ResidentService
{

    public function getAllResidents()
    {
        return Resident::all();
    }

    public function createResident($input)
    {
        return Resident::create($input);
    }

    public function getResidentById($id)
    {
        return Resident::find($id);
    }


    public function updateResident(Resident $resident, $data)
    {
        $resident->update($data);
        return $resident;
    }
    
    public function deleteResident(Resident $resident)
    {
        return $resident->delete();
    }

}
