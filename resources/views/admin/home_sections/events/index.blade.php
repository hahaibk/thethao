@extends('admin.layout')

@section('title', 'Quản lý Event')

@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Danh sách Event</h5>

        <a href="{{ route('admin.homesection.events.create') }}"
           class="btn btn-primary btn-sm">
            ➕ Thêm Event
        </a>
    </div>

    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th width="60">#</th>
                    <th width="100">Ảnh</th>
                    <th>Tiêu đề</th>
                    <th>Tiêu đề phụ</th>
                    <th width="140">Hành động</th>
                </tr>
            </thead>
            <tbody>
            @forelse($events as $event)
                <tr>
                    <td>{{ $event->id }}</td>
                    <td>
                        @if($event->thumbnail)
                            <img src="{{ asset('storage/'.$event->thumbnail) }}"
                                 class="img-thumbnail"
                                 width="80">
                        @else
                            <span class="text-muted">Không có</span>
                        @endif
                    </td>
                    <td>{{ $event->title }}</td>
                    <td>{{ $event->subtitle }}</td>
                    <td>
                        <a href="{{ route('admin.homesection.events.edit', $event) }}"
                           class="btn btn-warning btn-sm">
                            ✏️
                        </a>

                        <form action="{{ route('admin.homesection.events.destroy', $event) }}"
                              method="POST"
                              class="d-inline"
                              onsubmit="return confirm('Xóa event này?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">
                                🗑
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">
                        Chưa có event nào
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>

        <div class="mt-3">
            {{ $events->links() }}
        </div>
    </div>
</div>
@endsection
