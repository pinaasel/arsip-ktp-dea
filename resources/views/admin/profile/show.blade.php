@extends('layouts.app')

@section('title', 'Profil Admin - Arsip KTP')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-user-circle text-primary me-2"></i>Profil Admin
                    </h5>
                    <a href="{{ route('admin.profile.edit') }}" class="btn btn-warning">
                        <i class="fas fa-edit me-1"></i>Edit Profil
                    </a>
                </div>
                
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card mb-4">
                                <div class="card-header bg-primary text-white">
                                    <h6 class="mb-0">
                                        <i class="fas fa-image me-2"></i>Foto Profil
                                    </h6>
                                </div>
                                <div class="card-body p-0">
                                    @if(auth()->user()->foto)
                                        <img src="{{ asset('storage/' . auth()->user()->foto) }}" 
                                             alt="Foto {{ auth()->user()->name }}" 
                                             class="img-fluid"
                                             style="width: 100%; height: auto; object-fit: contain; max-height: none;">
                                    @else
                                        <img src="{{ asset('images/default-avatar.png') }}" 
                                             alt="Default Avatar" 
                                             class="img-fluid"
                                             style="width: 100%; height: auto; object-fit: contain; max-height: none;">
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-8">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="150">Nama Lengkap</th>
                                    <td>{{ auth()->user()->name }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ auth()->user()->email }}</td>
                                </tr>
                                <tr>
                                    <th>No. HP</th>
                                    <td>{{ auth()->user()->no_hp ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <td>{{ auth()->user()->alamat ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Role</th>
                                    <td>
                                        <span class="badge bg-primary">
                                            {{ ucfirst(auth()->user()->role) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <span class="badge bg-{{ auth()->user()->status === 'aktif' ? 'success' : 'danger' }}">
                                            {{ auth()->user()->status === 'aktif' ? 'Aktif' : 'Tidak Aktif' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Bergabung Pada</th>
                                    <td>{{ auth()->user()->created_at->format('d F Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">
                                        <i class="fas fa-chart-line text-primary me-2"></i>Statistik Aktivitas
                                    </h6>
                                    <div class="row mt-4">
                                        <div class="col-6 text-center">
                                            <h3 class="text-primary mb-1">{{ $totalKtp ?? 0 }}</h3>
                                            <p class="text-muted small mb-0">Total KTP</p>
                                        </div>
                                        <div class="col-6 text-center">
                                            <h3 class="text-success mb-1">{{ $totalPetugas ?? 0 }}</h3>
                                            <p class="text-muted small mb-0">Total Petugas</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">
                                        <i class="fas fa-clock text-primary me-2"></i>Login Terakhir
                                    </h6>
                                    <p class="mb-0 mt-4">
                                        @if(auth()->user()->last_login_at)
                                            {{ auth()->user()->last_login_at->format('d F Y H:i') }}
                                        @else
                                            -
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
