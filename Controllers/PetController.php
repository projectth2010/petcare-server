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
}
