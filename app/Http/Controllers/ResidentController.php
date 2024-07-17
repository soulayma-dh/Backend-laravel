<?php

namespace App\Http\Controllers;

use App\Services\ResidentService;
use App\Models\Resident;
use Validator;
use Illuminate\Http\Request;

class ResidentController extends Controller
{
    protected $residentService;
    public function __construct(ResidentService $residentService)
    {
        $this->residentService = $residentService;
    }

    public function index()
    {
        return response()->json([
            $this->residentService->getAllResidents(),
            "success" => true,
            "message" => "Resident List",
        ]);
    }

    public function show($id)
    {
        $resident = $this->residentService->getResidentById($id);

        if (is_null($resident)) {
            return response()->json([
                'success' => false,
                'message' => 'Resident not found.',
            ], 404);
        }
        return response()->json([
            "success" => true,
            "message" => "Resident retrieved successfully.",
            "data" => $resident
        ], 200);
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required|string|max:100',
            'age' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error.',
                'errors' => $validator->errors()
            ]);
        }

        $resident = $this->residentService->createResident($input);

        return response()->json([
            $resident,
            "success" => true,
            "message" => "Resident created successfully.",
        ], 201);
    }


    public function update(Request $request, Resident $resident)
    {
        $input = $request->only(['name', 'age']);

        $validator = Validator::make($input, [
            'name' => 'sometimes|required|string|max:255',
            'age' => 'sometimes|required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $updatedResident = $this->residentService->updateResident($resident, $input);
        return response()->json($updatedResident);
    }
    

    public function destroy(Resident $resident)
    {
        $deleted = $this->residentService->deleteResident($resident);
        
        if ($deleted) {
            return response()->json(['message' => 'Resident deleted successfully']);
        }
        return response()->json(['message' => 'Resident not found'], 404);
    }
}
