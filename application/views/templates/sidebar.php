<!-- BEGIN SIDEBAR -->
<div class="page-sidebar-wrapper">
    <div class="page-sidebar navbar-collapse collapse">
        <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
            <li class="sidebar-toggler-wrapper hide">
                <div class="sidebar-toggler">
                    <span></span>
                </div>
            </li>
            
            <?php
            
            if (isset($menu_single)) {
                if (count($menu_single) > 0) {
                    foreach ($menu_single as $ms) {
                        $menu = strtolower($ms->n_menu);
                        $show_menu_name = $ms->n_menu;
                        $link = $ms->site_url;
                        $segment_name = $ms->segment_name;
                        $icon = $ms->icon;
                        ?>
        
                        <li class="nav-item start <?php if($this->uri->segment(1)=="<?= $segment_name ?>") echo 'active open'; ?>">
                            <a href="<?= site_url($link) ?>" class="nav-link nav-toggle">
                                <i class="<?= $icon ?>"></i>
                                <span class="title"><?= $show_menu_name ?></span>
                                <span class="selected"></span>
                            </a>
                        </li>
        
                        <?php
                    }
                }
            }
            ?>
            
            <li class="heading">
                <h3 class="uppercase">Management</h3>
            </li>

            <?php 
            if (isset($menu_master)) {
                if (count($menu_master) > 0) {
                    ?>
                    <li class="nav-item <?php if($this->uri->segment(1)=="company" OR $this->uri->segment(1)=="card") echo 'active open'; ?>">
                        <a href="javascript:;" class="nav-link nav-toggle">
                            <i class="fa fa-medium"></i>
                            <span class="title">Master</span>
                            <span class="arrow"></span>
                        </a>
                        <ul class="sub-menu">

                            <?php
                            foreach($menu_master as $mm){
                                $menu = strtolower($mm->n_menu);
                                $show_menu_name = $mm->n_menu;
                                $link = $mm->site_url;
                                $segment_name = $mm->segment_name;
                                $parent = strtolower($mm->n_parent);
                                $icon = $mm->icon;
                                ?>
                                
                                <li class="nav-item <?php if($this->uri->segment(1)=="<?= $segment_name ?>") echo 'active' ?>">
                                    <a href="<?= site_url($link) ?>" class="nav-link nav-toggle">
                                        <i class="<?= $icon ?>"></i>
                                        <span class="title"><?= $show_menu_name ?></span>
                                    </a>
                                </li>
                                <?php
                            }
                            ?>
                            
                        </ul>
                    </li>  
                    <?php 
                }
            }
            ?>

            <?php 
            if (isset($menu_card_owner)) {
                if (count($menu_card_owner) > 0) {
                    ?>
                    <li class="nav-item <?php if($this->uri->segment(1)=="employee" OR $this->uri->segment(1)=="non_employee" OR $this->uri->segment(1)=="tenant") echo 'active open'; ?>">
                        <a href="javascript:;" class="nav-link nav-toggle">
                            <i class="icon-users"></i>
                            <span class="title">Card Owner</span>
                            <span class="arrow"></span>
                        </a>
                        <ul class="sub-menu">

                            <?php
                            foreach($menu_card_owner as $mco){
                                $menu = strtolower($mco->n_menu);
                                $show_menu_name = $mco->n_menu;
                                $link = $mco->site_url;
                                $segment_name = $mco->segment_name;
                                $parent = strtolower($mco->n_parent);
                                $icon = $mco->icon;
                                ?>

                                <li class="nav-item <?php if($this->uri->segment(1)=="<?= $segment_name ?>") echo 'active' ?>">
                                    <a href="<?= site_url($link) ?>" class="nav-link">
                                        <i class="<?= $icon ?>"></i>
                                        <span class="title"><?= $show_menu_name ?></span>
                                    </a>
                                </li>

                                <?php
                            }
                            ?>
                        </ul>
                    </li>
                    <?php
                }
            }
            ?>

            <?php 
            if (isset($menu_report_transaction)) {
                if (count($menu_card_owner) > 0) {
                    ?>
                    <li class="nav-item <?php if($this->uri->segment(1)=="trans") echo 'active open' ?>">
                        <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="icon-docs"></i>
                            <span class="title">Report & Transaction</span>
                            <span class="arrow"></span>
                        </a>
                        <ul class="sub-menu">
                            
                            <?php
                            foreach($menu_report_transaction as $mrt){
                                $menu = strtolower($mrt->n_menu);
                                $show_menu_name = $mrt->n_menu;
                                $link = $mrt->site_url;
                                $segment_name = $mrt->segment_name;
                                $parent = strtolower($mrt->n_parent);
                                $icon = $mrt->icon;
                                ?>

                                <li class="nav-item <?php if($this->uri->segment(2)=="<?= $segment_name ?>") echo 'active' ?>">
                                    <a href="<?= site_url($link) ?>" class="nav-link">
                                    <i class="<?= $icon ?>"></i>
                                        <span class="title"><?= $show_menu_name ?></span>
                                    </a>
                                </li>

                                <?php 
                            }
                            ?>

                        </ul>
                    </li>
                    <?php
                }
            }
            ?>

        </ul>
    </div>
</div>
<!-- END SIDEBAR -->