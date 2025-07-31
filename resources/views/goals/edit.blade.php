@extends('layouts.custom')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="max-w-2xl mx-auto">
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h1 class="text-xl font-semibold text-gray-900 dark:text-white">Edit Goal: {{ $goal->name }}</h1>
                </div>

                <form action="{{ route('goals.update', $goal) }}" method="POST" class="px-6 py-4">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Goal Name
                            </label>
                            <input type="text"
                                   id="name"
                                   name="name"
                                   value="{{ old('name', $goal->name) }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                   placeholder="e.g., Emergency Fund, Vacation, New Car"
                                   required>
                            @error('name')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Description
                            </label>
                            <textarea id="description"
                                      name="description"
                                      rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                      placeholder="Describe your goal...">{{ old('description', $goal->description) }}</textarea>
                            @error('description')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Target Amount -->
                        <div>
                            <label for="target_amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Target Amount
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-2 text-gray-500 dark:text-gray-400">$</span>
                                <input type="text"
                                       id="target_amount"
                                       name="target_amount"
                                       value="{{ old('target_amount', number_format($goal->target_amount, 2, ',', '.')) }}"
                                       class="w-full pl-8 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                       placeholder="100.000,00"
                                       required>
                            </div>
                            @error('target_amount')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Current Amount -->
                        <div>
                            <label for="current_amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Current Amount
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-2 text-gray-500 dark:text-gray-400">$</span>
                                <input type="text"
                                       id="current_amount"
                                       name="current_amount"
                                       value="{{ old('current_amount', number_format($goal->current_amount, 2, ',', '.')) }}"
                                       class="w-full pl-8 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                       placeholder="0,00">
                            </div>
                            @error('current_amount')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Target Date -->
                        <div>
                            <label for="target_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Target Date
                            </label>
                            <input type="date"
                                   id="target_date"
                                   name="target_date"
                                   value="{{ old('target_date', $goal->target_date?->format('Y-m-d')) }}"
                                   min="{{ date('Y-m-d') }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                   required>
                            @error('target_date')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Status
                            </label>
                            <select id="status"
                                    name="status"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                <option value="active" {{ old('status', $goal->status) === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="paused" {{ old('status', $goal->status) === 'paused' ? 'selected' : '' }}>Paused</option>
                                <option value="completed" {{ old('status', $goal->status) === 'completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                            @error('status')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex items-center justify-end space-x-3 mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('goals.index') }}"
                           class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                            Cancel
                        </a>
                        <button type="submit"
                                class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                            Update Goal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const formatNumber = (input) => {
                input.addEventListener('input', function() {
                    let value = this.value.replace(/[^0-9,]/g, '');
                    let parts = value.split(',');
                    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                    if (parts[1] && parts[1].length > 2) {
                        parts[1] = parts[1].slice(0, 2);
                    }
                    this.value = parts.join(',');
                });
            };

            formatNumber(document.getElementById('target_amount'));
            formatNumber(document.getElementById('current_amount'));
        });
    </script>
@endsection
