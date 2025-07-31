@extends('layouts.custom')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Profile Information -->
        <div class="card">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Profile Information</h2>
            </div>

            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="space-y-6">
                    <!-- Avatar -->
                    <div class="flex items-center space-x-6">
                        <div class="w-20 h-20 bg-primary-500 rounded-full flex items-center justify-center">
                            <span class="text-white text-2xl font-bold">{{ substr($user->name, 0, 1) }}</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ $user->name }}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Member since {{ $user->created_at->format('F Y') }}</p>
                        </div>
                    </div>

                    <!-- Name -->
                    <div>
                        <label for="name" class="form-label">Name</label>
                        <input type="text"
                               name="name"
                               id="name"
                               value="{{ old('name', $user->name) }}"
                               class="form-input"
                               required>
                        @error('name')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="form-label">Email</label>
                        <input type="email"
                               name="email"
                               id="email"
                               value="{{ old('email', $user->email) }}"
                               class="form-input"
                               required>
                        @error('email')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button type="submit" class="btn-primary">
                            Update Profile
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Change Password -->
        <div class="card">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Change Password</h3>

            <form action="{{ route('profile.password.update') }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="space-y-6">
                    <!-- Current Password -->
                    <div>
                        <label for="current_password" class="form-label">Current Password</label>
                        <input type="password"
                               name="current_password"
                               id="current_password"
                               class="form-input"
                               required>
                        @error('current_password')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- New Password -->
                    <div>
                        <label for="password" class="form-label">New Password</label>
                        <input type="password"
                               name="password"
                               id="password"
                               class="form-input"
                               required>
                        @error('password')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="form-label">Confirm New Password</label>
                        <input type="password"
                               name="password_confirmation"
                               id="password_confirmation"
                               class="form-input"
                               required>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button type="submit" class="btn-primary">
                            Update Password
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Account Statistics -->
        <div class="card">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Account Statistics</h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center">
                    <div class="text-3xl font-bold text-primary-600 dark:text-primary-400">
                        {{ \App\Models\Expense::where('user_id', $user->id)->count() }}
                    </div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">Total Expenses</div>
                </div>

                <div class="text-center">
                    <div class="text-3xl font-bold text-primary-600 dark:text-primary-400">
                        {{ \App\Models\Budget::where('user_id', $user->id)->count() }}
                    </div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">Active Budgets</div>
                </div>

                <div class="text-center">
                    <div class="text-3xl font-bold text-primary-600 dark:text-primary-400">
                        {{ \App\Models\Category::where('user_id', $user->id)->count() }}
                    </div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">Categories</div>
                </div>
            </div>
        </div>
    </div>
@endsection
