<div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
    <div class="c-sidebar-brand d-lg-down-none">
        <svg class="c-sidebar-brand-full" width="118" height="46" alt="CoreUI Logo">
            <use xlink:href="<?= base_url() ?>assets/admin/assets/brand/coreui.svg#full"></use>
        </svg>
        <svg class="c-sidebar-brand-minimized" width="46" height="46" alt="CoreUI Logo">
            <use xlink:href="<?= base_url() ?>assets/admin/assets/brand/coreui.svg#signet"></use>
        </svg>
    </div>
    <ul class="c-sidebar-nav">
        <li class="c-sidebar-nav-title">Theme</li>
        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link <?= @$menu == 'user' ? 'c-active' : '' ?>" href="<?= base_url('admin/user') ?>">
                <i class="c-sidebar-nav-icon c-icon cil-people"></i>
                User
            </a>
        </li>

        <li class="c-sidebar-nav-title">Website</li>
        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link <?= @$menu == 'slider' ? 'c-active' : '' ?>" href="<?= base_url('admin/slider') ?>">
                <i class="c-sidebar-nav-icon c-icon cil-image"></i>
                Slider
            </a>
        </li>
        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link <?= @$menu == 'pesan' ? 'c-active' : '' ?>" href="<?= base_url('admin/pesan') ?>">
                <i class="c-sidebar-nav-icon c-icon cil-envelope-closed"></i>
                Pesan
            </a>
        </li>
        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link <?= @$menu == 'berita' ? 'c-active' : '' ?>" href="<?= base_url('admin/konten/berita') ?>">
                <i class="c-sidebar-nav-icon c-icon cil-newspaper"></i>
                Berita
            </a>
        </li>
        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link" href="<?= base_url('admin/konten/event') ?>">
                <i class="c-sidebar-nav-icon c-icon cil-baseball"></i>
                Event
            </a>
        </li>

        <li class="c-sidebar-nav-item c-sidebar-nav-dropdown">
            <a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">
                <i class="c-sidebar-nav-icon fa fa-eye"></i>
                Buttons
            </a>
            <ul class="c-sidebar-nav-dropdown-items">
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link" href="buttons/buttons.html">
                        <span class="c-sidebar-nav-icon"></span>
                        Buttons
                    </a>
                </li>
            </ul>
        </li>
    </ul>
    <button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent" data-class="c-sidebar-minimized"></button>
</div>