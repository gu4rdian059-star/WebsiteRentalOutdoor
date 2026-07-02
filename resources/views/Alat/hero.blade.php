<style>
/* ========== ULTRA-PREMIUM CATALOG HERO ========== */
.catalog-hero-wrapper {
    position: relative;
    margin-bottom: 60px;
    padding: 20px 0;
}

.catalog-hero {
    position: relative;
    background: #0f172a;
    border-radius: 48px;
    padding: 100px 80px;
    overflow: hidden;
    color: #fff;
    box-shadow: 0 40px 100px rgba(0, 0, 0, 0.3);
    border: 1px solid rgba(255, 255, 255, 0.05);
}

/* Deeper, more immersive mesh gradient background */
.catalog-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background: 
        radial-gradient(circle at 20% 30%, rgba(16, 185, 129, 0.15) 0%, transparent 40%),
        radial-gradient(circle at 80% 70%, rgba(99, 102, 241, 0.1) 0%, transparent 40%),
        radial-gradient(circle at 50% 50%, rgba(15, 23, 42, 1) 0%, #020617 100%);
    z-index: 0;
}

/* Floating Decorative Blobs */
.hero-blob {
    position: absolute;
    border-radius: 50%;
    filter: blur(80px);
    z-index: 1;
    opacity: 0.4;
    animation: floatingBlob 20s infinite alternate;
}

.blob-1 {
    width: 400px;
    height: 400px;
    background: #10b981;
    top: -100px;
    right: -50px;
}

.blob-2 {
    width: 300px;
    height: 300px;
    background: #6366f1;
    bottom: -50px;
    left: -50px;
    animation-delay: -5s;
}

@keyframes floatingBlob {
    0% { transform: translate(0, 0) scale(1); }
    100% { transform: translate(50px, 30px) scale(1.1); }
}

/* Pattern Overlay */
.hero-pattern {
    position: absolute;
    inset: 0;
    background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.02'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    z-index: 1;
    opacity: 0.5;
}

.catalog-hero-content {
    position: relative;
    z-index: 5;
    max-width: 800px;
    animation: fadeInHero 1s ease-out forwards;
}

@keyframes fadeInHero {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}

.catalog-title {
    font-size: 4.2rem;
    font-weight: 900;
    margin-bottom: 24px;
    letter-spacing: -3px;
    line-height: 1;
    color: #fff;
    display: block;
}

