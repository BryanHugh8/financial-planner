@extends('layouts.custom')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="card">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Add New Expense</h2>
                <a href="{{ route('dashboard') }}" class="btn-secondary">Back to Dashboard</a>
            </div>

            <form action="{{ route('expenses.store') }}" method="POST">
                @csrf

                <div class="space-y-6">
                    <!-- Amount -->
                    <div>
                        <label for="amount" class="form-label">Amount (Rp)</label>
                        <input type="text"
                               name="amount"
                               id="amount"
                               value="{{ old('amount') }}"
                               class="form-input"
                               placeholder="0"
                               required>
                        <input type="hidden" name="amount_raw" id="amount_raw">
                        @error('amount')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="form-label">Description</label>
                        <input type="text"
                               name="description"
                               id="description"
                               value="{{ old('description') }}"
                               class="form-input"
                               placeholder="What did you spend on?"
                               required>
                        @error('description')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div>
                        <label for="category_id" class="form-label">Category</label>
                        <select name="category_id" id="category_id" class="form-select" required>
                            <option value="">Select a category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Date -->
                    <div>
                        <label for="expense_date" class="form-label">Expense Date</label>
                        <input type="date"
                               name="expense_date"
                               id="expense_date"
                               value="{{ old('expense_date', date('Y-m-d')) }}"
                               class="form-input"
                               required>
                        @error('expense_date')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="flex gap-4">
                        <button type="submit" class="btn-primary flex-1">Add Expense</button>
                        <a href="{{ route('dashboard') }}" class="btn-secondary flex-1 text-center">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Number formatting for amount input
        document.addEventListener('DOMContentLoaded', function() {
            const amountInput = document.getElementById('amount');
            const amountRawInput = document.getElementById('amount_raw');

            function formatNumber(num) {
                return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            }

            function unformatNumber(str) {
                return str.replace(/\./g, '');
            }

            amountInput.addEventListener('input', function(e) {
                let value = e.target.value;

                // Remove all non-digit characters
                value = value.replace(/[^\d]/g, '');

                // Format the number with dots as thousands separators
                if (value) {
                    value = formatNumber(value);
                }

                e.target.value = value;

                // Store the raw value for form submission
                amountRawInput.value = unformatNumber(value);
            });

            // Handle form submission
            document.querySelector('form').addEventListener('submit', function(e) {
                const rawValue = unformatNumber(amountInput.value);
                amountInput.value = rawValue;
            });

            // Format existing value on page load
            if (amountInput.value) {
                const event = new Event('input');
                amountInput.dispatchEvent(event);
            }
        });
    </script>
@endsection
