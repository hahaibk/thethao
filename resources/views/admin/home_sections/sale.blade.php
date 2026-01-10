@extends('admin.layout')

@section('page-title','Quản lý Giảm giá')

@section('content')

<style>
.home-section-box {
    background: #fff;
    border-radius: 10px;
    padding: 25px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}
.home-section-box h2 {
    font-size: 24px;
    margin-bottom: 20px;
    color: #2c3e50;
}
.btn-add {
    display: inline-block;
    margin-bottom: 15px;
    padding: 8px 15px;
    border-radius: 6px;
    background: #e67e22;
    color: #fff;
    text-decoration: none;
    transition: background 0.3s;
}
.btn-add:hover { background: #d35400; }
.section-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 15px;
    margin-bottom: 10px;
    background: #f8f9fa;
    border-radius: 6px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.05);
}
.section-item strong { font-size: 16px; color: #2c3e50; }
.section-item a { margin-left: 10px; color: #2980b9; text-decoration: none; }
.section-item a:hover { text-decoration: underline; }
.section-item form button {
    background: #e74c3c;
    color: #fff;
    padding: 6px 12px;
    border-radius: 5px;
    border: none;
    cursor: pointer;
    transition: background 0.3s;
}
.section-item form button:hover { background: #c0392b; }
</style>

<div class="home-section-box">
    <h2>Giảm giá</h2>
    <a href="{{ route('admin.home_sections.create', ['type'=>'sale']) }}" class="btn-add">Thêm tin giảm giá</a>

    @if(count($sales))
        @foreach($sales as $sale)
            <div class="section-item">
                <strong>{{ $sale->title }}</strong>
                <div>
                    <a href="{{ route('admin.home_sections.edit', $sale) }}">Sửa</a>
                    <form method="POST" action="{{ route('admin.home_sections.destroy', $sale) }}" style="display:inline">
                        @csrf @method('DELETE')
                        <button>Xóa</button>
                    </form>
                </div>
            </div>
        @endforeach
    @else
        <p>Hiện chưa có tin giảm giá nào.</p>
    @endif
</div>

@endsection
