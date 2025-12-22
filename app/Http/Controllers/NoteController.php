<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    protected $note;

    public function __construct(Note $note)
    {
        $this->note = $note;
    }

    /**
     * Store or update note
     */
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'nullable|string|max:1000',
        ]);

        $this->note->updateOrCreate(
            ['user_id' => Auth::id()],
            ['content' => $request->input('content')]
        );

        return redirect()->back();
    }

    /**
     * Update note
     */
    public function update(Request $request)
    {
        $request->validate([
            'content' => 'nullable|string|max:1000',
        ]);

        $note = $this->note->where('user_id', Auth::id())->firstOrFail();
        $note->update(['content' => $request->input('content')]);

        return redirect()->back();
    }

    /**
     * Delete note
     */
    public function destroy()
    {
        $note = $this->note->where('user_id', Auth::id())->first();

        if ($note) {
            $note->delete();
        }

        return redirect()->back();
    }
}
