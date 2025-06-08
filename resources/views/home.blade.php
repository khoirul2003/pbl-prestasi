<!DOCTYPE html>
<html lang="id">

    <head>
        <meta charset="utf-8" />
        <meta content="width=device-width, initial-scale=1.0" name="viewport" />
        <title>PRESen - Pencatatan Prestasi Mahasiswa</title>
        <meta name="description"
            content="PRESen adalah aplikasi pencatatan prestasi mahasiswa dan rekomendasi lomba berbasis web." />
        <meta name="keywords"
            content="PRESen, prestasi mahasiswa, rekomendasi lomba, sistem informasi, pencatatan prestasi" />

        <!-- Favicons -->
        <link href="landing_pages/assets/img/favicon.png" rel="icon" />
        <link href="landing_pages/assets/img/apple-touch-icon.png" rel="apple-touch-icon" />

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com" rel="preconnect" />
        <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin />
        <link
            href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
            rel="stylesheet" />

        <!-- Vendor CSS Files -->
        <link href="landing_pages/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
        <link href="landing_pages/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet" />
        <link href="landing_pages/assets/vendor/aos/aos.css" rel="stylesheet" />
        <link href="landing_pages/assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet" />
        <link href="landing_pages/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet" />

        <!-- Main CSS File -->
        <link href="landing_pages/assets/css/main.css" rel="stylesheet" />

        <style>
            /* Style kecil untuk tombol bahasa */
            .language-switcher {
                display: inline-flex;
                gap: 0.5rem;
                margin-right: 1rem;
            }
        </style>
    </head>

    <body class="index-page">
        <header id="header" class="header d-flex align-items-center fixed-top">
            <div class="container position-relative d-flex align-items-center justify-content-between">
                <a href="index.html" class="logo d-flex align-items-center me-auto me-xl-0">
                    <h1 class="sitename">PRESen</h1><span>.</span>
                </a>

                <nav id="navmenu" class="navmenu">
                    <ul>
                        <li><a href="/" class="active" data-i18n="home">Home</a></li>
                        <li><a href="#about" data-i18n="about">About</a></li>
                        <li><a href="#features" data-i18n="features">Features</a></li>
                        <li><a href="#how-it-works" data-i18n="how_it_works">How It Works</a></li>
                        <li><a href="#contact" data-i18n="contact">Contact</a></li>
                    </ul>
                    <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
                </nav>

                <div class="language-switcher">
                    <button id="btn-id" class="btn btn-outline-primary btn-sm">ID</button>
                    <button id="btn-en" class="btn btn-outline-primary btn-sm">EN</button>
                </div>
                <div>
                    <a class="btn btn-outline-primary btn-sm" href="{{ route('register') }}" data-i18n="sign_in">SIGN UP</a>
                    <a class="btn btn-primary btn-sm" href="{{ route('login') }}" data-i18n="sign_in">SIGN IN</a>
                </div>
            </div>
        </header>

        <main class="main">
            <!-- Hero Section -->
            <section id="hero" class="hero section">
                <div class="container" data-aos="fade-up" data-aos-delay="100">
                    <div class="row align-items-center mb-5">
                        <div class="col-lg-6 mb-4 mb-lg-0">
                            <div class="badge-wrapper mb-3">
                                <div class="d-inline-flex align-items-center rounded-pill border border-accent-light">
                                    <div class="icon-circle me-2">
                                        <i class="bi bi-bell"></i>
                                    </div>
                                    <span class="badge-text me-3" data-i18n="badge">Innovative Student Support</span>
                                </div>
                            </div>

                            <h1 class="hero-title mb-4" data-i18n="hero_title">Kelola Prestasi & Raih Peluang Lomba
                                dengan PRESen</h1>

                            <p class="hero-description mb-4" data-i18n="hero_description">
                                PRESen adalah platform web untuk mencatat prestasi mahasiswa secara digital dan
                                memberikan rekomendasi lomba sesuai kemampuan dan minatmu.
                            </p>

                            <div class="cta-wrapper">
                                <a href="{{ route('register') }}" class="btn btn-primary"
                                    data-i18n="btn_register">Daftar Sekarang</a>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="hero-image">
                                <img src="landing_pages
                    /assets/img/illustration/illustration-16.webp" alt="PRESen App"
                                    class="img-fluid" loading="lazy" />
                            </div>
                        </div>
                    </div>

                    <div class="row feature-boxes">
                        <div class="col-lg-4 mb-4 mb-lg-0" data-aos="fade-up" data-aos-delay="200">
                            <div class="feature-box">
                                <div class="feature-icon me-sm-4 mb-3 mb-sm-0">
                                    <i class="bi bi-pencil-square"></i>
                                </div>
                                <div class="feature-content">
                                    <h3 class="feature-title" data-i18n="feature1_title">Pencatatan Prestasi Digital
                                    </h3>
                                    <p data-i18n="feature1_desc">Input dan kelola data prestasi akademik maupun
                                        non-akademik dengan mudah dan terstruktur.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 mb-4 mb-lg-0" data-aos="fade-up" data-aos-delay="300">
                            <div class="feature-box">
                                <div class="feature-icon me-sm-4 mb-3 mb-sm-0">
                                    <i class="bi bi-lightbulb"></i>
                                </div>
                                <div class="feature-content">
                                    <h3 class="feature-title" data-i18n="feature2_title">Rekomendasi Lomba Otomatis
                                    </h3>
                                    <p data-i18n="feature2_desc">Dapatkan rekomendasi lomba yang sesuai dengan profil
                                        prestasi dan minatmu secara otomatis.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4" data-aos="fade-up" data-aos-delay="400">
                            <div class="feature-box">
                                <div class="feature-icon me-sm-4 mb-3 mb-sm-0">
                                    <i class="bi bi-bell"></i>
                                </div>
                                <div class="feature-content">
                                    <h3 class="feature-title" data-i18n="feature3_title">Notifikasi Lomba Terbaru</h3>
                                    <p data-i18n="feature3_desc">Terima update dan notifikasi lomba terbaru untuk
                                        meningkatkan peluangmu berprestasi.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- /Hero Section -->

            <!-- About Section -->
            <section id="about" class="about section">
                <div class="container">
                    <div class="row gy-4">
                        <div class="col-lg-6 content" data-aos="fade-up" data-aos-delay="100">
                            <p class="who-we-are" data-i18n="about_title">Tentang PRESen</p>
                            <h3 data-i18n="about_subtitle">Meningkatkan Prestasi Mahasiswa dengan Teknologi</h3>
                            <p class="fst-italic" data-i18n="about_text">
                                PRESen dirancang untuk memudahkan mahasiswa dalam mencatat dan mengelola prestasi,
                                sekaligus memberikan rekomendasi lomba yang tepat berdasarkan data prestasi dan minat.
                            </p>
                            <ul>
                                <li><i class="bi bi-check-circle"></i> <span data-i18n="about_list_1">Pencatatan
                                        prestasi akademik dan non-akademik yang mudah dan terverifikasi.</span></li>
                                <li><i class="bi bi-check-circle"></i> <span data-i18n="about_list_2">Rekomendasi
                                        lomba berbasis data yang objektif dan tepat sasaran.</span></li>
                                <li><i class="bi bi-check-circle"></i> <span data-i18n="about_list_3">Dashboard yang
                                        intuitif untuk memantau perkembangan prestasi dan lomba.</span></li>
                            </ul>
                            <a href="#" class="read-more" data-i18n="about_read_more"><span>Pelajari Lebih
                                    Lanjut</span><i class="bi bi-arrow-right"></i></a>
                        </div>

                        <div class="col-lg-6 about-images" data-aos="fade-up" data-aos-delay="200">
                            <div class="row gy-4">
                                <div class="col-lg-6">
                                    <img src="landing_pages
                        /assets/img/about/about-portrait-1.webp" class="img-fluid"
                                        alt="Tentang PRESen" />
                                </div>
                                <div class="col-lg-6">
                                    <div class="row gy-4">
                                        <div class="col-lg-12">
                                            <img src="landing_pages
                                /assets/img/about/about-8.webp" class="img-fluid"
                                                alt="Dashboard PRESen" />
                                        </div>
                                        <div class="col-lg-12">
                                            <img src="landing_pages
                                /assets/img/about/about-12.webp" class="img-fluid"
                                                alt="Fitur PRESen" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- /About Section -->

            <!-- How We Work Section -->
            <section id="how-it-works" class="how-we-work section">
                <div class="container section-title" data-aos="fade-up">
                    <h2 data-i18n="how_it_works_title">Cara Kerja PRESen</h2>
                    <p data-i18n="how_it_works_desc">Mudah dan cepat membantu mahasiswa mencapai prestasi terbaik</p>
                </div>

                <div class="container" data-aos="fade-up" data-aos-delay="100">
                    <div class="steps-5">
                        <div class="process-container">
                            <div class="process-item" data-aos="fade-up" data-aos-delay="200">
                                <div class="content">
                                    <span class="step-number">01</span>
                                    <div class="card-body">
                                        <div class="step-icon">
                                            <i class="bi bi-person-plus"></i>
                                        </div>
                                        <div class="step-content">
                                            <h3 data-i18n="step1_title">Daftar dan Lengkapi Profil</h3>
                                            <p data-i18n="step1_desc">Registrasi akun mahasiswa dan lengkapi data
                                                profil prestasi serta minatmu.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="process-item" data-aos="fade-up" data-aos-delay="300">
                                <div class="content">
                                    <span class="step-number">02</span>
                                    <div class="card-body">
                                        <div class="step-icon">
                                            <i class="bi bi-journal-text"></i>
                                        </div>
                                        <div class="step-content">
                                            <h3 data-i18n="step2_title">Input Data Prestasi</h3>
                                            <p data-i18n="step2_desc">Masukkan prestasi akademik maupun non-akademik,
                                                serta unggah bukti pendukung.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="process-item" data-aos="fade-up" data-aos-delay="400">
                                <div class="content">
                                    <span class="step-number">03</span>
                                    <div class="card-body">
                                        <div class="step-icon">
                                            <i class="bi bi-lightbulb"></i>
                                        </div>
                                        <div class="step-content">
                                            <h3 data-i18n="step3_title">Dapatkan Rekomendasi Lomba</h3>
                                            <p data-i18n="step3_desc">Sistem akan menganalisis profil dan prestasimu
                                                untuk memberikan rekomendasi lomba yang cocok.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="process-item" data-aos="fade-up" data-aos-delay="500">
                                <div class="content">
                                    <span class="step-number">04</span>
                                    <div class="card-body">
                                        <div class="step-icon">
                                            <i class="bi bi-trophy"></i>
                                        </div>
                                        <div class="step-content">
                                            <h3 data-i18n="step4_title">Daftar dan Ikuti Lomba</h3>
                                            <p data-i18n="step4_desc">Daftar lomba langsung melalui aplikasi dan pantau
                                                perkembangan status perlombaanmu.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- /How We Work Section -->

            <!-- Features Section -->
            <section id="features" class="services section">
                <div class="container section-title" data-aos="fade-up">
                    <h2 data-i18n="features_title">Fitur Utama PRESen</h2>
                    <p data-i18n="features_desc">Mendukung pengembangan prestasi mahasiswa secara digital dan
                        terintegrasi</p>
                </div>

                <div class="container" data-aos="fade-up" data-aos-delay="100">
                    <div class="row justify-content-center g-5">
                        <div class="col-md-6" data-aos="fade-right" data-aos-delay="100">
                            <div class="service-item">
                                <div class="service-icon">
                                    <i class="bi bi-person-badge"></i>
                                </div>
                                <div class="service-content">
                                    <h3 data-i18n="feature1_title_f">Manajemen Profil Mahasiswa</h3>
                                    <p data-i18n="feature1_desc_f">Kelola data akademik, keterampilan, dan minat lomba
                                        secara lengkap dan mudah.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6" data-aos="fade-left" data-aos-delay="100">
                            <div class="service-item">
                                <div class="service-icon">
                                    <i class="bi bi-journal-check"></i>
                                </div>
                                <div class="service-content">
                                    <h3 data-i18n="feature2_title_f">Pencatatan dan Verifikasi Prestasi</h3>
                                    <p data-i18n="feature2_desc_f">Input prestasi dengan bukti pendukung, dan dapatkan
                                        verifikasi dari dosen pembimbing.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6" data-aos="fade-right" data-aos-delay="200">
                            <div class="service-item">
                                <div class="service-icon">
                                    <i class="bi bi-bullseye"></i>
                                </div>
                                <div class="service-content">
                                    <h3 data-i18n="feature3_title_f">Sistem Rekomendasi Lomba</h3>
                                    <p data-i18n="feature3_desc_f">Dapatkan rekomendasi lomba berdasarkan data prestasi
                                        dan minat secara akurat dan tepat sasaran.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6" data-aos="fade-left" data-aos-delay="200">
                            <div class="service-item">
                                <div class="service-icon">
                                    <i class="bi bi-bell-fill"></i>
                                </div>
                                <div class="service-content">
                                    <h3 data-i18n="feature4_title_f">Notifikasi Lomba Terbaru</h3>
                                    <p data-i18n="feature4_desc_f">Terima pemberitahuan langsung tentang lomba dan
                                        kompetisi terbaru yang relevan denganmu.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- /Features Section -->

            <!-- Contact Section -->
            <section id="contact" class="contact section">
                <div class="container section-title" data-aos="fade-up">
                    <h2 data-i18n="contact_title">Contact</h2>
                    <p data-i18n="contact_desc">Hubungi kami untuk informasi lebih lanjut mengenai PRESen</p>
                </div>

                <div class="container" data-aos="fade-up" data-aos-delay="100">
                    <div class="row gy-4 mb-5">
                        <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                            <div class="info-card">
                                <div class="icon-box">
                                    <i class="bi bi-geo-alt"></i>
                                </div>
                                <h3 data-i18n="address_title">Alamat Kami</h3>
                                <p data-i18n="address_detail">
                                    Jurusan Teknologi Informasi, Politeknik Negeri Malang<br />Jl. Soekarno-Hatta No.9,
                                    Malang, Indonesia
                                </p>
                            </div>
                        </div>

                        <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                            <div class="info-card">
                                <div class="icon-box">
                                    <i class="bi bi-telephone"></i>
                                </div>
                                <h3 data-i18n="phone_title">Nomor Kontak</h3>
                                <p data-i18n="phone_detail">Telp: +62 341 123456<br />Email: info@polinema.ac.id</p>
                            </div>
                        </div>

                        <div class="col-lg-4" data-aos="fade-up" data-aos-delay="300">
                            <div class="info-card">
                                <div class="icon-box">
                                    <i class="bi bi-clock"></i>
                                </div>
                                <h3 data-i18n="hours_title">Jam Operasional</h3>
                                <p data-i18n="hours_detail">Senin - Jumat: 08:00 - 16:00<br />Sabtu & Minggu: Libur</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-wrapper" data-aos="fade-up" data-aos-delay="400">
                                <form action="forms/contact.php" method="post" role="form"
                                    class="php-email-form">
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                                <input type="text" name="name" class="form-control"
                                                    placeholder="Nama Anda*" required
                                                    data-i18n-placeholder="form_name" />
                                            </div>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                                <input type="email" class="form-control" name="email"
                                                    placeholder="Alamat Email*" required
                                                    data-i18n-placeholder="form_email" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-6 form-group">
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-phone"></i></span>
                                                <input type="text" class="form-control" name="phone"
                                                    placeholder="Nomor Telepon*" required
                                                    data-i18n-placeholder="form_phone" />
                                            </div>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-list"></i></span>
                                                <select name="subject" class="form-control" required
                                                    data-i18n-placeholder="form_service">
                                                    <option value="" data-i18n="form_select_service">Pilih
                                                        layanan*</option>
                                                    <option value="Info" data-i18n="form_option1">Informasi PRESen
                                                    </option>
                                                    <option value="Support" data-i18n="form_option2">Dukungan Teknis
                                                    </option>
                                                    <option value="Feedback" data-i18n="form_option3">Masukan & Saran
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mt-3">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-chat-dots"></i></span>
                                            <textarea class="form-control" name="message" rows="6" placeholder="Tulis pesan Anda*" required
                                                data-i18n-placeholder="form_message"></textarea>
                                        </div>
                                    </div>
                                    <div class="my-3">
                                        <div class="loading" data-i18n="loading">Memuat...</div>
                                        <div class="error-message"></div>
                                        <div class="sent-message" data-i18n="sent_message">Pesan Anda telah terkirim.
                                            Terima kasih!</div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" data-i18n="form_submit">Kirim Pesan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- /Contact Section -->
        </main>

        <footer id="footer" class="footer light-background">
            <div class="container footer-top">
                <div class="row gy-4">
                    <div class="col-lg-4 col-md-6 footer-about">
                        <a href="index.html" class="logo d-flex align-items-center">
                            <span class="sitename">PRESen</span>
                        </a>
                        <div class="footer-contact pt-3">
                            <p data-i18n="footer_about">Jurusan Teknologi Informasi</p>
                            <p data-i18n="footer_campus">Politeknik Negeri Malang</p>
                            <p class="mt-3">
                                <strong data-i18n="footer_phone">Phone:</strong>
                                <span>+62 341 123456</span>
                            </p>
                            <p>
                                <strong data-i18n="footer_email">Email:</strong>
                                <span>info@polinema.ac.id</span>
                            </p>
                        </div>
                        <div class="social-links d-flex mt-4">
                            <a href="#"><i class="bi bi-twitter"></i></a>
                            <a href="#"><i class="bi bi-facebook"></i></a>
                            <a href="#"><i class="bi bi-instagram"></i></a>
                            <a href="#"><i class="bi bi-linkedin"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-3 footer-links">
                        <h4 data-i18n="footer_useful_links">Useful Links</h4>
                        <ul>
                            <li><a href="#hero" data-i18n="home">Home</a></li>
                            <li><a href="#about" data-i18n="about">About</a></li>
                            <li><a href="#features" data-i18n="features">Features</a></li>
                            <li><a href="#how-it-works" data-i18n="how_it_works">How It Works</a></li>
                            <li><a href="#contact" data-i18n="contact">Contact</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-2 col-md-3 footer-links">
                        <h4 data-i18n="footer_support">Support</h4>
                        <ul>
                            <li><a href="#">FAQ</a></li>
                            <li><a href="#">Help Desk</a></li>
                            <li><a href="#">Terms of Service</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-4 col-md-6 footer-newsletter">
                        <h4 data-i18n="footer_newsletter">Newsletter</h4>
                        <p data-i18n="footer_newsletter_text">
                            Dapatkan update terbaru tentang lomba dan fitur PRESen langsung ke email kamu.
                        </p>
                        <form action="" method="post">
                            <input type="email" name="email" placeholder="Email Address" />
                            <input type="submit" value="Subscribe" data-i18n="footer_subscribe" />
                        </form>
                    </div>
                </div>
            </div>

            <div class="container copyright text-center mt-4">
                <p>
                    © <span>Copyright</span> <strong class="px-1 sitename">PRESen</strong> <span>All Rights
                        Reserved</span>
                </p>
                <div class="credits">
                    Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
                </div>
            </div>
        </footer>

        <!-- Scroll Top -->
        <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
                class="bi bi-arrow-up-short"></i></a>

        <!-- Preloader -->
        <div id="preloader"></div>

        <!-- Vendor JS Files -->
        <script src="landing_pages/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="landing_pages/assets/vendor/php-email-form/validate.js"></script>
        <script src="landing_pages/assets/vendor/aos/aos.js"></script>
        <script src="landing_pages/assets/vendor/glightbox/js/glightbox.min.js"></script>
        <script src="landing_pages/assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
        <script src="landing_pages/assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
        <script src="landing_pages/assets/vendor/swiper/swiper-bundle.min.js"></script>

        <!-- Main JS File -->
        <script src="landing_pages/assets/js/main.js"></script>

        <!-- Translation Script -->
        <script>
            const translations = {
                en: {
                    home: "Home",
                    about: "About",
                    features: "Features",
                    how_it_works: "How It Works",
                    contact: "Contact",
                    sign_in: "SIGN IN",
                    badge: "Innovative Student Support",
                    hero_title: "Manage Achievements & Seize Competition Opportunities with PRESen",
                    hero_description: "PRESen is a web platform to digitally record student achievements and provide competition recommendations based on your skills and interests.",
                    btn_register: "Register Now",
                    feature1_title: "Digital Achievement Recording",
                    feature1_desc: "Easily input and manage academic and non-academic achievements in a structured way.",
                    feature2_title: "Automatic Competition Recommendations",
                    feature2_desc: "Get competition recommendations tailored to your achievement profile and interests automatically.",
                    feature3_title: "Latest Competition Notifications",
                    feature3_desc: "Receive updates and notifications about the latest competitions to boost your achievement chances.",
                    about_title: "About PRESen",
                    about_subtitle: "Enhancing Student Achievements with Technology",
                    about_text: "PRESen is designed to help students easily record and manage achievements while providing precise competition recommendations based on achievement data and interests.",
                    about_list_1: "Easy and verified academic and non-academic achievement recording.",
                    about_list_2: "Objective and targeted competition recommendations based on data.",
                    about_list_3: "Intuitive dashboard to monitor achievement and competition progress.",
                    about_read_more: "Learn More",
                    how_it_works_title: "How PRESen Works",
                    how_it_works_desc: "Quick and easy to help students achieve their best.",
                    step1_title: "Register and Complete Profile",
                    step1_desc: "Register as a student and complete your achievement and interest profile.",
                    step2_title: "Input Achievement Data",
                    step2_desc: "Enter academic and non-academic achievements with supporting documents.",
                    step3_title: "Get Competition Recommendations",
                    step3_desc: "The system analyzes your profile and achievements to provide suitable competition recommendations.",
                    step4_title: "Register and Join Competitions",
                    step4_desc: "Register competitions directly via the app and monitor your competition status.",
                    features_title: "PRESen Main Features",
                    features_desc: "Supporting the development of student achievements digitally and integrated.",
                    feature1_title_f: "Student Profile Management",
                    feature1_desc_f: "Manage academic data, skills, and competition interests easily and completely.",
                    feature2_title_f: "Achievement Recording & Verification",
                    feature2_desc_f: "Input achievements with supporting evidence, verified by supervisors.",
                    feature3_title_f: "Competition Recommendation System",
                    feature3_desc_f: "Get accurate and targeted competition recommendations based on achievement and interests.",
                    feature4_title_f: "Latest Competition Notifications",
                    feature4_desc_f: "Receive direct notifications about the latest relevant competitions.",
                    contact_title: "Contact",
                    contact_desc: "Contact us for more information about PRESen",
                    address_title: "Our Address",
                    address_detail: "Information Technology Department, Politeknik Negeri Malang<br>Jl. Soekarno-Hatta No.9, Malang, Indonesia",
                    phone_title: "Contact Number",
                    phone_detail: "Phone: +62 341 123456<br>Email: info@polinema.ac.id",
                    hours_title: "Opening Hours",
                    hours_detail: "Monday - Friday: 08:00 - 16:00<br>Saturday & Sunday: Closed",
                    form_name: "Your Name*",
                    form_email: "Email Address*",
                    form_phone: "Phone Number*",
                    form_service: "Select Service*",
                    form_option1: "PRESen Information",
                    form_option2: "Technical Support",
                    form_option3: "Feedback & Suggestions",
                    form_message: "Write your message*",
                    form_submit: "Send Message",
                    loading: "Loading...",
                    sent_message: "Your message has been sent. Thank you!",
                    footer_about: "Information Technology Department",
                    footer_campus: "Politeknik Negeri Malang",
                    footer_phone: "Phone:",
                    footer_email: "Email:",
                    footer_useful_links: "Useful Links",
                    footer_support: "Support",
                    footer_newsletter: "Newsletter",
                    footer_newsletter_text: "Get the latest updates about competitions and PRESen features directly to your email.",
                    footer_subscribe: "Subscribe"
                },
                id: {
                    // Default bahasa Indonesia, jadi teks asli tidak perlu diisi ulang
                }
            };

            function translate(lang) {
                document.querySelectorAll("[data-i18n]").forEach((el) => {
                    // Simpan teks asli bahasa Indonesia di atribut data-i18n-original
                    if (!el.hasAttribute("data-i18n-original")) {
                        el.setAttribute("data-i18n-original", el.innerHTML);
                    }

                    const key = el.getAttribute("data-i18n");
                    if (lang === "id") {
                        // Kembalikan ke teks asli
                        el.innerHTML = el.getAttribute("data-i18n-original");
                    } else if (translations[lang] && translations[lang][key]) {
                        el.innerHTML = translations[lang][key];
                    }
                });

                // Untuk placeholder input/textarea
                document.querySelectorAll("[data-i18n-placeholder]").forEach((el) => {
                    if (!el.hasAttribute("data-i18n-placeholder-original")) {
                        el.setAttribute("data-i18n-placeholder-original", el.placeholder);
                    }
                    const key = el.getAttribute("data-i18n-placeholder");
                    if (lang === "id") {
                        el.placeholder = el.getAttribute("data-i18n-placeholder-original");
                    } else if (translations[lang] && translations[lang][key]) {
                        el.placeholder = translations[lang][key];
                    }
                });

                // Untuk opsi select
                document.querySelectorAll("select option[data-i18n]").forEach((el) => {
                    if (!el.hasAttribute("data-i18n-original")) {
                        el.setAttribute("data-i18n-original", el.innerHTML);
                    }
                    const key = el.getAttribute("data-i18n");
                    if (lang === "id") {
                        el.innerHTML = el.getAttribute("data-i18n-original");
                    } else if (translations[lang] && translations[lang][key]) {
                        el.innerHTML = translations[lang][key];
                    }
                });
            }


            document.getElementById("btn-id").addEventListener("click", () => translate("id"));
            document.getElementById("btn-en").addEventListener("click", () => translate("en"));

            // Set default bahasa Indonesia saat load
            translate("id");
        </script>
    </body>

</html>
