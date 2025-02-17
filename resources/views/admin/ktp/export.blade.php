@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Export Data KTP</h2>
                </div>

                <div class="card-body">
                    <div class="row">
                        <!-- Export Semua Data KTP -->
                        <div class="col-md-6 mx-auto mb-4">
                            <div class="card">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Data KTP</h5>
                                    <p class="card-text">Export semua data KTP ke dalam format PDF</p>
                                    <a href="{{ route('admin.ktp.export') }}" class="btn btn-primary" target="_blank">
                                        <i class="fas fa-file-export me-2"></i> Export Data KTP
                                    </a>
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
