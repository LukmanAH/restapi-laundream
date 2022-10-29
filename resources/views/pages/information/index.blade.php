@extends('layouts.admin')

@section('title')
    Information
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Daftar Informasi / Pengumuman</h6>
                    </div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success mt-3">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="table">
                            <table class="table table-bordered" id="example1" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Title</th>
                                        <th>Created By</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                        {{-- <th>Aksi</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($info as $information)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $information->title }}</td>
                                            <td>{{ $information->user->name }}</td>
                                            <td>
                                                @if ($information->status == '1')
                                                    <span class="badge badge-info">Aktif</span>
                                                @else
                                                    <span class="badge badge-danger">Tidak Aktif</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.informations.edit', $information) }}"
                                                    class="btn btn-xs btn-warning">
                                                    Edit
                                                </a>

                                                <form action="{{ route('admin.informations.status', $information) }}"
                                                    method="POST" class="d-inline-block">
                                                    @csrf
                                                    <button
                                                        class="btn btn-xs @if ($information->status == '1') btn-danger @else btn-success @endif"
                                                        value="{{ $information->status == '1' ? '0' : '1' }}"
                                                        type="submit" name="status"
                                                        onclick="return confirm('Konfirmasi')">
                                                        {{ $information->status == '1' ? 'Sembunyikan' : 'Tampilkan' }}
                                                    </button>
                                                </form>

                                                <form action="{{ route('admin.informations.destroy', $information) }}"
                                                    method="POST" class="d-inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-xs btn-danger"
                                                        onclick="return confirm('Delete {{ $information->name }}?')">Hapus</button>
                                                </form>


                                            </td>
                                        </tr>

                                    @endforeach

                                    @empty($info)
                                        <tr>
                                            <td colspan="6">Tidak ada data laporan</td>
                                        </tr>
                                    @endempty

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('js/table/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/table/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/table/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('js/table/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/table/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('js/table/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/table/jszip.min.js') }}"></script>
    <script src="{{ asset('js/table/pdfmake.min.js') }}"></script>
    <script src="{{ asset('js/table/vfs_fonts.js') }}"></script>
    <script src="{{ asset('js/table/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('js/table/buttons.print.min.js') }}"></script>
    <script src="{{ asset('js/table/buttons.colVis.min.js') }}"></script>
    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": false,
                "lengthChange": true,
                "autoWidth": false,
                "buttons": ['copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5', "colvis"
                ]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection
