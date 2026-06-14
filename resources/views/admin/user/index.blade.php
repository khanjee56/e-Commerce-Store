@extends('layouts.app')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2> Manage Users</h2>
    
</div>
@if(session('success'))
    {{ session('success') }}
@endif

<div class="table-responsive">
    <table  class="table table-bordered align-middle">
        <thead class="table-dark">
             <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Action</th>
             </tr>
        </thead>
   @foreach($users as $user)
        <tr>
           
            <td>{{ $user->name }}</td>
            <td>{{$user->email}}</td>
            <td>{{$user->role}}</td>
            <td><a href="/admin/delete/{{ $user->id }}">delete</a></td>
      
    
        </tr>
        @endforeach
    </table>
</div>
@endsection