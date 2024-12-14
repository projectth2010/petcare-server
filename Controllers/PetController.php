<?php

namespace Controllers;

use ResponseJSON\ResponseJSON;
use DatabaseDriver\Model\Pet;

class PetController
{

    /**
     * Fetch all pets for DataTables JSON response.
     *
     * @param int $draw - Counter from the DataTable request
     * @param int $start - Starting record (for pagination)
     * @param int $length - Number of records to return (for pagination)
     * @param string $searchValue - Search query if filtering data
     * @return void
     */
    public function gets()
    {
        // Get DataTables parameters from the request
        $draw = isset($_GET['draw']) ? intval($_GET['draw']) : 1;
        $start = isset($_GET['start']) ? intval($_GET['start']) : 0;
        $length = isset($_GET['length']) ? intval($_GET['length']) : 10;
        $searchValue = isset($_GET['search']['value']) ? $_GET['search']['value'] : '';

        // Fetch the total number of records (without filtering)
        $totalRecords = Pet::countAll();

        // Fetch the filtered records if there's a search query
        if ($searchValue) {
            $pets = Pet::search($searchValue, $start, $length);
            $filteredRecords = Pet::countFiltered($searchValue);
        } else {
            $pets = Pet::getAllPaginated($start, $length);
            $filteredRecords = $totalRecords;
        }

        // Build the response for DataTables
        $response = [
            "draw" => $draw,
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $filteredRecords,
            "data" => $pets
        ];

        // Send the response
        ResponseJSON::success($response);
    }

    /**
     * Create a new pet record.
     *
     * @return void
     */
    public function create()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['PetName']) || !isset($data['AccessStatus'])) {
            ResponseJSON::error('Pet Name and Access Status are required.');
            return;
        }

        $newPet = [
            'PetName' => $data['PetName'],
            'AccessStatus' => $data['AccessStatus'],
            'Description' => $data['Description'] ?? null,
            'PetID' => $data['PetID'] ?? null
        ];

        if (Pet::create($newPet)) {
            ResponseJSON::success($newPet, 'Pet created successfully.');
        } else {
            ResponseJSON::error('Failed to create pet.');
        }
    }

    /**
     * Fetch a single pet by ID.
     *
     * @param int $id - ID of the pet to fetch
     * @return void
     */
    public function get($id)
    {
        $pet = Pet::getPetById($id);

        if ($pet) {
            ResponseJSON::success($pet);
        } else {
            ResponseJSON::error('Pet not found.', 404);
        }
    }

    /**
     * Update a pet record by ID.
     *
     * @param int $id - ID of the pet to update
     * @return void
     */
    public function update($id)
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $pet = Pet::getPetById($id);

        if (!$pet) {
            ResponseJSON::error('Pet not found.', 404);
            return;
        }

        $updatedPet = [
            'name' => $data['name'] ?? $pet['name'],
            'species' => $data['species'] ?? $pet['species'],
            'age' => $data['age'] ?? $pet['age'],
            'owner' => $data['owner'] ?? $pet['owner']
        ];

        if (Pet::update($id, $updatedPet)) {
            ResponseJSON::success($updatedPet, 'Pet updated successfully.');
        } else {
            ResponseJSON::error('Failed to update pet.');
        }
    }

    /**
     * Delete a pet by ID.
     *
     * @param int $id - ID of the pet to delete
     * @return void
     */
    public function delete($id)
    {
        if (Pet::delete($id)) {
            ResponseJSON::success([], 'Pet deleted successfully.');
        } else {
            ResponseJSON::error('Failed to delete pet.', 500);
        }
    }
}