.gradient-text {
    background: linear-gradient(to right, #ffffff, #10b981, #34d399);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    display: inline-block;
}

.title-accent {
    position: relative;
    color: #10b981;
}

.title-underline {
    position: absolute;
    bottom: 8px;
    left: 0;
    width: 100%;
    height: 8px;
    background: rgba(16, 185, 129, 0.3);
    border-radius: 4px;
    z-index: -1;
}

.catalog-subtitle {
    font-size: 1.25rem;
    color: #94a3b8;
    margin-bottom: 50px;
    max-width: 600px;
    line-height: 1.7;
    font-weight: 500;
}

/* Premium Filter Buttons */
.filter-wrapper {
    margin-bottom: 50px;
}

.filter-label {
    display: block;
    font-weight: 800;
    font-size: 0.75rem;
    color: #475569;
    margin-bottom: 16px;
    text-transform: uppercase;
    letter-spacing: 2px;
}

.filter-container {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
}

.filter-btn {
    padding: 12px 24px;
    border-radius: 14px;
    background: rgba(255, 255, 255, 0.03);
    color: #e2e8f0;
    text-decoration: none;
    font-weight: 700;
    font-size: 0.85rem;
    border: 1px solid rgba(255, 255, 255, 0.08);
    transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    backdrop-filter: blur(8px);
    display: flex;
    align-items: center;
    gap: 8px;
}

.filter-btn:hover {
    background: rgba(255, 255, 255, 0.1);
    color: #fff;
    transform: translateY(-5px);
    border-color: rgba(255, 255, 255, 0.2);
    box-shadow: 0 10px 20px rgba(0,0,0,0.2);
}

.filter-btn.active {
    background: linear-gradient(135deg, #10b981, #059669);
    border-color: transparent;
    color: #fff;
    box-shadow: 0 15px 30px rgba(16, 185, 129, 0.3);
}

/* Modern Search Box (Glassmorphism Deep) */
.catalog-search-box {
    position: relative;
    max-width: 600px;
}

.catalog-search-input {
    width: 100%;
    background: rgba(255, 255, 255, 0.07);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.12);
    border-radius: 20px;
    padding: 24px 32px 24px 68px;
    font-weight: 600;
    color: #fff;
    transition: all 0.4s;
    font-size: 1.1rem;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
}

.catalog-search-input::placeholder {
    color: #64748b;
}

.catalog-search-input:focus {
    background: rgba(255, 255, 255, 0.1);
    border-color: #10b981;
    transform: scale(1.02);
    box-shadow: 0 25px 60px rgba(16, 185, 129, 0.15);
    outline: none;
}

.catalog-search-icon {
    position: absolute;
    left: 28px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 1.4rem;
    color: #10b981;
    transition: all 0.3s;
}

.catalog-search-input:focus ~ .catalog-search-icon {
    transform: translateY(-50%) scale(1.2);
    filter: drop-shadow(0 0 8px rgba(16, 185, 129, 0.5));
}

@media (max-width: 992px) {
    .catalog-hero { padding: 80px 40px; }
    .catalog-title { font-size: 3rem; }
}

@media (max-width: 768px) {
    .catalog-hero { padding: 60px 30px; border-radius: 36px; }
    .catalog-title { font-size: 2.5rem; letter-spacing: -1.5px; }
    .catalog-subtitle { font-size: 1rem; margin-bottom: 30px; }
}
</style>

<div class="catalog-hero-wrapper">
    <div class="catalog-hero">
        {{-- DECORATIVE ELEMENTS --}}
        <div class="hero-blob blob-1"></div>
        <div class="hero-blob blob-2"></div>
        <div class="hero-pattern"></div>

        <div class="catalog-hero-content">
            <h1 class="catalog-title">
                <span class="gradient-text">Explore The</span> 
                <span class="title-accent">Outdoors
                    <span class="title-underline"></span>
                </span>
            </h1>
            <p class="catalog-subtitle">
                Temukan peralatan camping dan adventure kualitas premium untuk pengalaman petualangan yang tak terlupakan.
            </p>

            <div class="filter-wrapper">
                <span class="filter-label">Kategori Peralatan</span>
                <div class="filter-container">
                    <a href="{{ route('alat.index') }}" class="filter-btn {{ !request('kategori') ? 'active' : '' }}">
                        <i class="bi bi-grid-fill"></i> Semua
                    </a>
                    
                    @php 
                        $categories = \App\Models\Alat::distinct()->pluck('kategori');
                        $catIcons = [
                            'Gas' => 'bi-fire',
                            'Camping' => 'bi-tent',
                            'Cooking' => 'bi-cup-hot',
                            'Lighting' => 'bi-lightbulb',
                            'Footwear' => 'bi-boot',
                            'Backpack' => 'bi-backpack',
                            'Hiking' => 'bi-mountain'
                        ];
                    @endphp
                    
                    @foreach($categories as $cat)
                        <a href="{{ route('alat.index', ['kategori' => $cat]) }}" 
                           class="filter-btn {{ request('kategori') == $cat ? 'active' : '' }}">
                            <i class="bi {{ $catIcons[$cat] ?? 'bi-tag' }}"></i> {{ $cat }}
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="catalog-search-box">
                <i class="bi bi-search catalog-search-icon"></i>
                <form action="{{ route('alat.index') }}" method="GET">
                    @if(request('kategori'))
                        <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                    @endif
                    <input type="text" name="q" class="catalog-search-input" 
                           placeholder="Cari perlengkapan impianmu..." value="{{ request('q') }}">
                </form>
            </div>
        </div>
    </div>
</div>
