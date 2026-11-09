<?php

namespace App\Http\Controllers;

use App\Services\LarApi;
use Illuminate\Http\Request;

class CountyController extends Controller
{
    public function __construct(private LarApi $api)
    {
    }

    public function index(Request $request)
    {
        $counties = $this->api
            ->get('/counties', ['search' => $request->input('search')])
            ->object()
            ->counties;

        return view('counties/index', compact('counties'));
    }

    public function create()
    {
        $operation = "Add";
        $method = "POST";
        $data = null;
        $action = route('counties.store');

        return view('counties/modify', compact('operation', 'method', 'data', 'action'));
    }

    public function store(Request $request)
    {
        // Validation is done by the API; a 422 is turned into a redirect-back with errors.
        $response = $this->api->post('/county', $request->only(['name', 'badge']));

        return redirect()->route('counties.index')->with('status', $response->json('message'));
    }

    public function edit(int $id)
    {
        $operation = "Modify";
        $data = $this->api->get("/county/{$id}")->object()->data;
        $method = 'PATCH';
        $action = route('counties.update', $id);

        return view('counties/modify', compact('data', 'method', 'operation', 'action'));
    }

    public function update(Request $request, int $id)
    {
        $response = $this->api->patch("/county/{$id}", $request->only(['name', 'badge']));

        return redirect()->route('counties.index')->with('status', $response->json('message'));
    }

    public function destroy(int $id)
    {
        $response = $this->api->delete("/county/{$id}");

        return redirect()->route('counties.index')->with('status', $response->json('message'));
    }
}
