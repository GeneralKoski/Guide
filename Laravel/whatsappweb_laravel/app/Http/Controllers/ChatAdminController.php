<?php

namespace App\Http\Controllers;

use App\Models\ChatAdmin;
use Illuminate\Http\Request;

class ChatAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = ChatAdmin::all();
        return view('chatadmins.index', ['admins' => $admins]);
    }

    public function checkIfAdmin(Request $request)
    {
        $AchatId = $request->input('Achat_id');
        $AuserId = $request->input('Auser_id');

        $isAdmin = ChatAdmin::where('Achat_id', '=', $AchatId)
            ->where('Auser_id', '=', $AuserId)
            ->exists();

        return $isAdmin ? ['isAdmin' => 'true'] : ['isAdmin' => 'false'];
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
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