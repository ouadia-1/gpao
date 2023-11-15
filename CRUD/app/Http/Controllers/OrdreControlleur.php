<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OF;

class OrdreControlleur extends Controller
{
    public function index()
    {
        return view('OF');
    }

    public function store(Request $request)
    {
        $data = $request->except('_token');

        // Process and save the data to the database as needed
        foreach ($data as $row) {
            OF::create([
                'numero_of' => $row[0],
                'date_creation' => $row[1],
                'client' => $row[2],
                'designation' => $row[3],
                'qte' => $row[4],
                'caracteristiques' => $row[5],
                'etat' => $row[6],
            ]);
        }

        return redirect('/')->with('success', 'Data saved successfully.');
    }
}
