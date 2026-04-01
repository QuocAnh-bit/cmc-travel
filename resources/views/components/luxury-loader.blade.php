<div id="global-loader" class="luxury-loader">
    <div class="loader-content">
        <h1 class="brand-name">CMC TRAVEL</h1>
        <div class="loading-line-container">
            <div class="loading-line"></div>
        </div>
        <p class="tagline">EXPERIENCE THE EXTRAORDINARY</p>
    </div>
</div>

<style>
    .luxury-loader {
        position: fixed;
        inset: 0;
        background: #ffffff;
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        transition: opacity 0.8s ease, visibility 0.8s;
    }

    .brand-name {
        font-family: 'Playfair Display', serif;
        font-size: 2.5rem;
        letter-spacing: 10px;
        color: #1a1a1a;
        margin-bottom: 15px;
        animation: fadeInUp 1s ease;
    }

    .loading-line-container {
        width: 150px;
        height: 1px;
        background: #eeeeee;
        margin: 0 auto;
        position: relative;
        overflow: hidden;
    }

    .loading-line {
        width: 100%;
        height: 100%;
        background: #c5a059; /* Màu vàng Gold */
        position: absolute;
        left: -100%;
        animation: luxury-slide 2s infinite ease-in-out;
    }

    .tagline {
        font-family: 'Montserrat', sans-serif;
        font-size: 0.6rem;
        letter-spacing: 5px;
        color: #999;
        margin-top: 20px;
        text-transform: uppercase;
    }

    @keyframes luxury-slide {
        0% { left: -100%; }
        50% { left: 0; }
        100% { left: 100%; }
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Lớp ẩn loader */
    .loader-hidden {
        opacity: 0;
        visibility: hidden;
    }
</style>