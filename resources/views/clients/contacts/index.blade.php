@extends('layouts.client')

@section('title', 'Liên hệ với chúng tôi')

@section('content')
<section class="contact-header py-5 position-relative d-flex align-items-center" 
    style="background: url('{{ asset('storage/banners/travel3.jpg') }}') no-repeat center center; background-size: cover; min-height: 400px;">
    
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: rgba(0, 0, 0, 0.5); z-index: 1;"></div>

    <div class="container position-relative text-center py-5" data-aos="fade-up" style="z-index: 2;">
        <h6 class="text-gold fw-bold text-uppercase spacing-5 mb-3 animate__animated animate__fadeInDown" style="color: #f6d365;">Liên hệ</h6>
        <h1 class="display-3 fw-bold font-serif text-white mb-4 shadow-text">Chúng tôi luôn lắng nghe bạn</h1>
        <p class="text-light opacity-75 mx-auto fs-5" style="max-width: 700px; line-height: 1.6;">
            Hãy để lại lời nhắn hoặc liên hệ trực tiếp với đội ngũ hỗ trợ của CMC Travel để bắt đầu hành trình nghỉ dưỡng của bạn.
        </p>
        <div class="mt-5 animate__animated animate__bounce animate__infinite">
            <a href="#contact-content" class="text-white opacity-50"><i class="fas fa-chevron-down fa-2x"></i></a>
        </div>
    </div>
</section>

<section class="contact-content py-5" id="contact-content">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-5" data-aos="fade-right">
                <div class="contact-info-card p-4 p-md-5 rounded-4 shadow-sm border-0 bg-white">
                    <h3 class="fw-bold mb-4">Thông tin liên hệ</h3>
                    <div class="d-flex align-items-start mb-4">
                        <div class="icon-box me-3"><i class="fas fa-map-marker-alt"></i></div>
                        <div>
                            <h6 class="fw-bold mb-1">Địa chỉ trụ sở</h6>
                            <p class="text-muted small mb-0">Tòa nhà Sun City, 13 Hai Bà Trưng, Hoàn Kiếm, Hà Nội</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-start mb-4">
                        <div class="icon-box me-3"><i class="fas fa-phone-alt"></i></div>
                        <div>
                            <h6 class="fw-bold mb-1">Hotline hỗ trợ</h6>
                            <p class="text-muted small mb-0">1800 6645 (Miễn phí 24/7)</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-start mb-4">
                        <div class="icon-box me-3"><i class="fas fa-envelope"></i></div>
                        <div>
                            <h6 class="fw-bold mb-1">Email phản hồi</h6>
                            <p class="text-muted small mb-0">contact@cmctravel.vn</p>
                        </div>
                    </div>
                    <hr class="my-4 opacity-10">
                    <h6 class="fw-bold mb-3">Kết nối với CMC Travel</h6>
                    <div class="social-pills d-flex gap-2">
                        <a href="#" class="btn-social"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="btn-social"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="btn-social"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>

            <div class="col-lg-7" data-aos="fade-left">
                <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5">
                    <h3 class="fw-bold mb-4">Gửi tin nhắn cho chúng tôi</h3>
                    
                    @if(session('success'))
                        <div class="alert alert-success border-0 rounded-4 mb-4">{{ session('success') }}</div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger border-0 rounded-4 mb-4">{{ session('error') }}</div>
                    @endif

                    <form action="{{ route('clients.contacts.store') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Họ và tên" value="{{ old('name') }}" required>
                                @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{ old('email') }}" required>
                                @error('email') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12">
                                <input type="text" name="subject" class="form-control @error('subject') is-invalid @enderror" placeholder="Tiêu đề" value="{{ old('subject') }}">
                                @error('subject') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12">
                                <textarea name="message" class="form-control @error('message') is-invalid @enderror" rows="5" placeholder="Nội dung" required>{{ old('message') }}</textarea>
                                @error('message') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary px-5">Gửi tin nhắn</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row mt-5 pt-4" data-aos="zoom-in">
            <div class="col-12">
                <div class="map-container shadow-sm rounded-4 overflow-hidden mb-4">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m12!1m3!1d3724.085341258673!2d105.8504445!3d21.0292723!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ab9532889601%3A0x6968a355601552a4!2zMTMgSGFpIELDoCBUcsawbmcsIFRyw6BuIEjGsG5nIMSQ4bqhbywgSG_DoG4gS2nDm0sIEjDoCBO4buZaSwgVmnhu4d0IE5hbQ!5e0!3m2!1svi!2s!4v1711234567890!5m2!1svi!2s"
                        width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

<style>
.contact-header {
    background-size: cover !important;
    background-position: center center !important;
    background-repeat: no-repeat !important;
    min-height: 500px;
    display: flex;
    align-items: center;
    position: relative;
    border-bottom-left-radius: 50px;
    border-bottom-right-radius: 50px;
}

.contact-header::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(to bottom, rgba(0,0,0,0.4), rgba(0,0,0,0.7));
    z-index: 1;
}

.contact-header .container {
    position: relative;
    z-index: 2;
}

.icon-box {
    width: 40px;
    height: 40px;
    background: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    color: #0d6efd;
}

.btn-social {
    width: 35px;
    height: 35px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: #f8f9fa;
    color: #333;
    transition: 0.3s;
    text-decoration: none;
}

.btn-social:hover {
    background: #0d6efd;
    color: #fff;
}
</style>