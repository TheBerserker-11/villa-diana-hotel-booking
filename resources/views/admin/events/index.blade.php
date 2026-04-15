@extends('admin.layouts.app')

@section('title','Event Management')

@section('content')
@include('components.show-success')

<div class="py-3 vd-page">

    {{-- Header --}}
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-3">
        <div class="flex-grow-1">
            <h2 class="mb-0">Event Management</h2>
            <small class="vd-small-muted">Manage events and images</small>
        </div>

        {{-- Mobile-friendly buttons: stacked on xs, inline on sm+ --}}
        <div class="d-grid gap-2 d-sm-flex justify-content-sm-end">
            <a href="{{ route('admin.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Back
            </a>

            <a href="{{ route('admin.events.create') }}" class="btn btn-success">
                <i class="bi bi-plus-lg me-1"></i> Add Event
            </a>
        </div>
    </div>

    <div class="vd-card">
        <div class="vd-card-body">

            {{-- =========================
                 MOBILE VIEW (Cards)
                 shows on < md
            ========================== --}}
            <div class="d-md-none">
                @forelse($events as $event)
                    <div class="vd-card mb-3">
                        <div class="vd-card-body">

                            <div class="d-flex align-items-center gap-3">
                                <div style="width:70px; height:70px;">
                                    @if($event->image)
                                        <img
                                            src="{{ $event->image_url }}"
                                            class="rounded"
                                            style="width:70px;height:70px;object-fit:cover;"
                                            alt="Event Image">
                                    @else
                                        <div class="rounded d-flex align-items-center justify-content-center"
                                             style="width:70px;height:70px;background:rgba(255,255,255,.06);">
                                            <span class="vd-empty">N/A</span>
                                        </div>
                                    @endif
                                </div>

                                <div class="flex-grow-1">
                                    <div class="fw-semibold">{{ $event->name }}</div>
                                    <div class="vd-small-muted">Main image preview</div>
                                </div>
                            </div>

                            <div class="d-flex gap-2 mt-3">
                                <a href="{{ route('admin.events.edit', $event->id) }}"
                                   class="btn btn-sm btn-warning flex-grow-1">
                                    <i class="bi bi-pencil-square me-1"></i> Edit
                                </a>

                                <form action="{{ route('admin.events.destroy', $event->id) }}"
                                      method="POST"
                                      class="flex-grow-1"
                                      onsubmit="return confirm('Delete this event?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger w-100">
                                        <i class="bi bi-trash me-1"></i> Delete
                                    </button>
                                </form>
                            </div>

                        </div>
                    </div>
                @empty
                    <div class="text-center vd-empty py-4">No events found.</div>
                @endforelse
            </div>

            {{-- =========================
                 DESKTOP VIEW (Table)
                 shows on md+
            ========================== --}}
            <div class="table-responsive d-none d-md-block">
                <table class="table vd-table-bs vd-striped align-middle mb-0">
                    <thead class="vd-thead">
                        <tr>
                            <th style="min-width:240px;">Event Name</th>
                            <th style="width:140px;" class="text-center">Main Image</th>
                            <th style="width:170px;" class="text-end">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($events as $event)
                            <tr>
                                <td class="fw-semibold">{{ $event->name }}</td>

                                <td class="text-center">
                                    @if($event->image)
                                        <img
                                            src="{{ $event->image_url }}"
                                            class="rounded"
                                            style="width:70px;height:70px;object-fit:cover;"
                                            alt="Event Image">
                                    @else
                                        <span class="vd-empty">No Image</span>
                                    @endif
                                </td>

                                <td class="text-end">
                                    <div class="d-inline-flex gap-2 align-items-center">
                                        <a href="{{ route('admin.events.edit', $event->id) }}"
                                           class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <form action="{{ route('admin.events.destroy', $event->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Delete this event?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center vd-empty py-4">No events found.</td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>
    </div>

</div>
@endsection
