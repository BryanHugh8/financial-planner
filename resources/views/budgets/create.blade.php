@extends('layouts.custom')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="card">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Create Budget</h2>
                <a href="{{ route('dashboard') }}" class="btn-secondary">Back to Dashboard</a>
            </div>

            <form action="{{ route('budgets.store') }}" method="POST">
                @csrf

                <div class="space-y-6">
                    <div>
                        <label for="category_id" class="form-label">
                            Category
                        </label>
                        <select name="category_id"
                                id="category_id"
                                class="form-select"
                                required>
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

                    <div class="mb-4">
                        <label for="limit_amount" class="form-label">Budget Amount (Rp)</label>
                        <input type="text"
                               name="limit_amount"
                               id="limit_amount"
                               class="form-input"
                               value="{{ old('limit_amount', isset($budget) ? number_format($budget->limit_amount, 0, ',', '.') : '') }}"
                               placeholder="1.500.000"
                               required>
                    </div>

                    <div>
                        <label for="month" class="form-label">
                            Month
                        </label>
                        <select name="month"
                                id="month"
                                class="form-select"
                                required>
                            @for($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ old('month', date('n')) == $i ? 'selected' : '' }}>
                                    {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                                </option>
                            @endfor
                        </select>
                        @error('month')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="year" class="form-label">
                            Year
                        </label>
                        <select name="year"
                                id="year"
                                class="form-select"
                                required>
                            @for($year = date('Y'); $year <= date('Y') + 2; $year++)
                                <option value="{{ $year }}" {{ old('year', date('Y')) == $year ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endfor
                        </select>
                        @error('year')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex gap-4">
                        <button type="submit" class="btn-primary flex-1">
                            Create Budget
                        </button>
                        <a href="{{ route('dashboard') }}" class="btn-secondary flex-1 text-center">
                            Cancel
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const limitAmountInput = document.getElementById('limit_amount');

            limitAmountInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/[^\d]/g, '');

                if (value) {
                    e.target.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                } else {
                    e.target.value = '';
                }
            });
        });
    </script>
@endsection
