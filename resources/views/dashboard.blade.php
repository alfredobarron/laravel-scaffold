@extends('layouts.app')

@section('content')
<div>
    <div class="container">
        <div class="card-body">
            @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
            @endif
            <div class="row justify-content-md-center">
                @can('read-events')
                <div class="col-md-6">
                    <a href="/events" class="text-decoration-none">
                    <div class="card">
                        <div class="card-body p-0 d-flex align-items-center">
                            <i class="fa fa-calendar bg-warning p-4 font-2xl mr-3"></i>
                            <div>
                                <div class="text-value-sm text-warning text-decoration-none">Eventos</div>
                            </div>
                        </div>
                    </div>
                    </a>
                </div>
                @endcan
                @can('read-quotes')
                <div class="col-md-6">
                    <a href="/quotes" class="text-decoration-none">
                    <div class="card">
                        <div class="card-body p-0 d-flex align-items-center">
                            <i class="fa fa-file bg-primary p-4 font-2xl mr-3"></i>
                            <div>
                                <div class="text-value-sm text-primary">Cotizaciones</div>
                            </div>
                        </div>
                    </div>
                    </a>
                </div>
                @endcan
                @can('read-quotescompanies')
                <div class="col-md-6">
                    <a href="/quotesCompanies" class="text-decoration-none">
                    <div class="card">
                        <div class="card-body p-0 d-flex align-items-center">
                            <i class="far fa-file bg-info p-4 font-2xl mr-3"></i>
                            <div>
                                <div class="text-value-sm text-info">Cotizaciones Empresa</div>
                            </div>
                        </div>
                    </div>
                    </a>
                </div>
                @endcan
                @can('read-users')
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body p-0 d-flex align-items-center">
                            <a href="/users" class="text-decoration-none">
                            <i class="fa fa-users bg-success p-4 font-2xl mr-3 text-decoration-none"></i>
                            </a>
                            <div>
                                <a href="/users" class="text-value-sm text-success text-decoration-none">Usuarios</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
