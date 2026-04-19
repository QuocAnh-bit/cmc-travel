@extends('layouts.client')

@section('content')
    <style>
        /* CMC TRAVEL - LUXURY SYSTEM CORE */
        :root {
            --dark-chic: #1a1a1a;
            --border-light: #f1f1f1;
            --text-gray: #888;
        }

        .booking-history-container {
            font-family: 'Inter', sans-serif;
            background-color: #fcfcfc;
            margin-top: 80px;
        }

        /* 1. Stats Overview */
        .stat-card {
            border: 1px solid var(--border-light) !important;
            transition: all 0.3s ease;
            background: #fff;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05) !important;
        }

        .stat-label {
            text-transform: uppercase;
            font-size: 0.7rem;
            letter-spacing: 1px;
            font-weight: 700;
            color: var(--text-gray);
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 800;
            letter-spacing: -1.5px;
            color: var(--dark-chic);
        }

        /* 2. Booking Item Card */
        .booking-item-luxury {
            background: #fff;
            border-radius: 24px;
            border: 1px solid var(--border-light);
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            margin-bottom: 25px;
            overflow: hidden;
        }

        .booking-item-luxury:hover {
            transform: scale(1.005);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.06);
        }

        .booking-img-wrapper {
            position: relative;
            overflow: hidden;
            border-radius: 20px;
            margin: 15px;
        }

        .booking-img-wrapper img {
            transition: transform 0.6s ease;
            height: 240px;
            object-fit: cover;
        }

        .booking-item-luxury:hover img {
            transform: scale(1.08);
        }

        /* 3. Badges */
        .badge-luxury {
            padding: 7px 15px;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 700;
            border-radius: 50px;
        }

        .status-confirmed {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .status-cancelled {
            background: #ffebee;
            color: #c62828;
        }

        .status-pending {
            background: #fff8e1;
            color: #f9a825;
        }

        /* 4. Info Blocks */
        .info-block {
            border: 1px solid #eee;
            border-radius: 16px;
            padding: 15px;
            transition: all 0.3s ease;
        }

        .info-label {
            font-size: 10px;
            text-transform: uppercase;
            font-weight: 700;
            color: #aaa;
            margin-bottom: 4px;
        }

        .info-value {
            font-weight: 600;
            color: var(--dark-chic);
        }

        /* 5. NÚT BẤM LUXURY (SỬA LẠI THEO Ý THỊNH) */
        .btn-luxury-action {
            text-decoration: none !important;
            color: var(--dark-chic) !important;
            background: transparent;
            border: 1.5px solid #eee !important;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 12px 25px !important;
            border-radius: 12px;
            transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
            display: inline-block;
        }

        .btn-luxury-action:hover {
            color: #fff !important;
            background: var(--dark-chic) !important;
            border-color: var(--dark-chic) !important;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
        }

        .btn-cancel-text {
            color: #dc3545;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            text-decoration: none !important;
            transition: all 0.3s;
        }

        .btn-cancel-text:hover {
            color: #a71d2a;
            opacity: 0.8;
        }

        .price-tag {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--dark-chic);
            letter-spacing: -1px;
        }
    </style>

    <div class="booking-history-container py-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-end mb-5">
                <div>
                    <h1 class="fw-bold mb-1 text-dark">Lịch sử giao dịch</h1>
                    <p class="text-muted mb-0">Quản lý những hành trình thượng lưu của bạn tại CMC Travel.</p>
                </div>
                <a href="{{ route('hotels.index') }}" class="btn btn-dark rounded-pill px-4 py-2 fw-bold shadow-sm">
                    ĐẶT PHÒNG MỚI
                </a>
            </div>

            <div class="row g-4 mb-5">
                @php
                    $statItems = [
                        ['label' => 'Tổng đơn hàng', 'value' => $summary['total'], 'color' => 'text-dark'],
                        ['label' => 'Chờ xác nhận', 'value' => $summary['pending'], 'color' => 'text-warning'],
                        ['label' => 'Đã hoàn tất', 'value' => $summary['confirmed'], 'color' => 'text-success'],
                        ['label' => 'Đã hủy bỏ', 'value' => $summary['cancelled'], 'color' => 'text-danger']
                    ];
                @endphp
                @foreach($statItems as $stat)
                    <div class="col-md-3">
                        <div class="card stat-card border-0 rounded-4 p-3 shadow-sm">
                            <div class="card-body">
                                <div class="stat-label">{{ $stat['label'] }}</div>
                                <div class="stat-value {{ $stat['color'] }}">{{ number_format($stat['value']) }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="booking-list">
                @forelse($bookings as $booking)
                        @php
                            $room = $booking->room;
                            $hotel = $room?->hotel;
                            $image = $room?->image;
                            $imageUrl = $image
                                ? (Str::startsWith($image, 'http') ? $image : asset('storage/' . $image))
                                : 'https://placehold.co/600x400?text=Luxury+Room';
                        @endphp

                        <div class="booking-item-luxury shadow-sm">
                            <div class="row g-0 align-items-center">
                                <div class="col-lg-3 col-md-4">
                                    <div class="booking-img-wrapper">
                                        <img src="{{ $imageUrl }}" class="w-100" alt="Room Image">
                                    </div>
                                </div>

                                <div class="col-lg-9 col-md-8">
                                    <div class="p-4 pe-5">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <div>
                                                <span
                                                    class="text-uppercase small fw-bold text-muted letter-spacing-1">{{ $hotel?->name ?? 'Premium Hotel' }}</span>
                                                <h3 class="fw-bold mt-1 mb-2 text-dark">{{ $room?->name ?? 'Executive Suite' }}</h3>
                                                <p class="text-muted small mb-0">
                                                    <i
                                                        class="fas fa-map-marker-alt me-2 text-danger"></i>{{ $hotel?->address ?? 'Hà Nội, Việt Nam' }}
                                                </p>
                                            </div>
                                            <div class="text-end">
                                                <span class="badge-luxury {{ 
                                                                                                                    $booking->status === 'confirmed' ? 'status-confirmed' :
                    ($booking->status === 'cancelled' || $booking->status === 'expired' ? 'status-cancelled' : 'status-pending') 
                                                                                                                }}">
                                                    {{ $booking->status == 'expired' ? 'Đã hết hạn' : ($booking->status == 'confirmed' ? 'Đã thanh toán' : 'Đã hủy') }}
                                                </span>
                                                <div class="price-tag mt-3">{{ number_format($booking->total_price) }}đ</div>
                                            </div>
                                        </div>

                                        <div class="row g-3 mb-4">
                                            <div class="col-md-4">
                                                <div class="info-block">
                                                    <div class="info-label">Check-in</div>
                                                    <div class="info-value">{{ $booking->check_in->format('d M, Y') }}</div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="info-block">
                                                    <div class="info-label">Check-out</div>
                                                    <div class="info-value">{{ $booking->check_out->format('d M, Y') }}</div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="info-block">
                                                    <div class="info-label">Thời gian lưu trú</div>
                                                    <div class="info-value">
                                                        {{ $booking->check_in->diffInDays($booking->check_out) }} Đêm
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-end align-items-center gap-4">
                                            @if($booking->status == "pending")
                                                <form action="{{ route('bookings.cancel', $booking) }}" method="POST" class="m-0">
                                                    @csrf
                                                    <button type="submit" class="btn-cancel-text border-0 bg-transparent p-0"
                                                        onclick="return confirm('Hủy đặt phòng này?')">
                                                        HỦY PHÒNG
                                                    </button>
                                                </form>
                                            @endif

                                            <a href="{{ route('bookings.show', $booking) }}" class="btn-luxury-action">
                                                CHI TIẾT ĐƠN
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                @empty
                    <div class="text-center py-5 card rounded-4 border-0 shadow-sm">
                        <i class="fas fa-box-open fa-3x text-muted mb-3 opacity-20"></i>
                        <h4 class="fw-bold text-muted">Lịch sử đang trống</h4>
                        <p class="text-muted">Hãy bắt đầu hành trình đầu tiên của bạn.</p>
                    </div>
                @endforelse
            </div>

            @if($bookings->hasPages())
                <div class="mt-5 d-flex justify-content-center">
                    {{ $bookings->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection