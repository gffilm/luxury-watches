<?php $this->load->view('partials/header'); ?>   

        <div class="container">
          
<?php $this->load->view('partials/menu'); ?>   


        <div class="home-inventory">
              <a href="inventory.php" title="" class="button inventory-button">Current Inventory</a>
            </div>

            <div class="guaranteed">
                First Jewelry Source, LLC is one of the world's principal leaders in contemporary pre-owned, refurbished, vintage timepieces and jewelry pieces. Our focus is the purchase, restoration, and sale of fine timepieces.
            </div>

        <img src="<?php Resource::getInstance()->echoPath('images/specialize.jpg'); ?>" alt="Luxury Brands Rolex Cartier Breitling IWC Omega Audemars Piguet TAG Heuer Panerai">
        
<?php $this->load->view('partials/footer'); ?>   