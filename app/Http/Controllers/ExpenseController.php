<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::with('category')
            ->where('user_id', Auth::id())
            ->orderBy('expense_date', 'desc')
            ->paginate(10);

        return view('expenses.index', compact('expenses'));
    }

    public function create()
    {
        $categories = Category::where('user_id', Auth::id())->get();
        return view('expenses.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|string',
            'description' => 'required|string|max:255',
            'expense_date' => 'required|date',
            'category_id' => 'required|exists:categories,id'
        ]);

        $amount = str_replace(',', '', $request->amount);
        $amount = (float) $amount;
        if ($amount <= 0) {
            return back()->withErrors(['amount' => 'Amount must be greater than zero.']);
        }
        Expense::create([
            'amount' => $amount,
            'description' => $request->description,
            'expense_date' => $request->expense_date,
            'category_id' => $request->category_id,
            'user_id' => Auth::id()
        ]);

        return redirect()->route('expenses.index')->with('success', 'Expense added successfully!');
    }

    public function show(Expense $expense)
    {
        $this->authorize('view', $expense);
        return view('expenses.show', compact('expense'));
    }

    public function edit(Expense $expense)
    {
        $this->authorize('update', $expense);
        $categories = Category::where('user_id', Auth::id())->get();
        return view('expenses.edit', compact('expense', 'categories'));
    }

    public function update(Request $request, Expense $expense)
    {
        $this->authorize('update', $expense);

        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'description' => 'required|string|max:255',
            'expense_date' => 'required|date',
            'category_id' => 'required|exists:categories,id'
        ]);

        $expense->update($request->only(['amount', 'description', 'expense_date', 'category_id']));

        return redirect()->route('expenses.index')->with('success', 'Expense updated successfully!');
    }

    public function destroy(Expense $expense)
    {
        $this->authorize('delete', $expense);
        $expense->delete();

        return redirect()->route('expenses.index')->with('success', 'Expense deleted successfully!');
    }
}
