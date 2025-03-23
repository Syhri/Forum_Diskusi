<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Thread;
use App\Models\Category;
use Illuminate\Routing\Controller;

class ThreadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // return view('threads.index', ['threads' => Thread::latest()->paginate(10)]);
        $query = Thread::query();

        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if($request->has('category_id') && $request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        return view('threads.index', [
            'threads' => $query->latest()->paginate(10),
            'categories' => Category::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('threads.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'category_id' => 'required|exists:categories,id',
        ]);

        Thread::create([
            'title' => $request->title,
            'content' => $request->content,
            'category_id' => $request->category_id,
            'user_id' => auth('web')->id(),
        ]);

        return redirect()->route('threads.index')->with('success', 'Thread berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Thread $thread)
    {
        return view('threads.show', compact('thread'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Thread $thread)
    {
        if (auth('web')->id() !== $thread->user_id) {
            abort(403, 'Anda tidak memiliki izin untuk mengedit thread ini.');
        }

        $categories = Category::all();

        return view('threads.edit', compact('thread', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Thread $thread)
    {
        // $this->authorize('update', $thread);
        if (auth('web')->id() !== $thread->user_id) {
            abort(403, 'Anda tidak memiliki izin untuk mengedit thread ini.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'category_id' => 'required|exists:categories,id',
        ]);

        $thread->update([
            'title' => $request->title,
            'content' => $request->content,
            'category_id' => $request->category_id, // Pastikan kategori diperbarui
        ]);

        return redirect()->route('threads.show', $thread)->with('success', 'Thread berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Thread $thread)
    {
        if (auth('web')->id() !== $thread->user_id) {
            abort(403, 'Anda tidak memiliki izin untuk menghapus thread ini.');
        }

        $thread->delete();

        return redirect()->route('threads.index')->with('success', 'Thread berhasil dihapus!');
    }
}
