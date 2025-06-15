@props([
    'data' => [],
    'columns' => [],
    'hasActions' => false,
    'routePrefix' => '',
    'searchable' => true,
    'perPageOptions' => [5, 10, 25, 50],
    'defaultSort' => 'name',
    'defaultPerPage' => 10,
    'searchFields' => ['name']
])

<div
    x-data="dataTable({
        data: {{ json_encode($data) }},
        columns: {{ json_encode($columns) }},
        hasActions: {{ json_encode($hasActions) }},
        routePrefix: '{{ $routePrefix }}',
        searchFields: {{ json_encode($searchFields) }},
        defaultSort: '{{ $defaultSort }}',
        defaultPerPage: {{ $defaultPerPage }}
    })"
>
    <!-- Filters -->
    @if($searchable)
    <div class="sm:flex sm:gap-x-4 mb-6">
        <!-- Search Input -->
        <div class="sm:w-64">
            <label class="sr-only">Search</label>
            <div class="relative rounded-md shadow-sm">
                <input 
                    type="text" 
                    x-model="search"
                    class="block w-full rounded-md border-gray-300 pr-10 focus:border-teal-500 focus:ring-teal-500 sm:text-sm" 
                    placeholder="Search..."
                >
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                    <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Per Page Filter -->
        <div class="sm:w-40 mt-4 sm:mt-0">
            <select x-model="perPage" class="block w-full rounded-md border-gray-300 focus:border-teal-500 focus:ring-teal-500 sm:text-sm">
                @foreach($perPageOptions as $option)
                    <option value="{{ $option }}">{{ $option }} per page</option>
                @endforeach
            </select>
        </div>
    </div>
    @endif

    <!-- Table -->
    <div class="overflow-x-auto">
        <div class="inline-block min-w-full align-middle">
            <div class="overflow-hidden ring-1 ring-gray-300 rounded-lg">
                <table class="min-w-full divide-y divide-gray-300">
                    <thead class="bg-gray-50">
                        <tr>
                            <template x-for="column in columns" :key="column.key">
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                    <div class="group inline-flex items-center gap-x-2 cursor-pointer"
                                         @click="sort(column.key)">
                                        <span x-text="column.label"></span>
                                        <span class="flex-none rounded text-gray-400">
                                            <template x-if="sortColumn === column.key">
                                                <svg class="h-4 w-4" viewBox="0 0 12 12" fill="none" 
                                                     :class="{ 'rotate-180': !sortAsc }">
                                                    <path d="M3.5 3.5L6 1m0 0l2.5 2.5M6 1v10" stroke="currentColor" 
                                                          stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                            </template>
                                        </span>
                                    </div>
                                </th>
                            </template>
                            @if($hasActions)
                                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                    <span class="sr-only">Actions</span>
                                </th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        <template x-for="item in paginatedData" :key="item.id">
                            <tr>
                                <template x-for="column in columns" :key="column.key">
                                    <td class="whitespace-nowrap px-3 py-4 text-sm" 
                                        :class="column.key === 'name' ? 'text-gray-900' : 'text-gray-500'"
                                        x-html="formatColumnValue(item, column)">
                                    </td>
                                </template>
                                @if($hasActions)
                                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                        <a :href="`/${routePrefix}/${item.id}/edit`" class="text-teal-600 hover:text-teal-900">Edit</a>
                                    </td>
                                @endif
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        <!-- Pagination -->
            <div class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6 mt-4 rounded-md">
                <!-- Mobile view -->
                <div class="flex flex-col space-y-3 sm:hidden w-full">
                    <p class="text-sm text-gray-700 text-center">
                        Page <span x-text="currentPage"></span> of <span x-text="totalPages"></span>
                    </p>
                    <div class="flex justify-center items-center">
                        <button @click="previousPage" 
                                :disabled="currentPage === 1"
                                class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0"
                                :class="{ 'opacity-50 cursor-not-allowed': currentPage === 1 }">
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z" clip-rule="evenodd" />
                            </svg>
                        </button>

                        <!-- Mobile page numbers -->
                        <div class="flex">
                            <template x-for="pageNumber in totalPages" :key="pageNumber">
                                <button @click="currentPage = pageNumber"
                                        class="relative inline-flex items-center px-4 py-2 text-sm font-semibold ring-1 ring-inset ring-gray-300 focus:z-20 focus:outline-offset-0"
                                        :class="currentPage === pageNumber ? 'bg-teal-600 text-white' : 'bg-white text-gray-700 border border-gray-300'">
                                    <span x-text="pageNumber"></span>
                                </button>
                            </template>
                        </div>

                        <button @click="nextPage"
                                :disabled="currentPage >= totalPages"
                                class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0"
                                :class="{ 'opacity-50 cursor-not-allowed': currentPage >= totalPages }">
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Desktop view -->
                <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-gray-700">
                            Showing <span x-text="startIndex + 1"></span> to <span x-text="Math.min(endIndex, filteredData.length)"></span> of
                            <span x-text="filteredData.length"></span> results
                        </p>
                    </div>
                    <div>
                        <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                            <!-- Previous button -->
                            <button @click="previousPage"
                                    :disabled="currentPage === 1"
                                    class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0"
                                    :class="{ 'opacity-50 cursor-not-allowed': currentPage === 1 }">
                                <span class="sr-only">Previous</span>
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z" clip-rule="evenodd" />
                                </svg>
                            </button>

                            <!-- Page numbers -->
                            <template x-for="pageNumber in totalPages" :key="pageNumber">
                                <button @click="currentPage = pageNumber"
                                        class="relative inline-flex items-center px-4 py-2 text-sm font-semibold ring-1 ring-inset ring-gray-300 focus:z-20 focus:outline-offset-0"
                                        :class="currentPage === pageNumber ? 'bg-teal-600 text-white hover:bg-teal-700' : 'text-gray-900 hover:bg-gray-50'">
                                    <span x-text="pageNumber"></span>
                                </button>
                            </template>

                            <!-- Next button -->
                            <button @click="nextPage"
                                    :disabled="currentPage >= totalPages"
                                    class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0"
                                    :class="{ 'opacity-50 cursor-not-allowed': currentPage >= totalPages }">
                                <span class="sr-only">Next</span>
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </nav>
                    </div>
                </div>
            </div>
    </div>
</div>

