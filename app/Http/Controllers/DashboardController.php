<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Budget;
use App\Models\Category;
use App\Models\FinancialGoal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $categories = Category::where('user_id', $user->id)->get();
        // Monthly expenses
        $monthlyExpenses = Expense::where('user_id', $user->id)
            ->whereMonth('expense_date', $currentMonth)
            ->whereYear('expense_date', $currentYear)
            ->sum('amount') ?? 0;

        // Category-wise expenses
        $categoryExpenses = Expense::with('category')
            ->where('user_id', $user->id)
            ->whereMonth('expense_date', $currentMonth)
            ->whereYear('expense_date', $currentYear)
            ->get()
            ->groupBy('category.name')
            ->map(fn($expenses) => $expenses->sum('amount'));

        // If no category expenses, create empty collection
        if ($categoryExpenses->isEmpty()) {
            $categoryExpenses = collect();
        }

        // Budget vs Actual
        $budgets = Budget::with('category')
            ->where('user_id', $user->id)
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->get();

        // Financial goals
        $goals = FinancialGoal::where('user_id', $user->id)
            ->orderBy('target_date')
            ->take(3)
            ->get();

        // Recent expenses
        $recentExpenses = Expense::with('category')
            ->where('user_id', $user->id)
            ->orderBy('expense_date', 'desc')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'monthlyExpenses',
            'categoryExpenses',
            'budgets',
            'goals',
            'recentExpenses',
            'categories'
        ));
    }
}
