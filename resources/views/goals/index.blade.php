@extends('layouts.custom')

@section('content')
    <div class="space-y-6">
        <div class="flex justify-between items-center">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Financial Goals</h2>
            <a href="{{ route('goals.create') }}" class="btn-primary">Create New Goal</a>
        </div>

        @if($goals->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($goals as $goal)
                    <div class="card {{ $goal->is_overdue ? 'border-red-300 dark:border-red-600' : '' }}">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $goal->name }}</h3>
                            <span class="px-2 py-1 text-xs rounded-full
                            @if($goal->status === 'completed') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                            @elseif($goal->status === 'paused') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                            @else bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 @endif">
                            {{ ucfirst($goal->status) }}
                        </span>
                        </div>

                        @if($goal->description)
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">{{ $goal->description }}</p>
                        @endif

                        <div class="mb-4">
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-600 dark:text-gray-400">Progress</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ number_format($goal->progress_percentage, 1) }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: {{ $goal->progress_percentage }}%"></div>
                            </div>
                        </div>

                        <div class="space-y-2 mb-4">
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Current:</span>
                                <span class="text-sm font-medium text-gray-900 dark:text-white">Rp {{ number_format($goal->current_amount, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Target:</span>
                                <span class="text-sm font-medium text-gray-900 dark:text-white">Rp {{ number_format($goal->target_amount, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Remaining:</span>
                                <span class="text-sm font-medium text-gray-900 dark:text-white">Rp {{ number_format($goal->remaining_amount, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Target Date:</span>
                                <span class="text-sm font-medium {{ $goal->is_overdue ? 'text-red-600 dark:text-red-400' : 'text-gray-900 dark:text-white' }}">
                                {{ $goal->target_date->format('M d, Y') }}
                            </span>
                            </div>
                            @if($goal->days_remaining !== null)
                                <div class="text-xs {{ $goal->is_overdue ? 'text-red-600 dark:text-red-400' : 'text-gray-500 dark:text-gray-400' }} mt-1">
                                    @if($goal->is_overdue)
                                        {{ abs($goal->days_remaining) }} days overdue
                                    @else
                                        {{ $goal->days_remaining }} days remaining
                                    @endif
                                </div>
                            @endif
                        </div>

                        <div class="flex gap-2">
                            <a href="{{ route('goals.show', $goal) }}" class="btn-secondary text-sm flex-1 text-center">View</a>
                            @if($goal->status !== 'completed')
                                <a href="{{ route('goals.edit', $goal) }}" class="btn-primary text-sm flex-1 text-center">Edit</a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <div class="text-gray-400 dark:text-gray-500 mb-4">
                    <svg class="mx-auto h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No Goals Yet</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-6">Start by creating your first financial goal to track your progress.</p>
                <a href="{{ route('goals.create') }}" class="btn-primary">Create Your First Goal</a>
            </div>
        @endif
    </div>
@endsection
