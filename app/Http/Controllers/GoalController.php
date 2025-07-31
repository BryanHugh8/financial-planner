<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class GoalController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $goals = auth()->user()->goals()->latest()->get();
        return view('goals.index', compact('goals'));
    }

    public function create()
    {
        return view('goals.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'target_amount' => 'required|string',
            'current_amount' => 'nullable|string',
            'target_date' => 'required|date|after:today',
            'status' => 'required|in:active,paused,completed',
        ]);

        // Convert formatted numbers to decimal
        $targetAmount = str_replace(['.', ','], ['', '.'], $request->target_amount);
        $currentAmount = $request->current_amount ? str_replace(['.', ','], ['', '.'], $request->current_amount) : 0;

        auth()->user()->goals()->create([
            'name' => $request->name,
            'description' => $request->description,
            'target_amount' => (float) $targetAmount,
            'current_amount' => (float) $currentAmount,
            'target_date' => $request->target_date,
            'status' => $request->status ?? 'active',
        ]);

        return redirect()->route('goals.index')->with('success', 'Goal created successfully!');
    }

    public function show(Goal $goal)
    {
        // Check if user owns this goal
        if ($goal->user_id !== auth()->id()) {
            abort(403);
        }
        return view('goals.show', compact('goal'));
    }

    public function edit(Goal $goal)
    {
        // Check if user owns this goal
        if ($goal->user_id !== auth()->id()) {
            abort(403);
        }
        return view('goals.edit', compact('goal'));
    }

    public function update(Request $request, Goal $goal)
    {
        // Check if user owns this goal
        if ($goal->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'target_amount' => 'required|string',
            'current_amount' => 'nullable|string',
            'target_date' => 'required|date',
            'status' => 'required|in:active,paused,completed',
        ]);

        // Convert formatted numbers to decimal
        $targetAmount = str_replace(['.', ','], ['', '.'], $request->target_amount);
        $currentAmount = $request->current_amount ? str_replace(['.', ','], ['', '.'], $request->current_amount) : 0;

        $goal->update([
            'name' => $request->name,
            'description' => $request->description,
            'target_amount' => (float) $targetAmount,
            'current_amount' => (float) $currentAmount,
            'target_date' => $request->target_date,
            'status' => $request->status,
        ]);

        return redirect()->route('goals.index')->with('success', 'Goal updated successfully!');
    }

    public function destroy(Goal $goal)
    {
        // Check if user owns this goal
        if ($goal->user_id !== auth()->id()) {
            abort(403);
        }
        $goal->delete();
        return redirect()->route('goals.index')->with('success', 'Goal deleted successfully!');
    }

    public function addProgress(Request $request, Goal $goal)
    {
        // Check if user owns this goal
        if ($goal->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'amount' => 'required|string|min:1'
        ]);

        $amount = str_replace(['.', ','], ['', '.'], $request->amount);
        $goal->increment('current_amount', (float) $amount);

        if ($goal->current_amount >= $goal->target_amount) {
            $goal->update(['status' => 'completed']);
        }

        return back()->with('success', 'Progress added successfully!');
    }
}
