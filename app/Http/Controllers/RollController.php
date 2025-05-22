<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RollController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dices = [
        'dice1' => rand(1, 6),
        'dice2' => rand(1, 6),
    ];
        return response()->json($dices);
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    return response()->json([
        'name' => 'Nord-Salten Kraft AS',
        'address' => 'Strandveien 2, 8276 Ulvsvåg',
        'working_hours' => 'kl 08.00 - 15.00',
        'phone' => '75 77 10 00',
        'email' => 'firmapost@nordsaltenkraft.no',
        'website' => 'nordsaltenkraft.no',
        'description' => 'Konsernet Nord-Salten Kraft har lange og sterke tradisjoner i Hamarøy, Steigen, Sørfold og tidligere Tysfjord kommune. ',
        'social_media' => [
            'instagram' => 'https://www.instagram.com/nordsaltenkraft',
            'facebook' => 'https://www.facebook.com/profile.php?id=100057613142996',
        ],
    ]);
}

    public function status()
{
    return response()->json([
        'status' => 'active'
    ]);
}

    public function external()
    {
        $baseUrl = 'https://api.unsplash.com';
        $key = 'Ck236-dT41svCXU7X0tHbfGI08o5c_etxUUk60GR53U';
        $path = '/photos/random';

        $response = Http::withHeaders([
            'Authorization' => 'Client-ID ' . $key
        ])->get($baseUrl . $path);

        return response()->json($response->json());
        //
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
