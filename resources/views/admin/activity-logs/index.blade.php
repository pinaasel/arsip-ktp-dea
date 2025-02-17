@extends('layouts.app')

@section('title', 'Log Aktivitas - Arsip KTP')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Log Aktivitas</h1>
    </div>

    <div class="row">
        <!-- Status Pengguna -->
        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-users me-2"></i>Status Pengguna
                    </h6>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        @foreach($users as $user)
                            @php
                                $lastActivity = $user->activityLogs()->latest('last_seen_at')->first();
                                $isOnline = $lastActivity && $lastActivity->last_seen_at && $lastActivity->last_seen_at->diffInMinutes(now()) <= 5;
                            @endphp
                            <a href="{{ route('admin.activity-logs.user', $user->id) }}" 
                               class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">{{ $user->name }}</h6>
                                        <small class="text-muted">{{ $user->email }}</small>
                                    </div>
                                    <div class="text-end">
                                        @if($isOnline)
                                            <span class="badge bg-success">Online</span>
                                        @else
                                            <span class="badge bg-secondary">Offline</span>
                                            @if($lastActivity && $lastActivity->last_seen_at)
                                                <br>
                                                <small class="text-muted">
                                                    {{ $lastActivity->last_seen_at->diffForHumans() }}
                                                </small>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Aktivitas Terbaru -->
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-history me-2"></i>Aktivitas Terbaru
                    </h6>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        @forelse($recentActivities as $activity)
                        <div class="timeline-item mb-3 pb-3 border-bottom">
                            <div class="timeline-content">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div>
                                        <i class="fas fa-history text-primary me-2"></i>
                                        <small class="text-muted">
                                            {{ $activity->last_seen_at ? $activity->last_seen_at->format('d/m/Y H:i') : '-' }}
                                        </small>
                                    </div>
                                    <div>
                                        <span class="badge bg-info">{{ ucfirst($activity->activity_type) }}</span>
                                    </div>
                                </div>
                                <div class="mb-1">
                                    <small class="text-muted">Pengguna:</small>
                                    <span class="fw-bold">{{ $activity->user->name }}</span>
                                </div>
                                @if($activity->activity_type === 'login')
                                <div class="mt-2">
                                    <p class="mb-0 text-primary">Login</p>
                                </div>
                                @elseif($activity->activity_type === 'logout')
                                <div class="mt-2">
                                    <p class="mb-0 text-danger">{{ $activity->description }}</p>
                                </div>
                                @endif
                                @if($activity->properties && $activity->activity_type !== 'logout')
                                <div class="mt-2">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-info-circle text-primary me-2"></i>
                                        <small class="text-muted">Detail Aktivitas:</small>
                                    </div>
                                    <div class="bg-white p-2 rounded">
                                        <div class="row g-2">
                                            <div class="col-12">
                                                <span class="text-dark">{{ $activity->description }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        @empty
                        <div class="text-center text-muted">
                            <i class="fas fa-info-circle me-2"></i>Belum ada aktivitas
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding: 20px 0;
}

.timeline-item {
    position: relative;
}

.timeline-item:before {
    content: '';
    position: absolute;
    left: -20px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e3e6f0;
}

.timeline-content {
    position: relative;
    padding-left: 20px;
}

.timeline-content:before {
    content: '';
    position: absolute;
    left: -4px;
    top: 0;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: #4e73df;
}
</style>
@endsection
