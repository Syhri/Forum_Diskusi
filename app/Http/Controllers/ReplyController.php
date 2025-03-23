<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Http\Request;

class ReplyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(Request $request, Thread $thread)
    {
        $request->validate([
            'content' => 'required'
        ]);

        Reply::create([
            'user_id' => auth('web')->id(),
            'thread_id' => $thread->id,
            'content' => $request->content,
        ]);

        return back()->with('success', 'Balasan berhasil ditambahkan!');
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
    public function destroy(Thread $thread, Reply $reply)
    {
        if (auth('web')->id() !== $reply->user_id) {
            abort(403, 'Anda tidak memiliki izin untuk menghapus balasan ini.');
        }

        $reply->delete();
        return back()->with('success', 'Balasan berhasil dihapus!');
    }
}
