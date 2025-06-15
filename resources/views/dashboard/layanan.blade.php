@extends('layouts.app')

@section('title', 'Layanan')

@section('content')
<div class="">
    <x-breadcrumb :items="[['label' => 'Layanan']]" />

    <div class="mt-8">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-xl font-semibold text-gray-900">Layanan</h1>
            </div>
            <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                <a href="{{ route('service.create') }}" class="inline-flex items-center justify-center rounded-md border border-transparent bg-teal-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 sm:w-auto">
                    Add Layanan
                </a>
            </div>
        </div>

        <div class="mt-8">
            <x-data-table 
                :data="$services"
                :columns="[
                    ['key' => 'index', 'label' => 'No.', 'type' => 'index'],
                    ['key' => 'icon_url', 'label' => 'Icon', 'type' => 'image', 'width' => 'w-12 h-12'],
                    ['key' => 'title', 'label' => 'Judul', 'type' => 'text'],
                    ['key' => 'status', 'label' => 'Status', 'type' => 'status'],
                    ['key' => 'sort_order', 'label' => 'Urutan', 'type' => 'text'],
                    ['key' => 'created_at', 'label' => 'Tanggal Dibuat', 'type' => 'date'],
                ]"
                :has-actions="true"
                route-prefix="layanan"
                :searchable="true"
                :search-fields="['title']"
                default-sort=""
                :default-per-page="10"
            >
            </x-data-table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('dataTable', ({
        data = [],
        columns = [],
        hasActions = false,
        routePrefix = '',
        searchFields = ['name'],
        defaultSort = 'name',
        defaultPerPage = 10
    }) => ({
        data,
        columns,
        hasActions,
        routePrefix,
        search: '',
        sortColumn: defaultSort,
        sortAsc: true,
        currentPage: 1,
        perPage: defaultPerPage,

        get filteredData() {
            let filtered = this.data;
            if (this.search) {
                const searchTerm = this.search.toLowerCase();
                filtered = filtered.filter(item =>
                    searchFields.some(field =>
                        (item[field] || '').toString().toLowerCase().includes(searchTerm)
                    )
                );
            }
            filtered = filtered.sort((a, b) => {
                if (!this.sortColumn) return 0; // Tidak sort jika sortColumn kosong
                let modifier = this.sortAsc ? 1 : -1;
                let aVal = a[this.sortColumn];
                let bVal = b[this.sortColumn];
                if (!isNaN(aVal) && !isNaN(bVal)) {
                    return (Number(aVal) - Number(bVal)) * modifier;
                }
                aVal = aVal?.toString().toLowerCase() ?? '';
                bVal = bVal?.toString().toLowerCase() ?? '';
                return aVal < bVal ? -1 * modifier : aVal > bVal ? 1 * modifier : 0;
            });
            return filtered;
        },

        get totalPages() {
            return Math.ceil(this.filteredData.length / this.perPage);
        },

        get startIndex() {
            return (this.currentPage - 1) * this.perPage;
        },

        get endIndex() {
            return this.startIndex + this.perPage;
        },

        get paginatedData() {
            return this.filteredData.slice(this.startIndex, this.endIndex).map((item, index) => ({
                ...item,
                index: this.startIndex + index + 1
            }));
        },

        previousPage() {
            if (this.currentPage > 1) this.currentPage--;
        },

        nextPage() {
            if (this.currentPage < this.totalPages) this.currentPage++;
        },

        sort(column) {
            if (this.sortColumn === column) {
                this.sortAsc = !this.sortAsc;
            } else {
                this.sortColumn = column;
                this.sortAsc = true;
            }
        },

        formatColumnValue(item, column) {
            const value = item[column.key];
            switch (column.type) {
                case 'index':
                    return item.index;
                case 'image':
                    if (item.icon) {
                        return `<img src="${item.icon}" class="${column.width ?? 'w-16 h-16'} object-cover rounded" alt="Gambar">`;
                    } else {
                        return '<span class="text-gray-500">No Image</span>';
                    }
                case 'price':
                    return this.formatPrice(value);
                case 'date':
                    return this.formatDate(value);
                case 'status':
                    return this.formatStatus(value);
                default:
                    return value ?? '';
            }
        },
        formatPrice(price) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(price ?? 0);
        },
        formatDate(date) {
            return date ? new Date(date).toLocaleDateString('id-ID') : '';
        },
        formatStatus(status) {
            const statusClasses = {
                active: 'text-green-600 bg-green-100',
                inactive: 'text-red-600 bg-red-100',
                pending: 'text-yellow-600 bg-yellow-100'
            };
            return `<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${statusClasses[status] || ''}">${status}</span>`;
        },
    }));
});
</script>
@endpush