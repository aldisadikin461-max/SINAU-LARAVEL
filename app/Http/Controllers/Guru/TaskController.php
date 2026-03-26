<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::where('guru_id', auth()->id())
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('guru.tasks.index', compact('tasks'));
    }

    public function create()
    {
        return view('guru.tasks.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'      => 'required|string|max:255',
            'deskripsi'  => 'nullable|string',
            'jurusan'    => 'nullable|string|max:100',
            'kelas'      => 'nullable|string|max:20',
            'deadline'   => 'required|date|after:today',
        ]);

        Task::create(array_merge($validated, ['guru_id' => auth()->id()]));

        return redirect()->route('guru.tasks.index')
            ->with('success', 'Tugas berhasil diberikan.');
    }

    public function edit(Task $task)
    {
        abort_unless($task->guru_id === auth()->id(), 403);
        return view('guru.tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        abort_unless($task->guru_id === auth()->id(), 403);

        $validated = $request->validate([
            'judul'     => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'jurusan'   => 'nullable|string|max:100',
            'kelas'     => 'nullable|string|max:20',
            'deadline'  => 'required|date',
        ]);

        $task->update($validated);

        return redirect()->route('guru.tasks.index')
            ->with('success', 'Tugas berhasil diperbarui.');
    }

    public function destroy(Task $task)
    {
        abort_unless($task->guru_id === auth()->id(), 403);
        $task->delete();
        return redirect()->route('guru.tasks.index')
            ->with('success', 'Tugas berhasil dihapus.');
    }
}
