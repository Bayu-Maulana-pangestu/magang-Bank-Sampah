<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Angkut Sampah</title>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="style.css">

    <style>
        .back-to-top {
            display: none;
            position: fixed;
            bottom: 20px;
            right: 30px;
            z-index: 99;
            border: none;
            outline: none;
            background-color: #555;
            color: white;
            cursor: pointer;
            padding: 15px;
            border-radius: 10px;
            font-size: 18px;
        }

        .back-to-top:hover {
            background-color: #333;
        }
    </style>

</head>

<body>
    <nav class="navlist">
        <div>
            <h1>Bank Sampah</h1>
        </div>
        <ul>
            <li><a href="#beranda">BERANDA</a></li>
            <li><a href="#informasi">INFORMASI</a></li>
            <li><a href="#layanan">LAYANAN</a></li>
        </ul>
    </nav>

    <div id="beranda" class="detel" style="margin-bottom: 110px;">
        <h1>SISTEM LAYANAN <br>PENGANGKUT SAMPAH</h1>
        <p>Bank Sampah merupakan suatu layanan yang
            <br> menyediakan jasa pengangkutan sampah
        </p>
        <div style="margin-top: 20px;">
            <a href="user/register_user.php" style="margin-left: -1px; margin-right: 60px;">Daftar Sekarang</a>
            <a href="user/login_user.php">Login Sekarang</a>
        </div>
        <div class="images" style="margin-bottom: 50px;">
            <img src="img/logo.png" class="logo">
        </div>
    </div>

    <section id="informasi">
        <div class="fitur">
            <h1>Alur Penyetoran Sampah</h1>
        </div>
        <div class="fitur-content">
            <div class="item-card">
                <span class="lingkaran">
                    <img src="img/garbage.png" alt="" style="width: 140px; height: 140px">
                </span>
                <div class="item">
                    <h3>Pemilahan Sampah</h3>
                </div>
            </div>

            <div class="item-card">
                <span class="lingkaran">
                    <img src="img/clock.png" alt="" style="width: 140px; height: 140px">
                </span>
                <div class="item">
                    <h3>Penyetoran ke Bank Sampah</h3>
                </div>
            </div>

            <div class="item-card">
                <span class="lingkaran">
                    <img src="img/control.png" alt="" style="width: 140px; height: 140px">
                </span>
                <div class="item">
                    <h3>Penimbangan dan Pencatatan Jumlah Sampah</h3>
                </div>
            </div>

            <div class="item-card">
                <span class="lingkaran">
                    <img src="img/card.png" alt="" style="width: 140px; height: 140px">
                </span>
                <div class="item">
                    <h3>Penerbitan Invoice Hasil Tabungan Sampah</h3>
                </div>
            </div>
        </div>
    </section>

    <section id="informasi">
        <div class="layanan">
            <h1>Jenis Sampah yang Diterima</h1>
        </div>
    </section>


    <link rel="stylesheet" href="style2.css">
    <div class="card-container">

        <div class="card">
            <img src="img/anorganik.jpg" alt="">
            <div class="card-content">
                <h3>Sampah Anorganik</h3>
                <p>Sampah anorganik adalah jenis sampah yang berasal dari bahan-bahan non-biodegradable atau tidak dapat terurai secara alami oleh mikroorganisme.
                    Sampah anorganik seringkali terdiri dari bahan sintetis atau buatan manusia yang memerlukan waktu sangat lama untuk terurai,
                    bahkan bisa berabad-abad. Contoh dari sampah anorganik meliputi plastik, logam, kaca, karet, dan bahan-bahan elektronik.</p>

            </div>
        </div>

    </div>

    <section id="layanan">

        <div class="fitur">
            <h1>Fitur</h1>
            <p>Fitur yang anda dapatkan ketika mendaftar</p>
        </div>

        <div class="fitur-content">
            <div class="item-card">
                <span class="lingkaran">
                    <svg xmlns="http://www.w3.org/2000/svg" width="150" height="150" fill="
                white" class="bi bi-cash-stack" viewBox="0 0 16 16">
                        <path d="M1 3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1zm7 8a2 2 0 1 0 0-4 2 2 0 0 0 0 4" />
                        <path d="M0 5a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1zm3 0a2 2 0 0 1-2 2v4a2 2 0 0 1 2 2h10a2 2 0 0 1 2-2V7a2 2 0 0 1-2-2z" />
                    </svg>
                </span>
                <div class="item">

                    <h3>Pembayaran</h3>
                    <p>Bayar tagihan secara adil sesuai berat sampah yang dihasilkan.</p>
                </div>
            </div>

            <div class="item-card">
                <span class="lingkaran">
                    <svg xmlns="http://www.w3.org/2000/svg" width="140" height="140" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-book">
                        <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H19a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H6.5a1 1 0 0 1 0-5H20" />
                    </svg>
                </span>
                <div class="item">

                    <h3>Buku Tabungan</h3>
                    <p>Kamu bisa melihat informasi tentang saldo.</p>
                </div>
            </div>

            <div class="item-card">
                <span class="lingkaran">
                    <svg xmlns="http://www.w3.org/2000/svg" width="140" height="140" fill="white" class="bi bi-clipboard2-data-fill" viewBox="0 0 16 16">
                        <path d="M10 .5a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5.5.5 0 0 1-.5.5.5.5 0 0 0-.5.5V2a.5.5 0 0 0 .5.5h5A.5.5 0 0 0 11 2v-.5a.5.5 0 0 0-.5-.5.5.5 0 0 1-.5-.5" />
                        <path d="M4.085 1H3.5A1.5 1.5 0 0 0 2 2.5v12A1.5 1.5 0 0 0 3.5 16h9a1.5 1.5 0 0 0 1.5-1.5v-12A1.5 1.5 0 0 0 12.5 1h-.585q.084.236.085.5V2a1.5 1.5 0 0 1-1.5 1.5h-5A1.5 1.5 0 0 1 4 2v-.5q.001-.264.085-.5M10 7a1 1 0 1 1 2 0v5a1 1 0 1 1-2 0zm-6 4a1 1 0 1 1 2 0v1a1 1 0 1 1-2 0zm4-3a1 1 0 0 1 1 1v3a1 1 0 1 1-2 0V9a1 1 0 0 1 1-1" />
                    </svg>
                </span>
                <div class="item">

                    <h3>Riwayat</h3>
                    <p>Kamu bisa melihat riwayat sampah, berat sampah, transporter yang mengambil beserta tagihannya.</p>
                </div>
            </div>


        </div>
    </section>

    <section>
        <div class="cta-section">
            <div>
                <img src="img/slide.png" alt="">
            </div>
            <div class="cta-content">
                <h1>Mau Sampahmu diangkut? <br> Ayo daftar sekarang juga</h1>
            </div>
        </div>
    </section>


    <div class="alamat">
        <h1>Lokasi Kantor</h1>
        <div class="alamat-content">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3983.0912432760038!2d114.58632277497202!3d-3.32763214664717!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2de423d947d49d87%3A0x8c94ba27d447362f!2sDinas%20Lingkungan%20Hidup%20Kota%20Banjarmasin!5e0!3m2!1sid!2sid!4v1722959059618!5m2!1sid!2sid" width="800" height="600" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        <a href="https://maps.app.goo.gl/YTTsRmSEomHSoFgp6">Klik disini</a>
    </div>

    <button class="back-to-top" id="back-to-top" title="Back to Top">↑</button>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('nav ul li a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();

                    const sectionId = this.getAttribute('href').substring(1);
                    const section = document.getElementById(sectionId);

                    window.scrollTo({
                        top: section.offsetTop - 50,
                        behavior: 'smooth'
                    });
                });
            });

            // Back to Top button functionality
            const backToTopButton = document.getElementById("back-to-top");

            window.onscroll = function() {
                scrollFunction();
            };

            function scrollFunction() {
                if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                    backToTopButton.style.display = "block";
                } else {
                    backToTopButton.style.display = "none";
                }
            }

            backToTopButton.addEventListener("click", function() {
                window.scrollTo({
                    top: 0,
                    behavior: "smooth"
                });
            });
        });
    </script>

</body>

</html>