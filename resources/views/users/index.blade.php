<x-app-layout>
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-2xl font-semibold leading-6 text-gray-900 dark:text-white">Users</h1>
            <p class="mt-2 text-sm text-gray-700 dark:text-gray-400">A list of all the users in your account including
                their name, title, email and role.</p>
        </div>
        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
            <a href="{{ route('users.create') }}"
                class="block rounded-md bg-primary-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600">
                <i class='bx bx-plus align-middle mr-1'></i>Create User
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="mt-8 bg-white dark:bg-gray-800 shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl overflow-hidden">
        <div class="bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700 px-4 py-3 sm:px-6">
            <h3 class="text-base font-semibold leading-6 text-gray-900 dark:text-white">Search and Filter</h3>
        </div>
        <div class="p-4 sm:p-6">
            <form action="{{ route('users.index') }}" method="GET">
                <div class="flex flex-col sm:flex-row gap-4 items-end">
                    <!-- Search (Flex Grow) -->
                    <div class="w-full sm:flex-1">
                        <label for="search"
                            class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Search</label>
                        <div class="relative rounded-md">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <i class='bx bx-search text-gray-400 text-lg'></i>
                            </div>
                            <input type="text" name="search" id="search" value="{{ request('search') }}"
                                class="block w-full rounded-md border-0 py-1.5 ring-1 ring-inset ring-gray-300 dark:ring-gray-600 pl-10 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6 dark:bg-gray-900 dark:text-white h-10"
                                placeholder="Name or Email">
                        </div>
                    </div>

                    <!-- Filters Group -->
                    <div class="flex flex-col sm:flex-row gap-4 w-full sm:w-auto items-end">
                        <!-- Role Filter -->
                        <div class="w-full sm:w-44 text-sm">
                            <label for="role"
                                class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Role</label>
                            <select name="role" id="role"
                                style="background-image: url(&quot;data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e&quot;); background-position: right 1rem center; background-repeat: no-repeat; background-size: 1.5em 1.5em; padding-right: 2.5rem !important;"
                                class="block w-full appearance-none rounded-md border-0 py-1.5 pl-3 text-gray-900 dark:text-gray-100 ring-1 ring-inset ring-gray-300 dark:ring-gray-600 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6 dark:bg-gray-900 h-10">
                                <option value="">All Roles</option>
                                <option value="superadmin" {{ request('role') == 'superadmin' ? 'selected' : '' }}>Super
                                    Admin</option>
                                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="company" {{ request('role') == 'company' ? 'selected' : '' }}>Company
                                </option>
                                <option value="driver" {{ request('role') == 'driver' ? 'selected' : '' }}>Driver</option>
                            </select>
                        </div>

                        <!-- Company Filter -->
                        @if(auth()->user()->role !== 'company')
                            <div class="w-full sm:w-52 text-sm">
                                <label for="company_id"
                                    class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Company</label>
                                <select name="company_id" id="company_id"
                                    style="background-image: url(&quot;data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e&quot;); background-position: right 1rem center; background-repeat: no-repeat; background-size: 1.5em 1.5em; padding-right: 2.5rem !important;"
                                    class="block w-full appearance-none rounded-md border-0 py-1.5 pl-3 text-gray-900 dark:text-gray-100 ring-1 ring-inset ring-gray-300 dark:ring-gray-600 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6 dark:bg-gray-900 h-10">
                                    <option value="">All Companies</option>
                                    @foreach($companies as $company)
                                        <option value="{{ $company->id }}" {{ request('company_id') == $company->id ? 'selected' : '' }}>
                                            {{ Str::limit($company->name, 20) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        <!-- Actions -->
                        <button type="submit"
                            class="inline-flex items-center justify-center rounded-md bg-primary-600 px-4 py-2 text-sm font-semibold text-white hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600 h-10">
                            Filter
                        </button>

                        <a href="{{ route('users.index') }}"
                            class="inline-flex items-center justify-center rounded-md bg-white dark:bg-gray-700 px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 ring-1 ring-inset ring-gray-300 dark:ring-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 h-10"
                            title="Reset Filters">
                            <i class='bx bx-reset text-lg'></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="mt-8 flow-root">
        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                            <tr>
                                <th scope="col"
                                    class="py-3.5 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400 sm:pl-6">
                                    Name</th>
                                <th scope="col"
                                    class="px-3 py-3.5 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                                    Email</th>
                                <th scope="col"
                                    class="px-3 py-3.5 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                                    Role</th>
                                <th scope="col"
                                    class="px-3 py-3.5 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                                    Password</th>
                                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                    <span class="sr-only">Actions</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800">
                            @foreach ($users as $user)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-200">
                                    <td
                                        class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 dark:text-white sm:pl-6">
                                        <div class="flex items-center gap-x-3">
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random&color=fff"
                                                alt="" class="h-8 w-8 flex-none rounded-full">
                                            <span>{{ $user->name }}</span>
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">
                                        {{ $user->email }}
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">
                                        <span
                                            class="inline-flex items-center rounded-md bg-primary-50 dark:bg-primary-900/20 px-2 py-1 text-xs font-medium text-primary-700 dark:text-primary-400 ring-1 ring-inset ring-primary-700/10 dark:ring-primary-400/20">{{ ucfirst($user->role) }}</span>
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm">
                                        @if($user->force_password_change)
                                            <span class="inline-flex items-center gap-1 rounded-md bg-amber-50 dark:bg-amber-900/20 px-2 py-1 text-xs font-medium text-amber-700 dark:text-amber-400 ring-1 ring-inset ring-amber-600/20">
                                                <i class='bx bx-lock-alt'></i> Force Change
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 rounded-md bg-green-50 dark:bg-green-900/20 px-2 py-1 text-xs font-medium text-green-700 dark:text-green-400 ring-1 ring-inset ring-green-600/20">
                                                <i class='bx bx-check'></i> Updated
                                            </span>
                                        @endif
                                    </td>
                                    <td
                                        class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                        <div class="flex items-center justify-end gap-2">
                                            @if(in_array(auth()->user()->role, ['superadmin', 'admin']))
                                                <form action="{{ route('users.toggle-force-password', $user) }}" method="POST" class="inline-block">
                                                    @csrf
                                                    <button type="submit"
                                                        class="text-amber-600 hover:text-amber-900 dark:text-amber-400 dark:hover:text-amber-300 transition-colors"
                                                        title="{{ $user->force_password_change ? 'Disable force password change' : 'Force password change on next login' }}"
                                                        onclick="return confirm('{{ $user->force_password_change ? 'Disable force password change?' : 'Force user to change password on next login?' }}')">
                                                        <i class='bx bx-key text-xl'></i><span class="sr-only">Toggle Force Password, {{ $user->name }}</span>
                                                    </button>
                                                </form>
                                            @endif
                                            <a href="{{ route('users.show', $user) }}"
                                                class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 transition-colors">
                                                <i class='bx bx-show text-xl'></i><span class="sr-only">View,
                                                    {{ $user->name }}</span>
                                            </a>
                                            <a href="{{ route('users.edit', $user) }}"
                                                class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 transition-colors">
                                                <i class='bx bx-pencil text-xl'></i><span class="sr-only">Edit,
                                                    {{ $user->name }}</span>
                                            </a>
                                            @if(auth()->id() !== $user->id)
                                            <form action="{{ route('users.destroy', $user) }}" method="POST"
                                                class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 transition-colors"
                                                    onclick="return confirm('Are you sure?')">
                                                    <i class='bx bx-trash text-xl'></i><span class="sr-only">Delete,
                                                        {{ $user->name }}</span>
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <x-card-pagination :items="$users" />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>