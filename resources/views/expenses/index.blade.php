@extends('layouts.custom')

@section('content')
    <div class="space-y-6">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">My Expenses</h2>
            <div class="flex gap-3">
                <a href="{{ route('expenses.create') }}" class="btn-primary">Add Expense</a>
                <a href="{{ route('dashboard') }}" class="btn-secondary">Dashboard</a>
            </div>
        </div>

        @if($expenses->count() > 0)
            <div class="card">
                <div class="overflow-x-auto">
                    <table class="w-full table-auto">
                        <thead>
                        <tr>
                            <th class="table-header">Date</th>
                            <th class="table-header">Description</th>
                            <th class="table-header">Category</th>
                            <th class="table-header text-right">Amount</th>
                            <th class="table-header text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($expenses as $expense)
                            <tr class="table-row">
                                <td class="table-cell">
                                    {{ $expense->expense_date->format('M d, Y') }}
                                </td>
                                <td class="table-cell">
                                    {{ $expense->description }}
                                </td>
                                <td class="py-3 px-4">
                                    <span class="category-badge">
                                        {{ $expense->category->name }}
                                    </span>
                                </td>
                                <td class="table-cell text-right font-medium">
                                    Rp {{ number_format($expense->amount, 0, ',', '.') }}
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ route('expenses.edit', $expense) }}" class="action-link">Edit</a>
                                        <form action="{{ route('expenses.destroy', $expense) }}"
                                              method="POST"
                                              class="inline"
                                              onsubmit="return confirm('Are you sure you want to delete this expense?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-link-danger">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    {{ $expenses->links() }}
                </div>
            </div>
        @else
            <div class="card text-center py-12">
                <div class="text-gray-400 dark:text-gray-600 mb-4">
                    <svg class="mx-auto h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No expenses found</h3>
                <p class="text-gray-500 dark:text-gray-400 mb-6">Get started by adding your first expense.</p>
                <a href="{{ route('expenses.create') }}" class="btn-primary">Add Your First Expense</a>
            </div>
        @endif
    </div>
@endsection
