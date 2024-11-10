<?php

$opac = new Orders();
$opac = $opac->pending_approval_count($this_user_id, 1);

$opsc = new Orders();
$opsc = $opsc->pending_shipments_count($this_user_id, 1);


?>

<aside class="main-sidebar">
    <!-- sidebar-->
    <section class="sidebar">
      
      <!-- sidebar menu-->
      <ul class="sidebar-menu" data-widget="tree">

        <!------------- Orders ---------------> 
        <li><a href="../" class="text-pink "><i class="mdi mdi-home text-pink"></i> Home </a></li>

        <li class="header nav-small-cap"><i class="mdi mdi-drag-horizontal mr-5"></i>ORDERS</li>   
      
        <li><a href="orders"><i class="mdi mdi-truck mr-5"></i> All Orders</a></li>

        <li>
          <a href="order-pending-approve">
            <i class="mdi mdi-alert-outline"></i> Pending Approval

            <?php if ( $opac > 0 ): ?>
            <span class="badge badge-sm badge-danger pull-right"><?php echo str_pad($opac, 2, 0, STR_PAD_LEFT ); ?></span>
            <?php endif; ?>
          </a>
        </li>

        <li>
          <a href="order-pending-shipments">
            <i class="mdi mdi-truck-delivery"></i> Pending Shipments

            <?php if ( $opsc > 0 ): ?>
            <span class="badge badge-sm badge-danger pull-right"><?php echo str_pad($opsc, 2, 0, STR_PAD_LEFT ); ?></span>
            <?php endif; ?>
          </a>
        </li>

        <li>
          <a href="received-payments">
            <i class="mdi mdi-truck-delivery"></i> Received Payments
          </a>
        </li>


         <!------------- Products --------------->
        
        <li class="header nav-small-cap"><i class="mdi mdi-drag-horizontal mr-5"></i>ARTWORKS MANAGER</li>     
      
        <li class="treeview">
          <a href="#">
            <i class="mdi mdi-image-area"></i>
             <span>Artworks</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="products"><i class="mdi mdi-format-list-bulleted"></i>My Artworks</a></li>
            <li><a href="bid-products"><i class="mdi mdi-format-list-bulleted"></i>Bid Artworks</a></li>
            <li><a href="product"><i class="mdi mdi-library-plus"></i>Add New</a></li>
          </ul>
        </li>


         <!------------- Personal --------------->

        <li class="header nav-small-cap"><i class="mdi mdi-drag-horizontal mr-5"></i>PERSONAL INFO</li>     
      
        <li class="treeview">
          <a href="#">
            <i class="mdi mdi-account-circle"></i>
             <span>Personal</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="profile"><i class="mdi mdi-format-list-bulleted"></i>My Details</a></li>
            <?php if ( $nic_verified == 0 ) : ?>
            <li><a href="verify"><i class="mdi mdi-verified"></i>Verify Account</a></li>
            <?php endif; ?>            
          </ul>
        </li>
                
      </ul>
    </section>
</aside>