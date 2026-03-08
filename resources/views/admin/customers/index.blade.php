@extends('admin.layouts.app')

@section('content')
<div class="py-3 vd-page">

    {{-- Header --}}
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-2 mb-2">
        <div class="flex-grow-1">
            <h2 class="mb-0">Customer Management</h2>
            <small class="text-muted">Manage registered customers</small>
        </div>

        <div class="d-grid d-sm-flex gap-2">
            <a href="{{ route('admin.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Back
            </a>

            @if(Route::has('admin.customers.create'))
                <a href="{{ route('admin.customers.create') }}" class="btn btn-success">
                    <i class="bi bi-person-plus me-1"></i> Add Customer
                </a>
            @endif
        </div>
    </div>

    {{-- Search (client-side filter target) --}}
    <form method="GET" action="{{ route('admin.customers.index') }}" class="mb-3" autocomplete="off">
        <div class="input-group">
            <span class="input-group-text">
                <i class="bi bi-search"></i>
            </span>

            <input
                id="customerSearch"
                type="text"
                name="search"
                class="form-control"
                placeholder="Search name, email, phone..."
                value="{{ $search ?? request('search') }}"
                autocomplete="off"
            >

            @if(request()->filled('search'))
                <a href="{{ route('admin.customers.index') }}" class="btn btn-outline-secondary">
                    Clear
                </a>
            @endif
        </div>
    </form>

    {{-- Alerts --}}
    @if(session('success'))
        <div class="alert alert-success mb-3">
            {{ session('success') }}
        </div>
    @endif

    {{-- Counters --}}
    @php
        $hasCustomers = isset($customers) && $customers->count();
        $total = $totalCustomers ?? (method_exists($customers, 'total') ? $customers->total() : $customers->count());
        $filterText = request('search');
    @endphp

    @if($hasCustomers)
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
            <small class="text-muted">
                Total customers: <strong>{{ $total }}</strong>
            </small>

            @if(!empty($filterText))
                <small class="text-muted">
                    Filter: <span class="badge bg-secondary">{{ $filterText }}</span>
                </small>
            @endif
        </div>
    @endif

    {{-- =========================
         MOBILE VIEW (Cards)
         shows on < md
    ========================== --}}
    <div class="d-md-none" id="customerCards">
        @forelse($customers as $customer)
            <div
                class="vd-card mb-3 customer-card"
                data-search="{{ strtolower($customer->name.' '.$customer->email.' '.($customer->phone ?? '')) }}"
            >
                <div class="vd-card-body">
                    <div class="fw-semibold">{{ $customer->name }}</div>
                    <div class="text-muted small">{{ $customer->email }}</div>

                    <div class="mt-2">
                        <span class="text-muted small">Phone:</span>
                        <span class="fw-semibold">{{ $customer->phone ?? '—' }}</span>
                    </div>

                    <div class="mt-3">
                        <form action="{{ route('admin.customers.destroy', $customer->id) }}" method="POST">
                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="btn btn-sm btn-danger w-100"
                                onclick="return confirm('Delete this customer?')"
                            >
                                <i class="bi bi-trash me-1"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="vd-card">
                <div class="vd-card-body text-center vd-empty py-4">
                    No customers found.
                </div>
            </div>
        @endforelse
    </div>

    {{-- =========================
         DESKTOP VIEW (Table)
         shows on md+
    ========================== --}}
    <div class="vd-card d-none d-md-block">
        <div class="vd-card-body p-0">
            <div class="table-responsive">
                <table class="table vd-table-bs mb-0">
                    <thead class="vd-thead">
                        <tr>
                            <th style="min-width:200px;">Name</th>
                            <th style="min-width:240px;">Email</th>
                            <th style="min-width:160px;">Phone</th>
                            <th style="width:120px;">Actions</th>
                        </tr>
                    </thead>

                    <tbody id="customerTableBody">
                        @forelse($customers as $customer)
                            <tr
                                class="customer-row"
                                data-search="{{ strtolower($customer->name.' '.$customer->email.' '.($customer->phone ?? '')) }}"
                            >
                                <td class="fw-semibold">{{ $customer->name }}</td>
                                <td>{{ $customer->email }}</td>
                                <td>{{ $customer->phone ?? '—' }}</td>
                                <td>
                                    <form action="{{ route('admin.customers.destroy', $customer->id) }}"
                                          method="POST"
                                          class="d-inline">
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('Delete this customer?')"
                                        >
                                            <i class="bi bi-trash me-1"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center vd-empty py-4">
                                    No customers found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>
    </div>

    {{-- Pagination (ONE place only) --}}
    @if(isset($customers) && method_exists($customers, 'links') && $customers->hasPages())
        <div class="vd-card mt-3 vd-pagination-card">
            <div class="vd-card-body py-3 px-3 px-md-4">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
                    <small class="text-muted">
                        Showing {{ $customers->firstItem() ?? 0 }} to {{ $customers->lastItem() ?? 0 }}
                        of {{ $customers->total() }} customers
                    </small>

                    <div>
                        {{ $customers->onEachSide(1)->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
@endsection