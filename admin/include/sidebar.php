<?php

$nac = new Users();
$nac = $nac->pending_nic_approval_count();

$opac = new Orders();
$opac = $opac->pending_payment_approval_count();




$opaac = new Orders();
$opaac = $opaac->pending_approval_count();

$oppc = new Orders();
$oppc = $oppc->pending_payment_count();

$opsc = new Orders();
$opsc = $opsc->pending_shipments_count();

$oupc = new Orders();
$oupc = $oupc->pending_collect_count();

$oapc = new Orders();
$oapc = $oapc->artist_pending_payments_count();



$oic = new Orders();
$oic = $oic->order_inquiries_unread_count();


$ciww = new Users();
$ciww = $ciww->contact_inquiries_unread_count();



?>
<aside class="main-sidebar">
    <!-- sidebar-->
    <section class="sidebar">
      
      <!-- sidebar menu-->
      <ul class="sidebar-menu" data-widget="tree">


        <!------------- Orders ---------------> 

        <li><a href="../"><i class="mdi mdi-home text-primary"></i> HOME</a></li>

        <li class="header nav-small-cap"><i class="mdi mdi-drag-horizontal mr-5"></i>RECENT ACTIVITIES</li> <!-- --->  
      
        <li><a href="orders"><i class="mdi mdi-truck"></i> All orders</a></li>

        <li>
          <a href="order-pending-payments-approve">
            <i class="mdi mdi-alert-outline text-danger"></i> Payment Approval
            <?php if ( $opac > 0 ): ?>
            <span class="badge badge-sm badge-danger pull-right"><?php echo str_pad($opac, 2, 0, STR_PAD_LEFT ); ?></span>
            <?php endif; ?>
          </a>
        </li>


        <li>
          <a href="artist-pending-payments">
            <i class="mdi mdi-cash-multiple text-danger"></i> Artist Payments
            <?php if ( $oapc > 0 ): ?>
            <span class="badge badge-sm badge-danger pull-right"><?php echo str_pad($oapc, 2, 0, STR_PAD_LEFT ); ?></span>
            <?php endif; ?>
          </a>
        </li>

        <!-- Dispatched orders -->

        <li>
          <a href="placed-orders">
            <i class="mdi mdi-cart-outline"></i> Placed Orders
            <?php if ( $opaac > 0 ): ?>
            <span class="badge badge-sm badge-danger pull-right"><?php echo str_pad($opaac, 2, 0, STR_PAD_LEFT ); ?></span>
            <?php endif; ?>
          </a>
        </li>


        <li>
          <a href="artist-approved-orders">
            <i class="mdi mdi-spellcheck"></i> Artist Approved
            <?php if ( $oppc > 0 ): ?>
            <span class="badge badge-sm badge-danger pull-right"><?php echo str_pad($oppc, 2, 0, STR_PAD_LEFT ); ?></span>
            <?php endif; ?>
          </a>
        </li>


        <li>
          <a href="'order-pending-shipments">
            <i class="mdi mdi-cash-100"></i> Paid Orders
            <?php if ( $opsc > 0 ): ?>
            <span class="badge badge-sm badge-danger pull-right"><?php echo str_pad($opsc, 2, 0, STR_PAD_LEFT ); ?></span>
            <?php endif; ?>
          </a>
        </li>



        <li>
          <a href="dispatched-orders">
            <i class="mdi mdi-airplane"></i> Dispatched Orders
            <?php if ( $oupc > 0 ): ?>
            <span class="badge badge-sm badge-danger pull-right"><?php echo str_pad($oupc, 2, 0, STR_PAD_LEFT ); ?></span>
            <?php endif; ?>
          </a>
        </li>



        




        <li>
          <a href="pending-nic-approve">
            <i class="mdi mdi-account-alert"></i>NIC Pending Approval
            <?php if ( $nac > 0 ): ?>
            <span class="badge badge-sm badge-danger pull-right"><?php echo str_pad($nac, 2, 0, STR_PAD_LEFT ); ?></span>
            <?php endif; ?>
          </a>
        </li>

        <!-- Contact Inquiries -->

        <li>
          <a href="contact-inquiries">
            <i class="mdi mdi-contact-mail"></i> Contact Inquiries
            <?php if ( $ciww > 0 ): ?>
            <span class="badge badge-sm badge-danger pull-right"><?php echo str_pad($ciww, 2, 0, STR_PAD_LEFT ); ?></span>
            <?php endif; ?>
          </a>
        </li>

        <li>
          <a href="order-inquiries">
            <i class="mdi mdi-email-alert"></i> Order Inquiries
            <?php if ( $oic > 0 ): ?>
            <span class="badge badge-sm badge-danger pull-right"><?php echo str_pad($oic, 2, 0, STR_PAD_LEFT ); ?></span>
            <?php endif; ?>
          </a>
        </li>

        

        
        

         <!------------- Products ---------------> 

        <li class="header nav-small-cap"><i class="mdi mdi-drag-horizontal mr-5"></i>PRODUCTS</li>   
      
        <li class="treeview">
          <a href="#">
            <i class="mdi mdi-briefcase"></i>
            <span>Products</span>
            <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="products"><i class="mdi mdi-format-list-bulleted"></i>All Products</a></li>
            <li><a href="bid-products"><i class="mdi mdi-format-list-bulleted"></i>Bid Artworks</a></li>
            <li><a href="product"><i class="mdi mdi-library-plus"></i>Add New</a></li>
          </ul>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="mdi mdi-shape-plus"></i>
            <span>Categories</span>
            <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="categories"><i class="mdi mdi-format-list-bulleted"></i>All Categories</a></li>
            <li><a href="category"><i class="mdi mdi-library-plus"></i>Add New</a></li>
          </ul>
        </li>


        <li class="treeview">
          <a href="#">
            <i class="mdi mdi-bowl"></i>
            <span>Mediums</span>
            <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="mediums"><i class="mdi mdi-format-list-bulleted"></i>All mediums</a></li>
            <li><a href="medium"><i class="mdi mdi-library-plus"></i>Add New</a></li>
          </ul>
        </li>


         <!------------- Users ---------------> 


        <li class="header nav-small-cap"><i class="mdi mdi-drag-horizontal mr-5"></i>Users</li>           
        <li class="treeview">
            <a href="#">
              <i class="mdi mdi-account-multiple"></i>
              <span>Users</span>
              <span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="users"><i class="mdi mdi-format-list-bulleted"></i> All Users</a></li>
              <li><a href="user"><i class="mdi mdi-library-plus"></i> Add New</a></li>
            </ul>
        </li>

        


         <!------------- Blogs ---------------> 


      
        <li class="header nav-small-cap"><i class="mdi mdi-drag-horizontal mr-5"></i>Blogs</li>           
        <li class="treeview">
            <a href="#">
              <i class="mdi mdi-blogger"></i>
              <span>Blogs</span>
              <span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="blogs"><i class="mdi mdi-format-list-bulleted"></i> All Blogs</a></li>
              <li><a href="blog"><i class="mdi mdi-library-plus"></i> Add Blog</a></li>
            </ul>
        </li>


        
        <li class="header nav-small-cap"><i class="mdi mdi-drag-horizontal mr-5"></i>ORDERS</li> <!-- --->  

        <li class="treeview">
          <a href="#">
            <i class="mdi mdi-label"></i>
            <span>Order Statuses</span>
            <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="order-statuses"><i class="mdi mdi-format-list-bulleted"></i>All Order Statuses</a></li>
            <li><a href="order-status"><i class="mdi mdi-library-plus"></i>Add New</a></li>
          </ul>
        </li>



        <li>
          <a href="commission"><i class="mdi mdi-alert-outline"></i> Order Commission</a>
        </li>



         <!------------- Services ---------------> 


        <li class="header nav-small-cap"><i class="mdi mdi-drag-horizontal mr-5"></i>Services</li>           
        <li class="treeview">
            <a href="#">
              <i class="mdi mdi-brush"></i>
              <span>Services</span>
              <span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="services"><i class="mdi mdi-format-list-bulleted"></i> All Services</a></li>
              <li><a href="service"><i class="mdi mdi-library-plus"></i> Add New</a></li>
            </ul>
        </li>

        
      </ul>
    </section>
</aside>