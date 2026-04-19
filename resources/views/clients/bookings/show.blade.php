@extends('layouts.client')

@section('title', 'Chi tiết hành trình | CMC Travel')

@section('content')
    @php
        $room = $booking->room;
        $hotel = $room?->hotel;
        $image = $room?->image;
        $imageUrl = $image
            ? (\Illuminate\Support\Str::startsWith($image, ['http://', 'https://']) ? $image : asset('storage/' . $image))
            : 'https://placehold.co/900x560?text=CMC+Travel';
    @endphp

    <style>
        :root {
            --dark-chic: #1a1a1a;
            --luxury-gold: #b89552;
            /* Màu vàng đồng tinh tế nếu cần */
            --soft-border: #f1f1f1;
        }

        .paid-badge {
            width: 90px;
            height: 90px;
            border: 3px solid red;
            color: red;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 16px;
            transform: rotate(-15deg);
            animation: pop 0.4s ease;
        }

        @keyframes pop {
            0% {
                transform: scale(0) rotate(-15deg);
                opacity: 0;
            }

            100% {
                transform: scale(1) rotate(-15deg);
                opacity: 1;
            }
        }

        .luxury-detail-container {
            font-family: 'Inter', sans-serif;
            background-color: #fcfcfc;
            margin-top: 100px;
        }

        /* Header & Back Button */
        .btn-back-luxury {
            text-decoration: none !important;
            color: var(--dark-chic) !important;
            font-weight: 700;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            border: 1px solid #ddd;
            padding: 12px 25px;
            border-radius: 50px;
            transition: all 0.3s;
        }

        .btn-back-luxury:hover {
            background: var(--dark-chic);
            color: #fff !important;
            border-color: var(--dark-chic);
        }

        /* Card System */
        .card-luxury {
            background: #fff;
            border-radius: 30px;
            border: 1px solid var(--soft-border);
            box-shadow: 0 15px 45px rgba(0, 0, 0, 0.03);
            overflow: hidden;
        }

        .main-image-luxury {
            height: 450px;
            object-fit: cover;
            width: 100%;
            transition: transform 1s ease;
        }

        .card-luxury:hover .main-image-luxury {
            transform: scale(1.03);
        }

        /* Labels & Values */
        .label-luxury {
            font-size: 10px;
            text-transform: uppercase;
            font-weight: 800;
            color: #aaa;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }

        .value-luxury {
            font-weight: 700;
            color: var(--dark-chic);
            font-size: 1.1rem;
        }

        /* Status Badges Custom */
        .status-pill {
            padding: 8px 20px;
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-radius: 50px;
        }

        .status-confirmed {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .status-pending {
            background: #fff8e1;
            color: #f9a825;
        }

        .status-cancelled {
            background: #ffebee;
            color: #c62828;
        }

        /* Summary Side */
        .summary-item {
            display: flex;
            justify-content: space-between;
            padding: 15px 0;
            border-bottom: 1px solid #f8f8f8;
        }

        .summary-item:last-child {
            border-bottom: none;
        }

        .price-big {
            font-size: 2rem;
            font-weight: 800;
            letter-spacing: -1px;
            color: var(--dark-chic);
        }

        /* Info Blocks in Detail */
        .grid-info-box {
            border: 1px solid #f0f0f0;
            border-radius: 20px;
            padding: 20px;
            transition: all 0.3s;
        }

        .grid-info-box:hover {
            border-color: #333;
        }

        .btn-cancel-luxury {
            background: transparent;
            color: #dc3545;
            border: 1px solid #fee2e2;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 1px;
            padding: 15px;
            border-radius: 15px;
            width: 100%;
            transition: all 0.3s;
        }

        .btn-cancel-luxury:hover {
            background: #fee2e2;
            color: #b91c1c;
        }
    </style>

    <div class="luxury-detail-container pb-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-5">
                <div>
                    <nav style="--bs-breadcrumb-divider: '·';" aria-label="breadcrumb">
                        <ol class="breadcrumb mb-1">
                            <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-muted small">CMC
                                    Travel</a></li>

                        </ol>
                    </nav>

                    <h2 class="fw-bold mb-1">Chi tiết đơn đặt phòng</h2>
                    <p class="text-muted mb-0">Khách hàng chỉ được xem đơn đặt phòng của chính mình.</p>
                </div>
                <a href="{{ route('bookings.index') }}" class="btn-back-luxury">
                    <i class="fas fa-arrow-left me-2"></i> Trở lại danh sách
                </a>
            </div>

            @if(session('success') || session('error'))
                <div class="mb-4">
                    @if(session('success'))
                        <div class="alert alert-success border-0 rounded-4 shadow-sm p-3">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger border-0 rounded-4 shadow-sm p-3">{{ session('error') }}</div>
                    @endif
                </div>
            @endif

            <div class="row g-5">
                <div class="col-lg-8">
                    <div class="card-luxury mb-4">
                        @if($booking->status == 'pending')
                            <div class="alert alert-warning d-flex align-items-center gap-2 shadow-sm p-3 rounded-3">
                                ⏳ <strong>Thời gian giữ chỗ:</strong>
                                <span id="countdown" class="badge bg-danger fs-6 px-3 py-2"></span>
                            </div>
                        @endif
                        <div class="position-relative overflow-hidden">
                            <img src="{{ $imageUrl }}" alt="{{ $room?->name }}" class="main-image-luxury">
                            <div class="position-absolute top-0 end-0 m-4">
                                <span
                                    class="status-pill {{ 
                                                                                                                                                                                    $booking->status === 'confirmed' ? 'status-confirmed' :
        ($booking->status === 'cancelled' ? 'status-cancelled' : 'status-pending') 
                                                                                                                                                                                }} shadow-sm">
                                    {{ $booking->status == 'confirmed' ? 'Đã xác nhận' : ($booking->status == 'cancelled' ? 'Đã hủy' : 'Chờ xử lý') }}
                                </span>
                            </div>
                        </div>

                        <div class="card-body p-5">
                            <div class="mb-5">
                                <h5 class="label-luxury" style="color: var(--luxury-gold)">
                                    {{ $hotel?->name ?? 'CMC Premium Resort' }}
                                </h5>
                                <h1 class="fw-bold text-dark mb-3">{{ $room?->name ?? 'Grand Executive Suite' }}</h1>
                                <p class="text-muted d-flex align-items-center">
                                    <i class="fas fa-map-marker-alt me-2 text-danger"></i>
                                    {{ $hotel?->address ?? 'Địa chỉ đang cập nhật' }}
                                </p>
                            </div>

                            <div class="row g-4">
                                <div class="col-md-4">
                                    <div class="grid-info-box">
                                        <div class="label-luxury">Ngày Nhận Phòng</div>
                                        <div class="value-luxury">{{ $booking->check_in->format('d M, Y') }}</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="grid-info-box">
                                        <div class="label-luxury">Ngày Trả Phòng</div>
                                        <div class="value-luxury">{{ $booking->check_out->format('d M, Y') }}</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="grid-info-box text-center bg-light border-0">
                                        <div class="label-luxury">Tổng Thời Gian</div>
                                        <div class="value-luxury">{{ $booking->check_in->diffInDays($booking->check_out) }}
                                            Đêm</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card-luxury p-4 mb-4">
                        <h5 class="label-luxury mb-4 text-center">Tóm tắt thanh toán</h5>

                        <div class="summary-item">
                            <span class="text-muted small fw-bold">Đơn giá phòng</span>
                            <span class="fw-bold">{{ number_format($room->price ?? 0) }}đ/đêm</span>
                        </div>
                        <div class="summary-item">
                            <span class="text-muted small fw-bold">Thuế & Phí dịch vụ</span>
                            <span class="fw-bold text-success">Included</span>
                        </div>
                        <div class="summary-item mb-4">
                            <span class="text-muted small fw-bold">Phương thức thanh toán</span>
                            <span class="fw-bold">Tiền mặt / Chuyển khoản</span>
                        </div>

                        <div class="py-4 text-center border-top">
                            <div class="label-luxury mb-2">Tổng số tiền đã đặt</div>
                            <div class="price-big">{{ number_format($booking->total_price) }}đ</div>
                        </div>
                        <input type="hidden" id="expires_at"
                            value="{{ $booking->expires_at ? \Carbon\Carbon::parse($booking->expires_at)->format('Y-m-d\TH:i:s') : '' }}">



                        <div class="py-4 text-center border-top d-flex justify-content-center align-items-center">
                            @if($booking->status == 'pending')
                                <form action="{{ url('/momo_payment') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="total_momo" value="{{ $booking->total_price }}">
                                    <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                                    <input type="hidden" name="booking_status" value="{{ $booking->status }}">
                                    <input type="hidden" name="expires_at" value="{{ $booking->expires_at }}">
                                    <input type="hidden" name="user_id" value="{{ $booking->user_id }}">


                                    <button id="payBtn" type="submit" class="btn btn-success check_out ">Thanh toán
                                        Momo</button>
                                </form>
                            @elseif($booking->status == 'confirmed')
                                <div class="paid-badge">PAID</div>
                            @else
                                <div class="paid-badge">Đã Hủy</div>

                            @endif
                        </div>
                    </div>

                    <div class="card-luxury p-4">
                        <h5 class="label-luxury mb-3">Thông tin hỗ trợ</h5>
                        <div class="d-flex align-items-center mb-3">
                            <div class="rounded-circle bg-light p-3 me-3">
                                <i class="fas fa-headset text-dark"></i>
                            </div>
                            <div>
                                <div class="small fw-bold">Hotline 24/7</div>
                                <div class="small text-muted">1900 600 XXX</div>
                            </div>
                        </div>

                        @if($booking->status !== 'cancelled' && $booking->check_in->isFuture())
                            <div class="mt-4 pt-4 border-top">
                                <form action="{{ route('bookings.cancel', $booking) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-cancel-luxury border-0"
                                        onclick="return confirm('Bạn chắc chắn muốn hủy hành trình này?')">
                                        Hủy yêu cầu đặt phòng
                                    </button>
                                </form>
                                <p class="text-center text-muted mt-3"
                                    style="font-size: 9px; text-transform: uppercase; font-weight: 700;">
                                    Chính sách: Hủy trước 24h để được hoàn tiền 100%
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script>
        const expiresAt = new Date(document.getElementById('expires_at').value).getTime();

        const countdown = setInterval(() => {
            const now = new Date().getTime();
            const distance = expiresAt - now;

            const payBtn = document.getElementById('payBtn');

            if (distance <= 0) {
                clearInterval(countdown);

                document.getElementById('countdown').innerHTML = "Hết hạn!";

                // ❌ disable nút thanh toán
                payBtn.disabled = true;
                payBtn.classList.add('disabled', 'btn-secondary');
                payBtn.classList.remove('btn-success');

                return;
            }

            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            document.getElementById('countdown').innerHTML = minutes + "m " + seconds + "s";
        }, 1000);
    </script>
@endsection