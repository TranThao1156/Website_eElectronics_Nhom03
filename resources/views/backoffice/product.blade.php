@extends('layouts.layout_backoffice')

@section('content')
<div class="row">
	<div class="col-lg-12">
		<h2 class="page-header">Danh sách sản phẩm</h2>
		<p>
			<a href="{{ route('add_product') }}" class="btn btn-primary">Thêm sản phẩm</a>
		</p>

		<style>
			.prod-thumb { width:64px; height:64px; object-fit:cover; border-radius:4px; }
		</style>
		<div class="table-responsive">
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<th>Ảnh</th>
						<th>#</th>
						<th>Tên</th>
						<th>Giá</th>
						<th>Mô tả</th>
					</tr>
				</thead>
				<tbody>
					@forelse ($products as $p)
						<tr>
							<td>
								@php
									$img = null;
									if (!empty($p->HinhAnh)) {
										$candidates = [];
										$decoded = @json_decode($p->HinhAnh, true);
										if (is_array($decoded) && count($decoded)) {
											$candidates = $decoded;
										} else {
											if (strpos($p->HinhAnh, ',') !== false) {
												$candidates = array_map('trim', explode(',', $p->HinhAnh));
											} else {
												$candidates = [ $p->HinhAnh ];
											}
										}

										// pick first candidate that exists in public path
										foreach ($candidates as $c) {
											$path = public_path($c);
											if ($c && file_exists($path)) {
												$img = $c;
												break;
											}
										}
									}
								@endphp
								@if ($img)
									<img src="{{ asset($img) }}" alt="thumb" class="prod-thumb">
								@else
									<div style="width:64px;height:64px;background:#f7f7f7;border:1px solid #e1e1e1;border-radius:4px;display:inline-flex;align-items:center;justify-content:center;color:#999;font-size:12px">No image</div>
								@endif
							</td>
							<td>{{ ($products->currentPage()-1) * $products->perPage() + $loop->iteration }}</td>
							<td>{{ $p->Ten }}</td>
							<td>{{ $p->Gia ?? ($p->GiaSauGiam ?? '') }}</td>
							<td style="max-width:400px">{{ \Illuminate\Support\Str::limit($p->MoTa ?? '', 200) }}</td>
						</tr>
					@empty
						<tr>
							<td colspan="4">Không có sản phẩm</td>
						</tr>
					@endforelse
				</tbody>
			</table>
		</div>
		<div class="text-center">
			{{ $products->links() }}
		</div>
	</div>
</div>

@endsection
