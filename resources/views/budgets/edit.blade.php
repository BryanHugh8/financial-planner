@extends('layouts.custom')

@section('content')
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Edit Budget</h2>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Update your budget settings</p>
            </div>
            <a href="{{ route('budgets.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to Budgets
            </a>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-6 max-w-2xl">
            <form method="POST" action="{{ route('budgets.update', $budget) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="space-y-2">
                    <label for="limit_amount" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                        Budget Amount
                    </label>
                    <div class="relative">
                        <input type="text"
                               id="limit_amount"
                               name="limit_amount"
                               value="{{ number_format($budget->limit_amount, 0, '', '.') }}"
                               class="block w-full pl-12 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('limit_amount') border-red-500 ring-2 ring-red-200 @enderror"
                               placeholder="0"
                               required>
                    </div>
                    @error('limit_amount')
                    <p class="text-red-500 text-sm flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label for="category_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Category
                        </label>
                        <select id="category_id"
                                name="category_id"
                                class="block w-full px-3 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('category_id') border-red-500 ring-2 ring-red-200 @enderror"
                                required>
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $budget->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <p class="text-red-500 text-sm flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="month" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Month
                        </label>
                        <select id="month"
                                name="month"
                                class="block w-full px-3 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('month') border-red-500 ring-2 ring-red-200 @enderror"
                                required>
                            @for($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ $budget->month == $i ? 'selected' : '' }}>
                                    {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                                </option>
                            @endfor
                        </select>
                        @error('month')
                        <p class="text-red-500 text-sm flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>
                </div>

                <div class="space-y-2">
                    <label for="year" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                        Year
                    </label>
                    <div class="max-w-xs">
                        <select id="year"
                                name="year"
                                class="block w-full px-3 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('year') border-red-500 ring-2 ring-red-200 @enderror"
                                required>
                            @for($year = date('Y'); $year <= date('Y') + 5; $year++)
                                <option value="{{ $year }}" {{ $budget->year == $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endfor
                        </select>
                    </div>
                    @error('year')
                    <p class="text-red-500 text-sm flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <div class="flex flex-col-reverse sm:flex-row gap-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('budgets.index') }}"
                       class="inline-flex justify-center items-center px-6 py-3 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors shadow-sm">
                        Cancel
                    </a>
                    <button type="submit"
                            class="btn-primary inline-flex justify-center items-center px-6 py-3 text-sm font-medium focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Update Budget
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const limitAmountInput = document.getElementById('limit_amount');

            // Enhanced input formatting with visual feedback
            limitAmountInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/[^\d]/g, '');

                if (value) {
                    // Format with dots as thousands separators
                    const formatted = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                    e.target.value = formatted;

                    // Add success styling for valid amounts
                    e.target.classList.remove('border-red-500', 'ring-red-200');
                    e.target.classList.add('border-green-500', 'ring-green-200');
                } else {
                    e.target.value = '';
                    e.target.classList.remove('border-green-500', 'ring-green-200', 'border-red-500', 'ring-red-200');
                }
            });

            // Handle focus events for better UX
            limitAmountInput.addEventListener('focus', function(e) {
                e.target.classList.add('ring-2');
            });

            limitAmountInput.addEventListener('blur', function(e) {
                if (!e.target.classList.contains('border-red-500') && !e.target.classList.contains('border-green-500')) {
                    e.target.classList.remove('ring-2');
                }
            });

            // Form submission handling
            document.querySelector('form').addEventListener('submit', function() {
                const rawValue = limitAmountInput.value.replace(/\./g, '');
                limitAmountInput.value = rawValue;
            });

            // Auto-focus on amount input
            limitAmountInput.focus();
        });
    </script>
@endsection
