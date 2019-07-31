@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Dashboard</div>

            <div class="card-body text-red">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                You are logged in!
                <button type="button" class="btn btn-raised btn-primary">Primary</button>
            </div>
        </div>
    </div>
  </div>
</div>
@endsection
