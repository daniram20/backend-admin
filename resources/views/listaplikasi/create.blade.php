@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
      <div class="col-md-12">
        <div class="card mb-4">
          <h5 class="card-header">Tambah Aplikasi</h5>
          <form action="{{ route('list.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
              <div class="mb-3">
                <label for="defaultFormControlInput" class="form-label">Nama Aplikasi</label>
                <input
                  type="text"
                  class="form-control"
                  name="nama"
                />
              </div>
              <div class="mb-3">
                <label for="defaultFormControlInput" class="form-label">URL Aplikasi</label>
                <input
                  type="text"
                  class="form-control"
                  name="url"
                  value="https://"
                />
              </div>
              <div class="mb-3">
                <label for="defaultSelect" class="form-label">Status Aplikasi</label>
                <select id="defaultSelect" class="form-select" name="status">
                  <option value="1">Active</option>
                  <option value="0">Nonactive</option>
                </select>
              </div>
              <div class="mb-3">
                <label for="formFile" class="form-label">Icon Aplikasi</label>
                <input class="form-control" type="file" id="formFile" name="foto" />
              </div>
              <div class="col-xs-12 col-sm-12 col-md-12 text-right">
                <button type="submit" class="btn btn-outline-primary">Submit Data</button>
            </div>
            </div>
          </form>
        </div>
      </div>

    </div>
  </div>
@endsection
