<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commitment;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CommitmentController extends Controller
{
    public function index()
    {
        return view('admin.commitments.index', ['items' => Commitment::query()->ordered()->get()]);
    }

    public function create()
    {
        return view('admin.commitments.form', ['item' => new Commitment(['is_active' => true, 'icon' => 'bolt'])]);
    }

    public function store(Request $request)
    {
        Commitment::query()->create($this->validated($request));

        return redirect()->route('admin.commitments.index')->with('success', 'Komitmen ditambahkan.');
    }

    public function edit(Commitment $commitment)
    {
        return view('admin.commitments.form', ['item' => $commitment]);
    }

    public function update(Request $request, Commitment $commitment)
    {
        $commitment->update($this->validated($request));

        return redirect()->route('admin.commitments.index')->with('success', 'Komitmen diperbarui.');
    }

    public function destroy(Commitment $commitment)
    {
        $commitment->delete();

        return back()->with('success', 'Komitmen dihapus.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'icon' => ['required', Rule::in(array_keys(Commitment::ICONS))],
            'title' => ['required', 'string', 'max:120'],
            'description' => ['nullable', 'string', 'max:600'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
        ]);
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }
}
