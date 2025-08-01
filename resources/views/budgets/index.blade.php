@extends('layouts.custom')

@section('content')
    <div class="space-y-8">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Budget Overview</h2>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Track your spending against your budget limits</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('budgets.create') }}" class="btn-primary">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Create Budget
                </a>
                <a href="{{ route('dashboard') }}" class="btn-secondary">Dashboard</a>
            </div>
        </div>

        @if($budgets->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($budgets as $budget)
                    <div class="card hover:shadow-xl transition-shadow duration-300">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center">
                                <div class="w-3 h-3 rounded-full mr-3" style="background-color: {{ $budget->category->color ?? '#3B82F6' }}"></div>
                                <h3 class="font-semibold text-gray-900 dark:text-white">{{ $budget->category->name }}</h3>
                            </div>
                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                {{ \Carbon\Carbon::createFromDate($budget->year, $budget->month, 1)->format('M Y') }}
                            </span>
                        </div>

                        <div class="space-y-3 mb-4">
                            <div class="flex justify-between items-baseline">
                                <span class="text-2xl font-bold text-gray-900 dark:text-white">
                                    Rp {{ number_format($budget->used_amount, 0, ',', '.') }}
                                </span>
                                <span class="text-sm text-gray-500 dark:text-gray-400">
                                    of Rp {{ number_format($budget->limit_amount, 0, ',', '.') }}
                                </span>
                            </div>

                            <div class="progress-bar">
                                <div class="progress-fill status-{{ $budget->status }}"
                                     style="width: {{ min($budget->usage_percentage, 100) }}%"></div>
                            </div>

                            <div class="flex justify-between items-center">
                                <span class="text-sm font-medium
                                    @if($budget->status === 'good') text-green-600 dark:text-green-400
                                    @elseif($budget->status === 'moderate') text-yellow-600 dark:text-yellow-400
                                    @elseif($budget->status === 'warning') text-orange-600 dark:text-orange-400
                                    @else text-red-600 dark:text-red-400 @endif">
                                    {{ number_format($budget->usage_percentage, 1) }}% used
                                </span>

                                @if($budget->remaining_amount >= 0)
                                    <span class="text-sm text-gray-600 dark:text-gray-400">
                                        Rp {{ number_format($budget->remaining_amount, 0, ',', '.') }} left
                                    </span>
                                @else
                                    <span class="text-sm text-red-600 dark:text-red-400 font-medium">
                                        Rp {{ number_format(abs($budget->remaining_amount), 0, ',', '.') }} over
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="mb-4">
                            @if($budget->status === 'good')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/50 text-green-800 dark:text-green-300">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    On Track
                                </span>
                            @elseif($budget->status === 'moderate')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 dark:bg-yellow-900/50 text-yellow-800 dark:text-yellow-300">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    Moderate
                                </span>
                            @elseif($budget->status === 'warning')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 dark:bg-orange-900/50 text-orange-800 dark:text-orange-300">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    Warning
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 dark:bg-red-900/50 text-red-800 dark:text-red-300">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                    </svg>
                                    Over Budget
                                </span>
                            @endif
                        </div>

                        <div class="flex gap-2">
                            <a href="{{ route('budgets.edit', $budget) }}"
                               class="flex-1 text-center py-2 px-3 text-sm bg-blue-50 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900 transition-colors">
                                Edit
                            </a>
                            <form action="{{ route('budgets.destroy', $budget) }}" method="POST" class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        onclick="return confirm('Are you sure you want to delete this budget?')"
                                        class="w-full py-2 px-3 text-sm bg-red-50 dark:bg-red-900/50 text-red-600 dark:text-red-400 rounded-lg hover:bg-red-100 dark:hover:bg-red-900 transition-colors">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($budgets->hasPages())
                <div class="mt-8">
                    {{ $budgets->links() }}
                </div>
            @endif
        @else
            <div class="card text-center py-16">
                <div class="text-gray-400 dark:text-gray-600 mb-6">
                    <svg class="mx-auto h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                    </svg>
                </div>
                <h3 class="text-xl font-medium text-gray-900 dark:text-white mb-2">No budgets found</h3>
                <p class="text-gray-500 dark:text-gray-400 mb-8">Get started by creating your first budget to track your spending.</p>
                <a href="{{ route('budgets.create') }}" class="btn-primary">Create Your First Budget</a>
            </div>
        @endif
    </div>
@endsection
