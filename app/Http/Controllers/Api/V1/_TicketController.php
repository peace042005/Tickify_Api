<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\TicketCollection;
use App\Models\Ticket;
use App\Http\Resources\V1\TicketRessource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class _TicketController extends Controller
{
    /**
     * Constructor to register middleware
     * NOTE: Important pour que la création de tickets ne soit accessible que
     * par les utilisateurs connectés
     */
    public function __construct()
    {
        $this->middleware(
            'auth:sanctum',
            // ['except' => ['index', 'show']],
        );
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retourne les tickets commandés par l'utilisateur authentifié
        // return request()->user()->tickets()->get();

        $tickets = request()->user()
            ->tickets()
            ->with(['typeTicket.evenement'])
            ->get();

        return new TicketCollection($tickets);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'type_ticket_id' => 'required|exists:type_tickets,id',
        ]);

        // Créer le ticket affecté à l'utilisateur authentifié
        $request->user()->tickets()->create([
            'type_ticket_id' => $request->type_ticket_id,
            'statut' => 'valide',
        ]);

        return response()->json(['message' => 'Ticket created successfully'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        return $ticket;
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
    public function destroy(Ticket $ticket)
    {
        Gate::authorize('modify', $ticket);
        $ticket->delete();

        return response()->json(['message' => 'Ticket deleted successfully'], 200);
    }
}
