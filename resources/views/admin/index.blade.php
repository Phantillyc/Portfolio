@extends('admin.layout')

@section('admin-title')
    Dashboard
@endsection

@section('admin-content')
    {!! breadcrumbs(['Admin Panel' => 'admin']) !!}

    @if (config('aldebaran.commissions.enabled'))
        <div class="card mb-4 border-primary">
            <div class="card-body">
                <h3 class="mb-2">Commission Admin</h3>
                <p class="mb-3">Manage queues, commission data, and portal settings from here.</p>
                <div class="d-flex flex-wrap">
                    <a href="{{ url('admin/data/commissions/classes') }}" class="btn btn-primary mr-2 mb-2">Commission Classes</a>
                    <a href="{{ url('admin/data/commissions/categories') }}" class="btn btn-primary mr-2 mb-2">Commission Categories</a>
                    <a href="{{ url('admin/data/commissions/types') }}" class="btn btn-primary mr-2 mb-2">Commission Types</a>
                    <a href="{{ url('admin/site-settings') }}" class="btn btn-outline-primary mb-2">Commission Settings</a>
                </div>
            </div>
        </div>

        @if (isset($commissionClasses) && $commissionClasses->count())
            <div class="row">
                @foreach ($commissionClasses as $class)
                    <div class="col-sm mb-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <h4 class="card-title">{{ $class->name }} Queues</h4>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <span class="float-right"><a href="{{ url('admin/commissions/' . $class->slug . '/pending') }}">View
                                                Queue
                                                <span class="fas fa-caret-right ml-1"></span></a></span>
                                        <h5>Pending @if ($pendingCount['commissions'][$class->id])
                                                <span class="badge badge-primary text-light ml-2" style="font-size: 1em;">{{ $pendingCount['commissions'][$class->id] }}</span>
                                            @endif
                                        </h5>
                                    </li>
                                    <li class="list-group-item">
                                        <span class="float-right"><a href="{{ url('admin/commissions/' . $class->slug . '/accepted') }}">View
                                                Queue
                                                <span class="fas fa-caret-right ml-1"></span></a></span>
                                        <h5>Accepted @if ($acceptedCount['commissions'][$class->id])
                                                <span class="badge badge-primary text-light ml-2" style="font-size: 1em;">{{ $acceptedCount['commissions'][$class->id] }}</span>
                                            @endif
                                        </h5>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm mb-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <h4 class="card-title">{{ $class->name }} Quote Queues</h4>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <span class="float-right"><a href="{{ url('admin/commissions/quotes/' . $class->slug . '/pending') }}">View
                                                Queue
                                                <span class="fas fa-caret-right ml-1"></span></a></span>
                                        <h5>Pending @if ($pendingCount['quotes'][$class->id])
                                                <span class="badge badge-primary text-light ml-2" style="font-size: 1em;">{{ $pendingCount['quotes'][$class->id] }}</span>
                                            @endif
                                        </h5>
                                    </li>
                                    <li class="list-group-item">
                                        <span class="float-right"><a href="{{ url('admin/commissions/quotes/' . $class->slug . '/accepted') }}">View
                                                Queue
                                                <span class="fas fa-caret-right ml-1"></span></a></span>
                                        <h5>Accepted @if ($acceptedCount['quotes'][$class->id])
                                                <span class="badge badge-primary text-light ml-2" style="font-size: 1em;">{{ $acceptedCount['quotes'][$class->id] }}</span>
                                            @endif
                                        </h5>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="w-100"></div>
                @endforeach
            </div>
        @else
            <p>There are no commission classes to display queues for. Go <a href="{{ url('admin/data/commissions/classes') }}">here</a> to create one!</p>
        @endif
    @endif

@endsection
