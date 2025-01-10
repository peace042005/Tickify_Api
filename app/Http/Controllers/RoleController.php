<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();

        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|unique:roles|max:50',
        ], [
            'nom.unique' => 'Ce nom de rôle existe déjà.',
            'nom.required' => 'Le nom du rôle est obligatoire.',
            'nom.max' => 'Le nom du rôle ne peut pas dépasser 50 caractères.',
        ]);

        Role::create($validated);

        return redirect()->route('roles.index')->with('success', 'Rôle créé avec succès!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $role = Role::findOrFail($id);

        return view('roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role = Role::findOrFail($id);

        return view('roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $role = Role::findOrFail($id);

        $validated = $request->validate([
            'nom' => 'required|unique:roles,nom,'.$id.'|max:50',
        ], [
            'nom.unique' => 'Ce nom de rôle existe déjà.',
            'nom.required' => 'Le nom du rôle est obligatoire.',
            'nom.max' => 'Le nom du rôle ne peut pas dépasser 50 caractères.',
        ]);

        $role->update($validated);

        return redirect()->route('roles.index')->with('success', 'Rôle modifié avec succès!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Role::destroy($id);

        return redirect()->route('roles.index')->with('success', 'Role supprimé avec succès!');
    }
}
