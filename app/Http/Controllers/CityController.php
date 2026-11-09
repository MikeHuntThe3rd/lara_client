<?php

namespace App\Http\Controllers;

use App\Services\LarApi;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class CityController extends Controller
{
    private const FIELDS = ['zip_code', 'city', 'population', 'id_county'];

    public function __construct(private LarApi $api)
    {
    }

    public function index(Request $request)
    {
        $body = $this->api->get('/cities', [
            'search'    => $request->input('search'),
            'county_id' => $request->input('county_id'),
            'page'      => $request->input('page'),
        ])->object();

        // Rebuild a paginator so the view's ->links() point at this app, not at the API.
        $cities = new LengthAwarePaginator(
            $body->cities->data,
            $body->cities->total,
            $body->cities->per_page,
            $body->cities->current_page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        $counties = $body->counties;

        return view('cities/index', compact('cities', 'counties'));
    }

    public function create()
    {
        $operation = "Add";
        $method = "POST";
        $data = null;
        $action = route('cities.store');
        $counties = $this->counties();

        return view('cities/modify', compact('operation', 'method', 'data', 'action', 'counties'));
    }

    public function store(Request $request)
    {
        $response = $this->api->post('/city', $request->only(self::FIELDS));

        return redirect()->route('cities.index')->with('status', $response->json('message'));
    }

    public function edit(int $id)
    {
        $operation = "Modify";
        $data = $this->api->get("/city/{$id}")->object()->data;
        $method = 'PATCH';
        $action = route('cities.update', $id);
        $counties = $this->counties();

        return view('cities/modify', compact('data', 'method', 'operation', 'action', 'counties'));
    }

    public function update(Request $request, int $id)
    {
        $response = $this->api->patch("/city/{$id}", $request->only(self::FIELDS));

        return redirect()->route('cities.index')->with('status', $response->json('message'));
    }

    public function destroy(int $id)
    {
        $response = $this->api->delete("/city/{$id}");

        return redirect()->route('cities.index')->with('status', $response->json('message'));
    }

    /** County list for the form's dropdown. */
    private function counties(): array
    {
        return $this->api->get('/counties')->object()->counties;
    }
}
