<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\V1\EvenementFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\EvenementCollection;
use App\Http\Resources\V1\EvenementResource;
use App\Models\Evenement;
use Illuminate\Http\Request;

class _EvenementController extends Controller
{
    private string $typetag = 'includeType';

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $filter = new EvenementFilter();
        $filterItems = $filter->transform($request);

        $includeType = $request->query($this->typetag);
        $evenements = Evenement::where($filterItems);
        if ($includeType) {
            $evenements = $evenements->with('typeTickets.tickets');
        }

        return new EvenementCollection($evenements->get());

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Evenement $evenement)
    {
        $includeType = request()->query($this->typetag);
        if ($includeType) {
            return new EvenementResource($evenement->loadMissing('typeTickets.tickets'));
        }

        return new EvenementResource($evenement);
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
