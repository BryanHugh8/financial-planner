@extends('layouts.custom')

@section('content')
    <div class="space-y-8">
        <!-- Dashboard Header -->
        <div class="flex justify-between items-center">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Financial Dashboard</h2>
            <div class="flex gap-3">
                <button onclick="openQuickAdd()" class="btn-primary">Quick Add Expense</button>
                <a href="{{ route('expenses.index') }}" class="btn-secondary">View All Expenses</a>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Monthly Expenses -->
            <div class="card">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">This Month</h3>
                <p class="text-3xl font-bold text-blue-600 dark:text-blue-400">Rp {{ number_format($monthlyExpenses ?? 0, 0, ',', '.') }}</p>
                <p class="text-sm text-gray-600 dark:text-gray-400">Total Expenses</p>
            </div>

            <!-- Budget Status -->
            <div class="card">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Budget Status</h3>
                <p class="text-3xl font-bold text-green-600 dark:text-green-400">{{ $budgets->count() ?? 0 }}</p>
                <p class="text-sm text-gray-600 dark:text-gray-400">Active Budgets</p>
            </div>

            <!-- Financial Goals -->
            <div class="card">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Goals</h3>
                <p class="text-3xl font-bold text-purple-600 dark:text-purple-400">{{ $goals->count() ?? 0 }}</p>
                <p class="text-sm text-gray-600 dark:text-gray-400">Active Goals</p>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start">
            <!-- Quick Add -->
            <div class="card">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Quick Actions</h3>
                <div class="space-y-3">
                    <button onclick="openQuickAdd()" class="btn-primary text-sm block w-full text-center">Add Expense</button>
                    <a href="{{ route('budgets.create') }}" class="btn-secondary text-sm block w-full text-center">Set Budget</a>
                </div>
            </div>

            <!-- Recent Expenses -->
            <div class="card">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Recent Expenses</h3>
                @if(isset($recentExpenses) && $recentExpenses->count() > 0)
                    <div class="space-y-2">
                        @foreach($recentExpenses->take(3) as $expense)
                            <div class="flex justify-between items-center py-2 border-b border-gray-100 dark:border-gray-700 last:border-b-0">
                                <div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $expense->description }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $expense->category->name }}</p>
                                </div>
                                <span class="text-sm font-medium text-gray-900 dark:text-white">Rp {{ number_format($expense->amount, 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('expenses.index') }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 text-sm">View all expenses →</a>
                    </div>
                @else
                    <p class="text-gray-500 dark:text-gray-400 text-center py-4">No expenses yet. Add your first expense!</p>
                    <button onclick="openQuickAdd()" class="btn-primary text-sm w-full mt-3">Add Your First Expense</button>
                @endif
            </div>
        </div>

        <!-- Chart Container -->
        <div class="card">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Expense Categories</h3>
            <div class="chart-container" style="position: relative; height: 400px; width: 100%;">
                <canvas id="expenseChart" style="max-height: 400px;"></canvas>
            </div>
        </div>
    </div>

    <!-- Quick Add Modal with Number Formatting -->
    <div id="quickAddModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Quick Add Expense</h3>
                        <button onclick="closeQuickAdd()" class="text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300 text-xl">&times;</button>
                    </div>

                    <form action="{{ route('expenses.store') }}" method="POST">
                        @csrf
                        <div class="space-y-4">
                            <input type="text" id="quick-amount" placeholder="Amount" class="form-input" required>
                            <input type="hidden" name="amount" id="quick-amount-raw">
                            <input type="text" name="description" placeholder="Description" class="form-input" required>
                            <select name="category_id" class="form-select" required>
                                <option value="">Select Category</option>
                                @if(isset($categories))
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <input type="date" name="expense_date" value="{{ date('Y-m-d') }}" class="form-input" required>
                            <div class="flex gap-3">
                                <button type="submit" class="btn-primary flex-1">Add Expense</button>
                                <button type="button" onclick="closeQuickAdd()" class="btn-secondary flex-1">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openQuickAdd() {
            document.getElementById('quickAddModal').classList.remove('hidden');
        }

        function closeQuickAdd() {
            document.getElementById('quickAddModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('quickAddModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeQuickAdd();
            }
        });

        // Number formatting for quick add modal
        document.addEventListener('DOMContentLoaded', function() {
            const quickAmountInput = document.getElementById('quick-amount');
            const quickAmountRawInput = document.getElementById('quick-amount-raw');

            function formatNumber(num) {
                return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            }

            function unformatNumber(str) {
                return str.replace(/\./g, '');
            }

            if (quickAmountInput) {
                quickAmountInput.addEventListener('input', function(e) {
                    let value = e.target.value;

                    // Remove all non-digit characters
                    value = value.replace(/[^\d]/g, '');

                    // Format the number with dots as thousands separators
                    if (value) {
                        value = formatNumber(value);
                    }

                    e.target.value = value;
                    quickAmountRawInput.value = unformatNumber(value);
                });

                // Handle form submission
                quickAmountInput.closest('form').addEventListener('submit', function(e) {
                    const rawValue = unformatNumber(quickAmountInput.value);
                    quickAmountRawInput.value = rawValue;
                });
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('expenseChart');

            if (window.expenseChart instanceof Chart) {
                window.expenseChart.destroy();
            }

            const categoryData = @json($categoryExpenses ?? collect());
            const labels = Object.keys(categoryData);
            const data = Object.values(categoryData);

            if (labels.length === 0) {
                const canvasContext = ctx.getContext('2d');
                canvasContext.fillStyle = getComputedStyle(document.documentElement).getPropertyValue('--text-color') || '#6B7280';
                canvasContext.fillText('No expense data available', 10, 50);
                return;
            }

            window.expenseChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        data: data,
                        backgroundColor: [
                            '#EF4444', '#3B82F6', '#10B981', '#F59E0B',
                            '#8B5CF6', '#EC4899', '#6B7280', '#F97316'
                        ],
                        borderWidth: 2,
                        borderColor: document.documentElement.classList.contains('dark') ? '#374151' : '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true,
                                color: document.documentElement.classList.contains('dark') ? '#D1D5DB' : '#374151'
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection
