<?php

$viewsDir = __DIR__ . '/resources/views/donor';

// Create directory if not exists
if (!is_dir($viewsDir)) {
    mkdir($viewsDir, 0777, true);
    echo "Created directory: $viewsDir\n";
}

// File 1: search_index.blade.php
$indexFile = $viewsDir . '/search_index.blade.php';
$indexContent = <<<'BLADE'
@extends('layouts.app')

@section('title', 'Search Blood - Blood Donation System')

@section('content')
<div class="dashboard-wrapper">
    
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            <div class="brand-icon">🩸</div>
            <div class="brand-text">
                <h2>BloodBank</h2>
                <span>Donor Portal</span>
            </div>
        </div>
        
        <nav class="sidebar-nav">
            <a href="{{ route('donor.dashboard') }}" class="nav-item">
                <span class="nav-icon">📊</span>
                Dashboard
            </a>
            <a href="{{ route('donor.search') }}" class="nav-item active">
                <span class="nav-icon">🔍</span>
                Search Blood
            </a>
            <a href="{{ route('donor.appointments') }}" class="nav-item">
                <span class="nav-icon">📅</span>
                My Appointments
            </a>
            <a href="#" class="nav-item">
                <span class="nav-icon">📋</span>
                Donation History
            </a>
            <a href="#" class="nav-item">
                <span class="nav-icon">⚙️</span>
                Settings
            </a>
        </nav>
        
        <div class="sidebar-footer">
            <div class="user-preview">
                <div class="user-avatar">{{ substr(auth()->user()->name, 0, 1) }}</div>
                <div class="user-info-small">
                    <h4>{{ auth()->user()->name }}</h4>
                    <span>{{ auth()->user()->email }}</span>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">
                    <span>🚪</span> Sign Out
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        
        <div class="top-bar">
            <div class="page-title">
                <h1>Search Blood</h1>
                <p>Find blood donors or check blood bank availability.</p>
            </div>
            <div class="top-actions">
                <span class="role-tag donor">Donor</span>
            </div>
        </div>

        <!-- Search Form Card -->
        <div class="card" style="max-width: 800px; margin: 0 auto;">
            <div class="card-header">
                <div class="card-title">
                    <span class="icon">🔍</span>
                    Blood Search
                </div>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('donor.search.submit') }}" id="searchForm">
                    @csrf

                    <div style="margin-bottom: 24px;">
                        <label style="font-size: 14px; color: var(--gray-600); margin-bottom: 12px; display: block; font-weight: 600;">
                            Select Blood Type Needed *
                        </label>
                        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px;">
                            @foreach($bloodTypes as $type)
                            <label style="cursor: pointer;">
                                <input type="radio" name="blood_type" value="{{ $type }}" style="display: none;" {{ old('blood_type') == $type ? 'checked' : '' }} required>
                                <span class="blood-type-btn">{{ $type }}</span>
                            </label>
                            @endforeach
                        </div>
                        @error('blood_type')
                            <span style="color: #ef4444; font-size: 13px; margin-top: 6px; display: block;">⚠ {{ $message }}</span>
                        @enderror
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 24px;">
                        <div>
                            <label class="form-label">City (Optional)</label>
                            <input type="text" name="city" class="form-input" value="{{ old('city') }}" placeholder="Enter city name" list="cities-list">
                            <datalist id="cities-list">
                                @foreach($cities as $c)
                                    <option value="{{ $c }}">
                                @endforeach
                            </datalist>
                        </div>
                        <div>
                            <label class="form-label">Search In *</label>
                            <div style="display: flex; gap: 12px; margin-top: 8px;">
                                <label style="flex: 1; cursor: pointer;">
                                    <input type="radio" name="search_type" value="donors" checked style="display: none;">
                                    <span class="search-type-btn">👥 Donors</span>
                                </label>
                                <label style="flex: 1; cursor: pointer;">
                                    <input type="radio" name="search_type" value="blood_bank" style="display: none;">
                                    <span class="search-type-btn">🏥 Blood Bank</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">🔍 Search Now</button>
                </form>
            </div>
        </div>

        <!-- Compatibility Guide -->
        <div class="card" style="max-width: 800px; margin: 24px auto 0;">
            <div class="card-header">
                <div class="card-title">
                    <span class="icon">ℹ️</span>
                    Blood Compatibility Guide
                </div>
            </div>
            <div class="card-body">
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px;">
                    <div style="padding: 16px; background: var(--gray-50); border-radius: 10px; border-left: 4px solid var(--primary);">
                        <h4 style="font-size: 16px; font-weight: 700; color: var(--gray-900); margin-bottom: 6px;">O-</h4>
                        <p style="font-size: 13px; color: var(--gray-500); line-height: 1.5;">Universal Donor - Can donate to <strong style="color: var(--primary);">all blood types</strong></p>
                    </div>
                    <div style="padding: 16px; background: var(--gray-50); border-radius: 10px; border-left: 4px solid var(--primary);">
                        <h4 style="font-size: 16px; font-weight: 700; color: var(--gray-900); margin-bottom: 6px;">AB+</h4>
                        <p style="font-size: 13px; color: var(--gray-500); line-height: 1.5;">Universal Recipient - Can receive from <strong style="color: var(--primary);">all blood types</strong></p>
                    </div>
                    <div style="padding: 16px; background: var(--gray-50); border-radius: 10px; border-left: 4px solid #2563eb;">
                        <h4 style="font-size: 16px; font-weight: 700; color: var(--gray-900); margin-bottom: 6px;">A+</h4>
                        <p style="font-size: 13px; color: var(--gray-500); line-height: 1.5;">Can receive from: <strong>A+, A-, O+, O-</strong></p>
                    </div>
                    <div style="padding: 16px; background: var(--gray-50); border-radius: 10px; border-left: 4px solid #059669;">
                        <h4 style="font-size: 16px; font-weight: 700; color: var(--gray-900); margin-bottom: 6px;">B+</h4>
                        <p style="font-size: 13px; color: var(--gray-500); line-height: 1.5;">Can receive from: <strong>B+, B-, O+, O-</strong></p>
                    </div>
                </div>
            </div>
        </div>

    </main>
</div>

<style>
.blood-type-btn {
    display: block;
    padding: 16px;
    text-align: center;
    border: 2px solid var(--gray-200);
    border-radius: 12px;
    font-weight: 700;
    font-size: 18px;
    color: var(--gray-600);
    transition: all 0.3s ease;
}
.blood-type-btn:hover {
    border-color: var(--primary);
    color: var(--primary);
}
input[type="radio"]:checked + .blood-type-btn {
    border-color: var(--primary);
    background: var(--primary-light);
    color: var(--primary);
    box-shadow: 0 4px 12px rgba(220, 38, 38, 0.15);
    transform: scale(1.05);
}

.search-type-btn {
    display: block;
    padding: 12px;
    text-align: center;
    border: 2px solid var(--gray-200);
    border-radius: 10px;
    font-weight: 500;
    color: var(--gray-600);
    transition: all 0.3s ease;
}
input[type="radio"]:checked + .search-type-btn {
    border-color: var(--primary);
    background: var(--primary-light);
    color: var(--primary);
}
</style>
@endsection
BLADE;

// File 2: search_results.blade.php
$resultsFile = $viewsDir . '/search_results.blade.php';
$resultsContent = <<<'BLADE'
@extends('layouts.app')

@section('title', 'Search Results - Blood Donation System')

@section('content')
<div class="dashboard-wrapper">
    
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            <div class="brand-icon">🩸</div>
            <div class="brand-text">
                <h2>BloodBank</h2>
                <span>Donor Portal</span>
            </div>
        </div>
        
        <nav class="sidebar-nav">
            <a href="{{ route('donor.dashboard') }}" class="nav-item">
                <span class="nav-icon">📊</span>
                Dashboard
            </a>
            <a href="{{ route('donor.search') }}" class="nav-item active">
                <span class="nav-icon">🔍</span>
                Search Blood
            </a>
            <a href="{{ route('donor.appointments') }}" class="nav-item">
                <span class="nav-icon">📅</span>
                My Appointments
            </a>
            <a href="#" class="nav-item">
                <span class="nav-icon">📋</span>
                Donation History
            </a>
            <a href="#" class="nav-item">
                <span class="nav-icon">⚙️</span>
                Settings
            </a>
        </nav>
        
        <div class="sidebar-footer">
            <div class="user-preview">
                <div class="user-avatar">{{ substr(auth()->user()->name, 0, 1) }}</div>
                <div class="user-info-small">
                    <h4>{{ auth()->user()->name }}</h4>
                    <span>{{ auth()->user()->email }}</span>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">
                    <span>🚪</span>
                    Sign Out
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        
        <div class="top-bar">
            <div class="page-title">
                <h1>Search Results</h1>
                <p>Found {{ $results->count() }} result(s) for blood type <strong style="color: var(--primary);">{{ $bloodType }}</strong></p>
            </div>
            <div class="top-actions">
                <a href="{{ route('donor.search') }}" class="btn btn-sm btn-secondary" style="width: auto;">← New Search</a>
                <span class="role-tag donor">Donor</span>
            </div>
        </div>

        @if($results->count() > 0)
            
            @if($searchType === 'donors')
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 20px;">
                    @foreach($results as $donor)
                    <div style="background: var(--white); border-radius: 16px; padding: 24px; box-shadow: var(--shadow); border: 1px solid var(--gray-100);">
                        <div style="display: flex; align-items: center; gap: 14px; margin-bottom: 20px; padding-bottom: 16px; border-bottom: 1px solid var(--gray-100);">
                            <div style="width: 50px; height: 50px; background: linear-gradient(135deg, var(--primary), var(--primary-dark)); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 20px;">
                                {{ substr($donor->user->name, 0, 1) }}
                            </div>
                            <div style="flex: 1;">
                                <h3 style="font-size: 16px; font-weight: 700; color: var(--gray-900);">{{ $donor->user->name }}</h3>
                                <span style="font-size: 13px; color: var(--gray-400);">📍 {{ $donor->city }}</span>
                            </div>
                            <div style="padding: 8px 16px; border-radius: 10px; font-weight: 800; font-size: 18px; background: #fef2f2; color: #dc2626;">
                                {{ $donor->blood_type }}
                            </div>
                        </div>
                        
                        <div style="margin-bottom: 20px;">
                            <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid var(--gray-50);">
                                <span style="font-size: 13px; color: var(--gray-400);">Age</span>
                                <span style="font-size: 13px; color: var(--gray-700); font-weight: 600;">{{ $donor->age() }} years</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid var(--gray-50);">
                                <span style="font-size: 13px; color: var(--gray-400);">Gender</span>
                                <span style="font-size: 13px; color: var(--gray-700); font-weight: 600;">{{ ucfirst($donor->gender) }}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid var(--gray-50);">
                                <span style="font-size: 13px; color: var(--gray-400);">Weight</span>
                                <span style="font-size: 13px; color: var(--gray-700); font-weight: 600;">{{ $donor->weight }} kg</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; padding: 8px 0;">
                                <span style="font-size: 13px; color: var(--gray-400);">Availability</span>
                                <span style="font-size: 13px; font-weight: 600; color: {{ $donor->canDonate() ? '#10b981' : '#ef4444' }};">
                                    {{ $donor->canDonate() ? '● Available' : '● Not Available' }}
                                </span>
                            </div>
                        </div>

                        <div style="display: flex; gap: 10px;">
                            <a href="tel:{{ $donor->phone }}" class="btn btn-sm btn-primary" style="flex: 1;">📞 Call</a>
                            <a href="mailto:{{ $donor->user->email }}" class="btn btn-sm btn-secondary" style="flex: 1;">✉️ Email</a>
                        </div>
                    </div>
                    @endforeach
                </div>

            @else
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <span class="icon">🏥</span>
                            Blood Bank Stock
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-wrap">
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th>Blood Type</th>
                                        <th>Available</th>
                                        <th>Reserved</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($results as $stock)
                                    <tr>
                                        <td>
                                            <span style="padding: 6px 14px; border-radius: 20px; font-weight: 700; background: #fef2f2; color: #dc2626;">{{ $stock->blood_type }}</span>
                                        </td>
                                        <td style="font-weight: 700;">{{ $stock->units_available }}</td>
                                        <td>{{ $stock->units_reserved }}</td>
                                        <td style="font-weight: 700;">{{ $stock->totalUnits() }}</td>
                                        <td>
                                            @if($stock->units_available < 10)
                                                <span style="padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; background: #fef2f2; color: #dc2626;">● Critical</span>
                                            @elseif($stock->units_available < 25)
                                                <span style="padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; background: #fffbeb; color: #d97706;">● Low</span>
                                            @else
                                                <span style="padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; background: #ecfdf5; color: #059669;">● Adequate</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

        @else
            <div style="text-align: center; padding: 80px 24px; background: var(--white); border-radius: 16px; box-shadow: var(--shadow);">
                <div style="font-size: 64px; margin-bottom: 20px;">😔</div>
                <h3 style="font-size: 22px; font-weight: 700; color: var(--gray-900); margin-bottom: 8px;">No Results Found</h3>
                <p style="color: var(--gray-500); margin-bottom: 24px;">We couldn't find any {{ $searchType === 'donors' ? 'donors' : 'blood stock' }} matching your criteria.</p>
                <a href="{{ route('donor.search') }}" class="btn btn-primary" style="width: auto;">Try Another Search</a>
            </div>
        @endif

    </main>
</div>
@endsection
BLADE;

// Write files
file_put_contents($indexFile, $indexContent);
echo "Created: $indexFile (" . filesize($indexFile) . " bytes)\n";

file_put_contents($resultsFile, $resultsContent);
echo "Created: $resultsFile (" . filesize($resultsFile) . " bytes)\n";

echo "\n✅ All view files created successfully!\n";
echo "Now run: php artisan view:clear\n";