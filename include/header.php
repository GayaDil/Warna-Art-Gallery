<?php
$cc = new Cart();
$cc = $cc->cart_count();
$cart_count = ( $cc > 0 ) ? '<span class="badge badge-dark badge-pill">'.$cc.'</span>' : '';

?>
<div class="header">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="navigation">
                    <nav class="navbar navbar-expand-lg navbar-light bg-theme">
                        <a class="navbar-brand" href="./"><img src="assets/images/logo.png" alt=""
                                class="img-fluid"></a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse"
                            data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarNavDropdown">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link" href="./"><i class="mdi mdi-home "></i> Home</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="gallery"><i class="mdi mdi-camera "></i> Gallery</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="auction"><i class="mdi mdi-gavel "></i> Auction</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="artists"><i class="mdi mdi-palette "></i> Artists</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="blogs"><i class="mdi mdi-blogger "></i> Blog</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="about-us"><i class="mdi mdi-account-multiple "></i> About Us</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="contact"><i class="mdi mdi-phone "></i> Contact Us</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="cart">
                                    	<i class="mdi mdi-cart-plus "></i> Cart
                                        <span class="cart-count"><?php echo $cart_count; ?></span>
                                    	
                                    </a>
                                </li>
                                <li class="nav-item dropdown">
                                    <?php if ( isset( $this_user_fullname ) ) :?>
                                    <a class="nav-link dropdown-toggle" href="javascript:void(0)" data-toggle="dropdown"><i class="mdi mdi-account "></i> <?php echo $this_user_fullname; ?>
                                    </a>
                                    <?php else : ?>
                                    <a class="nav-link dropdown-toggle" href="javascript:void(0)" data-toggle="dropdown"><i class="mdi mdi-account "></i> Profile
                                    </a>
                                    <?php endif;?>
                                    <div class="dropdown-menu">
                                        <?php if ( isset( $this_user_role_id ) ) :

                                            switch ( $this_user_role_id ) {
                                                case 1:
                                                    $redirect_url = 'admin/';
                                                    break;
                                                case 2:
                                                    $redirect_url = 'artist/';
                                                    break;
                                                case 3:
                                                    $redirect_url = 'profile';
                                                    break;
                                                default:
                                                    $redirect_url = './';
                                                    break;
                                            }                                           
                                        ?> 
                                        <a class="dropdown-item" href="<?php echo $redirect_url; ?>">My profile </a>
                                        <a class="dropdown-item" href="orders">My orders</a>
                                        <a class="dropdown-item" href="logout">logout</a>
                                        <?php else : ?>
                                        <a class="dropdown-item" href="register">Register</a>
                                        <a class="dropdown-item" href="login">Login</a>
                                        <?php endif; ?>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>