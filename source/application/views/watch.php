<?php $this->load->view('global/header'); ?>   

        <div class="container">
          
<?php $this->load->view('global/menu'); ?>   

        <?php
            switch ($this->uri->segment(2)):
                case 'inventory':
                    $this->load->view('partials/inventory');
                    break;
                default:
                    $this->load->view('partials/home');
                    break;
            endswitch;
            ?>

        <img src="<?php Resource::getInstance()->echoPath('images/specialize.jpg'); ?>" alt="Luxury Brands Rolex Cartier Breitling IWC Omega Audemars Piguet TAG Heuer Panerai">
        
<?php $this->load->view('global/footer'); ?>   