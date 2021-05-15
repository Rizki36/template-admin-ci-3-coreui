<?php
$query = $this->db->query("SELECT COUNT(KodeKontak) AS Jml FROM kontak WHERE IsDibaca='0'");
$row = $query->row();
$jml_pesan = $row->Jml;
?>
<header class="c-header c-header-light c-header-fixed c-header-with-subheader">
    <button class="c-header-toggler c-class-toggler d-lg-none mfe-auto" type="button" data-target="#sidebar" data-class="c-sidebar-show">
        <i class="c-icon c-icon-lg cil-menu"></i>
    </button>
    <a class="c-header-brand d-lg-none" href="#">
        <svg width="118" height="46" alt="CoreUI Logo">
            <use xlink:href="<?= base_url('') ?>assets/admin/assets/brand/coreui.svg#full"></use>
        </svg>
    </a>
    <button class="c-header-toggler c-class-toggler mfs-3 d-md-down-none" type="button" data-target="#sidebar" data-class="c-sidebar-lg-show" responsive="true">
        <i class="c-icon c-icon-lg cil-menu"></i>
    </button>
    <ul class="c-header-nav d-md-down-none">
        <li class="c-header-nav-item px-3"><a class="c-header-nav-link" href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
    </ul>
    <ul class="c-header-nav ml-auto mr-4">
        <li class="c-header-nav-item d-md-down-none mx-2">
            <a class="c-header-nav-link" href="<?= base_url('admin/pesan') ?>">
                <i class="c-icon cil-envelope-closed"></i>
                <span class="badge badge-light badge-pill" style="position: static;"><?= $jml_pesan ?></span>
            </a>
        </li>
        <li class="c-header-nav-item dropdown">
            <a class="c-header-nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                <div class="c-avatar"><img class="c-avatar-img" src="<?= base_url('assets/admin/img/users/' . ($_SESSION['Foto'] != '' ? $_SESSION['Foto'] : 'no-image.jpg')) ?>"></div>
            </a>
            <div class="dropdown-menu dropdown-menu-right pt-0">
                <!-- <div class="dropdown-header bg-light py-2"><strong>Account</strong></div> -->
                <a class="dropdown-item" href="<?= base_url('admin/login/logout') ?>">
                    <i class="c-icon mr-2 cil-account-logout"></i>
                    Logout
                </a>
            </div>
        </li>
    </ul>
    <div class="c-subheader px-3">
        <!-- Breadcrumb-->
        <ol class="breadcrumb border-0 m-0">
            <?php $breadcrumb = isset($breadcrumb) ? $breadcrumb : []; ?>
            <?php foreach ($breadcrumb as $key) : ?>
                <li class="breadcrumb-item <?= $key['IsAktif'] > 0 ? 'active' : '' ?>">
                    <a href="<?= $key['Url'] ?>"><?= $key['Name'] ?></a>
                </li>
            <?php endforeach ?>
        </ol>
        <!-- Breadcrumb Menu-->
    </div>
</header>