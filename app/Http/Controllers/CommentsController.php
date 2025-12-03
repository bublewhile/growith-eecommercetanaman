<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Comments;

class CommentsController extends Controller
{
    public function store(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required'
        ]);

        Comments::create([
            'product_id' => $id,
            'user_id' => Auth::id(),
            'comment' => $request->comment
        ]);

        return redirect()->back()->with('success', 'Komentar berhasil dikirim');
    }

    /**
     * Display the specified resource.
     */
    public function show(Comments $comments)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comments $comments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comments $comments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comments $comments)
    {
        //
    }
}
