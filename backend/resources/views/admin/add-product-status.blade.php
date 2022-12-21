@extends('admin.applayout.applayout')


@section('content')

<div class="product-status-wrap">
{{$msg}}
</div>
<div class="action-btn-wrap">
<div class="items-box">
    <a href="{{asset('admin/dashboard/'.$access_token)}}" class="items-box-link">Dashboard</a>
  </div>

  <div class="items-box">
    <a href="{{asset('express/'.$biz_id)}}" class="items-box-link">Visit Shop</a>
  </div>
</div>
@endsection