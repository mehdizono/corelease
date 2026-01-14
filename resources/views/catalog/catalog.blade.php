@extends('layouts.app')

@section('title', 'Resource Catalog')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/pages/catalog.css') }}">
@endsection

@section('content')
<div class="catalog-page container">
    <header class="catalog-header animate-fade-in">
        <h1 class="page-title">Technical Resource Catalog</h1>
        <p class="page-subtitle text-secondary">Browse our high-performance computing nodes, storage clusters, and specialized hardware specifications.</p>
    </header>

    <div class="catalog-layout">
        <!-- Sidebar Filters -->
        <aside class="catalog-sidebar animate-fade-in">
            <div class="filter-section">
                <h3 class="filter-title">Filter by Category</h3>
                <div class="filter-options">
                    <label class="filter-checkbox">
                        <input type="checkbox" name="category" value="Server" checked>
                        <span>Server Nodes</span>
                    </label>
                    <label class="filter-checkbox">
                        <input type="checkbox" name="category" value="VM" checked>
                        <span>Virtual Machines</span>
                    </label>
                    <label class="filter-checkbox">
                        <input type="checkbox" name="category" value="Storage" checked>
                        <span>Storage Clusters</span>
                    </label>
                    <label class="filter-checkbox">
                        <input type="checkbox" name="category" value="Network" checked>
                        <span>Networking</span>
                    </label>
                </div>
            </div>

            <div class="filter-section">
                <h3 class="filter-title">Availability</h3>
                <div class="filter-options">
                    <label class="filter-checkbox">
                        <input type="checkbox" name="status" value="Enabled" checked>
                        <span>Online & Available</span>
                    </label>
                    <label class="filter-checkbox">
                        <input type="checkbox" name="status" value="Disabled">
                        <span>Maintenance / Offline</span>
                    </label>
                </div>
            </div>

            <div class="sidebar-info">
                <p class="text-muted"><i class="icon-info"></i> Justified access is required for all resources. <a href="/apply">Apply for access</a> if you are a new researcher.</p>
            </div>
        </aside>

        <!-- Resource Grid -->
        <main class="catalog-main">
            <div class="catalog-grid animate-fade-in">
                @forelse ($resources as $resource)
                    <x-ui.card class="resource-card">
                        <div class="card-header">
                            <span class="category-tag">{{ $resource->category }}</span>
                            <span class="status-indicator {{ $resource->status === 'Enabled' ? 'status-online' : 'status-offline' }}"></span>
                        </div>
                        
                        <h3 class="resource-name">{{ $resource->name }}</h3>
                        
                        <div class="resource-specs">
                            @if(is_array($resource->specs))
                                <div class="specs-list">
                                    @foreach($resource->specs as $key => $value)
                                        <div class="spec-item">
                                            <span class="spec-key">{{ ucfirst(str_replace('_', ' ', $key)) }}:</span>
                                            <span class="spec-value">{{ is_bool($value) ? ($value ? 'Yes' : 'No') : $value }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-muted">No specifications available.</p>
                            @endif
                        </div>

                        <div class="card-footer">
                            @auth
                                <x-ui.button href="/reservations/create?resource={{ $resource->id }}" variant="primary" style="width: 100%;">
                                    Reserve Node
                                </x-ui.button>
                            @else
                                <x-ui.button href="/login" variant="secondary" style="width: 100%;">
                                    Login to Reserve
                                </x-ui.button>
                            @endauth
                        </div>
                    </x-ui.card>
                @empty
                    <div class="empty-state">
                        <p class="text-secondary">No resources match your current filters.</p>
                    </div>
                @endforelse
            </div>

            <div class="catalog-pagination">
                {{ $resources->links('vendor.pagination.custom') }}
            </div>
        </main>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        // Future: Implement client-side filtering logic here
        console.log('Catalog page initialized');
    </script>
@endsection