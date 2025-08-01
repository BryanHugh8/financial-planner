<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BudgetController extends Controller
{
    public function index()
    {
        $budgets = Budget::with('category')
            ->where('user_id', Auth::id())
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->paginate(10);

        return view('budgets.index', compact('budgets'));
    }

    public function create()
    {
        $categories = Category::where('user_id', Auth::id())->get();
        return view('budgets.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->merge([
            'limit_amount' => (float) str_replace('.', '', $request->limit_amount)
        ]);

        $request->validate([
            'limit_amount' => 'required|numeric|min:1',
            'month' => 'required|integer|between:1,12',
            'year' => 'required|integer|min:' . date('Y'),
            'category_id' => 'required|exists:categories,id'
        ]);

        $existingBudget = Budget::where('user_id', Auth::id())
            ->where('category_id', $request->category_id)
            ->where('month', $request->month)
            ->where('year', $request->year)
            ->first();

        if ($existingBudget) {
            return back()->withErrors(['category_id' => 'Budget already exists for this category and month.']);
        }

        Budget::create([
            'limit_amount' => $request->limit_amount,
            'month' => $request->month,
            'year' => $request->year,
            'category_id' => $request->category_id,
            'user_id' => Auth::id()
        ]);

        return redirect()->route('budgets.index')->with('success', 'Budget created successfully!');
    }

    public function show(Budget $budget)
    {
        $this->authorize('view', $budget);
        return view('budgets.show', compact('budget'));
    }

    public function edit(Budget $budget)
    {
        if ($budget->user_id !== Auth::id()) {
            abort(403);
        }

        $categories = Category::where('user_id', Auth::id())->get();
        return view('budgets.edit', compact('budget', 'categories'));
    }

    public function update(Request $request, Budget $budget)
    {
        if ($budget->user_id !== Auth::id()) {
            abort(403);
        }

        $request->merge([
            'limit_amount' => (float) str_replace('.', '', $request->limit_amount)
        ]);

        $request->validate([
            'limit_amount' => 'required|numeric|min:1',
            'month' => 'required|integer|between:1,12',
            'year' => 'required|integer|min:' . date('Y'),
            'category_id' => 'required|exists:categories,id'
        ]);

        $budget->update([
            'limit_amount' => $request->limit_amount,
            'month' => $request->month,
            'year' => $request->year,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('budgets.index')->with('success', 'Budget updated successfully!');
    }

    public function destroy(Budget $budget)
    {
        if ($budget->user_id !== Auth::id()) {
            abort(403);
        }

        $budget->delete();
        return redirect()->route('budgets.index')->with('success', 'Budget deleted successfully!');
    }
}
