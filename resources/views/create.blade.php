@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">新規メモ作成</div>
    {{-- route('store')と書くと/storeと同じ意味になる --}}
    <form class="card-body" action="{{ route('store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <textarea class="form-control" name="content" placeholder="ここにメモを入力" rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">保存</button>
    </form>
</div>
@endsection
