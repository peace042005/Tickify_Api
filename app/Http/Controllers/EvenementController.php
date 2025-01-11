<?php

namespace App\Http\Controllers;

use App\Models\Evenement;
use Illuminate\Http\Request;

class EvenementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $evenements = Evenement::all();

        return view('evenements.index', compact('evenements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('evenements.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'event_nom' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after:date_debut',
            'nombre_tickets' => 'required|integer|min:1',
            'tickets' => 'required|array|min:1',
            'tickets.*.nom' => 'required|string|max:255',
            'tickets.*.prix' => 'required|numeric|min:0',
            'images' => 'nullable|array',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $evenement = Evenement::create([
            'nom' => $request->event_nom,
            'description' => $request->description,
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'nombre_tickets' => $request->nombre_tickets,
            'created_by' => auth()->id(),
        ]);

        // creation des types de tickets associés à l'évenement
        foreach ($request->tickets as $ticket) {
            $evenement->typeTickets()->create([
                'nom' => $ticket['nom'],
                'prix' => $ticket['prix'],
            ]);
        }

        // Traitement des imagees
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('evenements', 'public');

                $evenement->images()->create([
                    'path' => $path,
                ]);
            }
        }

        return redirect()->route('evenements.index', $evenement)
            ->with('success', 'Évènement créé avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $evenement = Evenement::findOrFail($id);

        return view('evenements.edit', compact('evenement'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validation des données récupérées du formulaire de mise a jour
        $request->validate([
            'event_nom' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after:date_debut',
            'nombre_tickets' => 'required|integer|min:1',
            'tickets' => 'required|array|min:1',
            'tickets.*.nom' => 'required|string|max:255',
            'tickets.*.prix' => 'required|numeric|min:0',
        ]);

        $evenement = Evenement::findOrFail($id);
        $evenement->update([
            'nom' => $request->event_nom,
            'description' => $request->description,
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'nombre_tickets' => $request->nombre_tickets,
        ]);

        // Récupérer l'id des types de tickets existants
        $existingTicketIds = $evenement->typeTickets->pluck('id')->toArray();

        // Variable pour stocker les ids des types de tickets mis à jour
        $processedTicketIds = [];

        foreach ($request->tickets as $index => $ticketData) {
            $ticket = $evenement->typeTickets()
                ->where('id', $index) // Use array index as ID if it matches an existing ticket
                ->first();

            if ($ticket) {
                // Update existing ticket
                $ticket->update([
                    'nom' => $ticketData['nom'],
                    'prix' => $ticketData['prix'],
                ]);
                $processedTicketIds[] = $ticket->id;
            } else {
                // Create new ticket
                $newTicket = $evenement->typeTickets()->create([
                    'nom' => $ticketData['nom'],
                    'prix' => $ticketData['prix'],
                ]);
                $processedTicketIds[] = $newTicket->id;
            }
        }

        // Suppression des types de tickets qui ne se retrouve plus dans la requête
        // Mais qui sont encore dans la base de données
        $evenement->typeTickets()
            ->whereNotIn('id', $processedTicketIds)
            ->delete();

        return redirect()->route('evenements.index', $evenement)
            ->with('success', 'Évènement mis à jour avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
