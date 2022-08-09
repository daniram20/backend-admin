@extends('layouts.app')
   
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <!-- Basic Bootstrap Table -->
  <div class="card">
    <h5 class="card-header">List Aplikasi</h5>
    <div class="table-responsive text-nowrap">
      <table class="table">
        <thead>
          <tr>
            <th>Icon</th>
            <th>Nama Aplikasi</th>
            <th>URL</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        @foreach ($listAplikasi as $aplikasi)
        <tbody class="table-border-bottom-0">
          <tr>
            <td><img src="/image/foto/{{ $aplikasi->foto }}" width="50px"></td>
            <td>{{ $aplikasi->nama }}</td>
            <td>{{ $aplikasi->url }}</td>
            <td>
              @if ($aplikasi->status == 1) 
                <span class="badge bg-label-primary me-1">Active</span>
              @else
                <span class="badge bg-label-danger me-1">Nonactive</span>
            @endif
            </td>
            <td>
              <div class="d-grid gap-2 d-md-flex">
                <a href="{{ route('list.edit', ['list' => $aplikasi->id]) }}"
                    class="btn btn-outline-success mr-4"> Edit
                    </a>
                <form method="POST" action="{{ route('list.destroy', $aplikasi->id) }}">
                    @csrf
                    <input name="_method" type="hidden" value="DELETE">
                    <button type="submit" class="btn btn-outline-danger show_confirm " data-toggle="tooltip"
                        title='Delete'>Hapus</button>
                </form>
            </div>
            </td>
          </tr>
        </tbody>
        @endforeach
      </table>
    </div>
  </div>
  <!--/ Basic Bootstrap Table -->

  
</div>
@endsection