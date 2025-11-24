<footer class="text-center text-lg-start text-white" style="background-color: #1c2331">
    <!-- Section: Social media -->
    <section class="d-flex justify-content-between p-4" style="background-color: #6351ce">
        <!-- Left -->
        <div class="me-5">
            <span>Hãy kết nối với chúng tôi trên các mạng xã hội:</span>
        </div>
        <!-- Left -->

        <!-- Right -->
        <div>
            <a href="https://www.facebook.com/dat.dang.756859" class="text-white me-4" target="_blank"><i
                    class="fab fa-facebook-f"></i></a>
            {{-- <a href="" class="text-white me-4"><i class="fab fa-twitter"></i></a>
            <a href="" class="text-white me-4"><i class="fab fa-google"></i></a> --}}
            <a href="https://www.instagram.com/_qoocdat/" class="text-white me-4" target="_blank"><i
                    class="fab fa-instagram"></i></a>
            {{-- <a href="" class="text-white me-4"><i class="fab fa-linkedin"></i></a> --}}
            <a href="https://github.com/Iwant2dye8976" class="text-white me-4" target="_blank"><i
                    class="fab fa-github"></i></a>
        </div>
        <!-- Right -->
    </section>
    <!-- Section: Social media -->

    <!-- Section: Links  -->
    <section class="">
        <div class="container text-center text-md-start mt-5">
            <!-- Grid row -->
            <div class="row mt-3">
                <!-- Grid column -->
                <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
                    <!-- Content -->
                    <h6 class="text-uppercase fw-bold">SPORTBOOKS</h6>
                    <hr class="mb-4 mt-0 d-inline-block mx-auto"
                        style="width: 60px; background-color: #7c4dff; height: 2px" />
                    <p>Thế giới tri thức trong tầm tay!</p>
                    <p>
                        Khám phá kho sách đa dạng với nhiều thể loại hấp dẫn. Chúng tôi mang đến cho bạn những tựa sách
                        hay nhất, giúp mở rộng hiểu biết và nuôi dưỡng đam mê đọc sách mỗi ngày.
                    </p>
                </div>
                <!-- Grid column -->

                <!-- Grid column -->
                {{-- <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
                    <!-- Links -->
                    <h6 class="text-uppercase fw-bold">Sản phẩm</h6>
                    <hr class="mb-4 mt-0 d-inline-block mx-auto"
                        style="width: 60px; background-color: #7c4dff; height: 2px" />
                    <p>
                        <a href="#!" class="text-white">MDBootstrap</a>
                    </p>
                    <p>
                        <a href="#!" class="text-white">MDWordPress</a>
                    </p>
                    <p>
                        <a href="#!" class="text-white">BrandFlow</a>
                    </p>
                    <p>
                        <a href="#!" class="text-white">Bootstrap Angular</a>
                    </p>
                </div> --}}
                <!-- Grid column -->

                <!-- Grid column -->
                <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
                    <!-- Links -->
                    <h6 class="text-uppercase fw-bold">Đường dẫn</h6>
                    <hr class="mb-4 mt-0 d-inline-block mx-auto"
                        style="width: 60px; background-color: #7c4dff; height: 2px" />
                    @guest
                        <p>
                            <a class="text-white" href="{{ route('home') }}">Trang chủ</a>
                        </p>
                        @if (!Route::is('login'))
                            <p>
                                <a class="text-white" href="{{ route('login') }}">Đăng nhập</a>
                            </p>
                        @endif
                        @if (!Route::is('register'))
                            <p>
                                <a class="text-white" href="{{ route('register') }}">Đăng kí</a>
                            </p>
                        @endif
                    @endguest
                    @auth
                        @if (Auth::user()->type === 'user')
                            <p>
                                <a class="text-white" href="{{ route('home') }}">Trang chủ</a>
                            </p>
                            <p>
                                <a href="{{ route('profile.edit') }}" class="text-white">Tài khoản</a>
                            </p>

                            <p>
                                <a href="{{ route('cart') }}" class="text-white">Giỏ hàng</a>
                            </p>
                            <p>
                                <a href="{{ route('orders') }}" class="text-white">Đơn hàng</a>
                            </p>
                        @endif
                        @if (Auth::user()->type === 'admin')
                        <p>
                            <a class="text-white" href="{{ route('admin.book-m') }}">Quản lý sách</a>
                        </p>
                        <p>
                            <a class="text-white" href="{{ route('admin.user-m') }}">Quản lý tài khoản</a>
                        </p>
                        <p>
                            <a class="text-white" href="{{ route('admin.order-m') }}">Quản lý đơn hàng</a>
                        </p>
                            <p>
                                <a href="{{ route('admin.profile.edit') }}" class="text-white">Tài khoản</a>
                            </p>
                        @endif
                    @endauth

                    {{-- <p>
                        <a href="#!" class="text-white">Shipping Rates</a>
                    </p>
                    <p>
                        <a href="#!" class="text-white">Help</a>
                    </p> --}}
                </div>
                <!-- Grid column -->

                <!-- Grid column -->
                <div class="col-md-4 col-lg-4 col-xl-3 mx-auto mb-md-0 mb-4">
                    <!-- Links -->
                    <h6 class="text-uppercase fw-bold">Liên hệ</h6>
                    <hr class="mb-4 mt-0 d-inline-block mx-auto"
                        style="width: 60px; background-color: #7c4dff; height: 2px" />
                    <p><i class="fas fa-home mr-3"></i> 123, Đường Nguyễn Văn Thể Thao, Hà Đông, Hà Nội
                    </p>
                    <p style="width: 300px;"><i class="fas fa-envelope mr-3"></i> dangquocdatyahoocomvn@gmail.com</p>
                    <p><i class="fas fa-phone mr-3"></i> + 84 977923301 </p>
                    {{-- <p><i class="fas fa-print mr-3"></i> + 01 234 567 89</p> --}}
                </div>
                <!-- Grid column -->
            </div>
            <!-- Grid row -->
        </div>
    </section>
    <!-- Section: Links  -->

    <!-- Copyright -->
    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2)">
        © <?php echo date('Y'); ?> Bản quyền thuộc về:
        <a class="text-white" href="#">SPORTBOOKS</a>
    </div>
    <!-- Copyright -->
</footer>
