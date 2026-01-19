@extends('admin.layout')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">🏀 Quản lý môn thể thao</h5>
            <a href="{{ route('admin.sports.create') }}"
               class="btn btn-success btn-sm">
                ➕ Thêm sport
            </a>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr class="text-center">
                            <th width="60">ID</th>
                            <th width="90">Ảnh</th>
                            <th>Tên sport</th>
                            <th width="120">Thứ tự</th>
                            <th width="180">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sports as $sport)
                            <tr>
                                <td class="text-center">{{ $sport->id }}</td>

                                <td class="text-center">
                                    @if($sport->image)
                                        <img src="{{ asset('storage/'.$sport->image) }}"
                                             style="width:60px;height:60px;object-fit:cover"
                                             class="rounded">
                                    @else
                                        —
                                    @endif
                                </td>

                                <td>{{ $sport->name }}</td>

                                <td class="text-center">
                                    <span class="badge bg-primary">
                                        {{ $sport->sort_order }}
                                    </span>
                                </td>

                                <td class="text-center">
                                    <a href="{{ route('admin.sports.edit',$sport) }}"
                                       class="btn btn-warning btn-sm">
                                        ✏ Sửa
                                    </a>

                                    <form action="{{ route('admin.sports.destroy',$sport) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Xóa sport này?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm">
                                            🗑 Xóa
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">
                                    Chưa có môn thể thao nào
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $sports->links() }}
        </div>
    </div>
</div>
@endsection
