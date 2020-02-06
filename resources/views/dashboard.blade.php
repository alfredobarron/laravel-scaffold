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
                                <div class="text-value-sm text-warning">Eventos</div>
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
                                <quotes-count-pendientes></quotes-count-pendientes>
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
                                <!-- <quotes-companies-count-pendientes></quotes-companies-count-pendientes> -->
                            </div>
                        </div>
                    </div>
                    </a>
                </div>
                @endcan
                @can('read-users')
                <div class="col-md-6">
                    <a href="/users" class="text-decoration-none">
                    <div class="card">
                        <div class="card-body p-0 d-flex align-items-center">
                            <i class="fa fa-user bg-success p-4 font-2xl mr-3"></i>
                            <div>
                                <div href="/users" class="text-value-sm text-success">Usuarios</div>
                            </div>
                        </div>
                    </div>
                    </a>
                </div>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
