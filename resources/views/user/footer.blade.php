
<div class="footer-top-area">
    <div class="zigzag-bottom"></div>
    <div class="container">
        <div class="row">
            {{-- Cột giới thiệu --}}
            <div class="col-md-3 col-sm-6">
                <div class="footer-about-us">
                    <h2>{{ $caidat->TenWebsite ?? 'eElectronics' }}</h2>
                    <p>{{ $caidat->MoTa ?? 'Cửa hàng điện tử trực tuyến cung cấp sản phẩm chính hãng.' }}</p>

                    <div class="footer-social">
                        @if(!empty($socialLinks))
                            @foreach (['Facebook', 'Twitter', 'Youtube', 'Linkedin', 'Pinterest'] as $social)
                                @if(!empty($socialLinks->$social))
                                    <a href="{{ $socialLinks->$social }}" target="_blank">
                                        <i class="fa fa-{{ strtolower($social) }}"></i>
                                    </a>
                                @endif
                            @endforeach
                        @else
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-youtube"></i></a>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Các phần còn lại giữ nguyên --}}
            <div class="col-md-3 col-sm-6">
                <div class="footer-menu">
                    <h2 class="footer-wid-title">User Navigation</h2>
                    <ul>
                        <li><a href="#">My account</a></li>
                        <li><a href="#">Order history</a></li>
                        <li><a href="#">Wishlist</a></li>
                        <li><a href="#">Vendor contact</a></li>
                        <li><a href="#">Front page</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="footer-menu">
                    <h2 class="footer-wid-title">Categories</h2>
                    <ul>
                        <li><a href="#">Mobile Phone</a></li>
                        <li><a href="#">Home accesseries</a></li>
                        <li><a href="#">LED TV</a></li>
                        <li><a href="#">Computer</a></li>
                        <li><a href="#">Gadgets</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="footer-newsletter">
                    <h2 class="footer-wid-title">Newsletter</h2>
                    <p>Sign up to our newsletter and get exclusive deals straight to your inbox!</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="footer-bottom-area">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="copyright">
                    <p>{{ $caidat->Copyright ?? '© 2025 eElectronics. All Rights Reserved.' }}</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="footer-card-icon">
                    <i class="fa fa-cc-discover"></i>
                    <i class="fa fa-cc-mastercard"></i>
                    <i class="fa fa-cc-paypal"></i>
                    <i class="fa fa-cc-visa"></i>
                </div>
            </div>
        </div>
    </div>
</div>
=======




<!-- ---------------------------------------------------- -->
     <div class="footer-top-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="footer-about-us">
                        <h2>e<span>Electronics</span></h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Perferendis sunt id doloribus vero quam laborum quas alias dolores blanditiis iusto consequatur, modi aliquid eveniet eligendi iure eaque ipsam iste, pariatur omnis sint! Suscipit, debitis, quisquam. Laborum commodi veritatis magni at?</p>
                        <div class="footer-social">
                            @if(!empty($socialLinks))
                                @if(!empty($socialLinks->Facebook))
                                    <a href="{{ $socialLinks->Facebook }}" target="_blank"><i class="fa fa-facebook"></i></a>
                                @endif
                                @if(!empty($socialLinks->Twitter))
                                    <a href="{{ $socialLinks->Twitter }}" target="_blank"><i class="fa fa-twitter"></i></a>
                                @endif
                                @if(!empty($socialLinks->Youtube))
                                    <a href="{{ $socialLinks->Youtube }}" target="_blank"><i class="fa fa-youtube"></i></a>
                                @endif
                                @if(!empty($socialLinks->Linkedin))
                                    <a href="{{ $socialLinks->Linkedin }}" target="_blank"><i class="fa fa-linkedin"></i></a>
                                @endif
                                @if(!empty($socialLinks->Pinterest))
                                    <a href="{{ $socialLinks->Pinterest }}" target="_blank"><i class="fa fa-pinterest"></i></a>
                                @endif
                            @else
                                {{-- Fallback nếu chưa có dữ liệu --}}
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                                <a href="#"><i class="fa fa-youtube"></i></a>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 col-sm-6">
                    <div class="footer-menu">
                        <h2 class="footer-wid-title">User Navigation </h2>
                        <ul>
                            <li><a href="#">My account</a></li>
                            <li><a href="#">Order history</a></li>
                            <li><a href="#">Wishlist</a></li>
                            <li><a href="#">Vendor contact</a></li>
                            <li><a href="#">Front page</a></li>
                        </ul>                        
                    </div>
                </div>
                
                <div class="col-md-3 col-sm-6">
                    <div class="footer-menu">
                        <h2 class="footer-wid-title">Categories</h2>
                        <ul>
                            <li><a href="#">Mobile Phone</a></li>
                            <li><a href="#">Home accesseries</a></li>
                            <li><a href="#">LED TV</a></li>
                            <li><a href="#">Computer</a></li>
                            <li><a href="#">Gadets</a></li>
                        </ul>                        
                    </div>
                </div>
                
                <div class="col-md-3 col-sm-6">
                    <div class="footer-newsletter">
                        <h2 class="footer-wid-title">Newsletter</h2>
                        <p>Sign up to our newsletter and get exclusive deals you wont find anywhere else straight to your inbox!</p>
                        
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End footer top area -->
    
    <div class="footer-bottom-area">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="copyright">
                        <p>&copy; 2015 eElectronics. All Rights Reserved. Coded with <i class="fa fa-heart"></i> by <a href="http://wpexpand.com" target="_blank">WP Expand</a></p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="footer-card-icon">
                        <i class="fa fa-cc-discover"></i>
                        <i class="fa fa-cc-mastercard"></i>
                        <i class="fa fa-cc-paypal"></i>
                        <i class="fa fa-cc-visa"></i>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End footer bottom area -->
