<h3 class="d-inline-block mb-4">
    <i class="fa fa-users"></i> User
</h3>


<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <form action="<?= base_url('admin/user') ?>">
                    <div class="row align-items-center">
                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="input-group">
                                <input id="v" name="v" value="<?= @$v ?>" type="text" class="form-control" placeholder="Cari nama user" />
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6 my-2 my-md-0">
                            <div id="a" class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="a" value="1" <?= $a === 1 ? 'checked' : '' ?>>
                                <label class="form-check-label" for="">Aktif</label>
                            </div>
                            <div id="a" class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="a" value="0" <?= $a === 0 ? 'checked' : '' ?>>
                                <label class="form-check-label" for="">Nonaktif</label>
                            </div>
                            <div id="a" class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="a" value="-1" <?= $a === -1 ? 'checked' : '' ?>>
                                <label class="form-check-label" for="">Semua</label>
                            </div>
                            <button type="submit" class="btn btn-sm btn-primary d-inline-flex  align-items-center"><i class="c-icon c-icon-sm cil-search"></i> &nbsp; Cari</button>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-2 my-2 my-lg-0">
                            <a href="<?= base_url('admin/user/tambah') ?>" class="btn btn-sm btn-primary w-100 d-inline-flex align-items-center justify-content-center"><i class="c-icon c-icon-sm cil-plus"></i> &nbsp; Tambah Data</a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Nama User</th>
                                <th>Alamat</th>
                                <th>Tempat Lahir</th>
                                <th>Tgl Lahir</th>
                                <th>UserName</th>
                                <th>JenisUser</th>
                                <th>NIK</th>
                                <th class="text-center">Status</th>
                                <th class="text-center" width="150">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data as $no => $row) : ?>
                                <tr>
                                    <td scope="row"><?= $no + 1 ?></td>
                                    <td><?= $row->NamaUser ?></td>
                                    <td><?= $row->Alamat ?></td>
                                    <td><?= $row->TempatLahir ?></td>
                                    <td><?= date_indo(date('Y-m-d', strtotime($row->TglLahir))) ?></td>
                                    <td><?= $row->UserName ?></td>
                                    <td><?= $row->JenisUser ?></td>
                                    <td><?= $row->NIK ?></td>
                                    <td class="text-center">
                                        <?php $urlSetStatus = base_url("admin/user/setStatus/" . base64_encode($row->NIK)) ?>
                                        <?php if ((int)$row->IsAktif === 1) : ?>
                                            <a href="<?= $urlSetStatus . "/0" ?>" title="Nonaktifkan" type="button" class="btn btn-success btn-sm">Aktif</a>
                                        <?php else : ?>
                                            <a href="<?= $urlSetStatus . "/1" ?>" title="Aktifkan" type="button" class="btn btn-warning btn-sm text-white">Nonaktif</a>
                                        <?php endif ?>
                                    </td>
                                    <td class="text-center">
                                        <a class="btn btn-primary btn-sm text-white" data-id="<?= $row->UserName ?>" data-toggle="modal" data-target="#modal-detail" title="Detail data"><i class="fa fa-eye"></i></a>
                                        <a href="<?= base_url("admin/user/edit/" . base64_encode($row->UserName)) ?>" class="btn btn-info btn-sm" title="Edit data"><i class="fa fa-pencil-alt"></i></a>
                                        <a href="<?= base_url("admin/user/hapus?id=$row->UserName&img=$row->Foto") ?>" class="btn btn-danger btn-sm btn-hapus" title="Hapus data"><i class="fa fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- modal detail -->
<div id="modal-detail" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-info"></i> Detail User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<!-- modal detail -->
<iframe id="iframe-detail" width="100%" height="100%" src="" frameborder="0"></iframe>

<script>
    $(document).ready(function() {
        $('.btn-hapus').on('click', function(e) {
            e.preventDefault();
            var href = $(this).attr('href');
            Swal.fire({
                title: 'Apakah anda yakin menghapus data ini?',
                text: "Data yang dihapus tidak dapat dipulihkan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location = href
                }
            })
        })

        $('#modal-detail').on('show.coreui.modal', function(event) {
            var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
            var modal = $(this)
            // Isi nilai pada field
            var id = div.data('id');
            $.ajax({
                type: "GET",
                url: "<?= base_url('admin/user/detail') ?>",
                data: {
                    UserName: id
                },
                dataType: 'JSON',
                success: function(res) {
                    var text = `
                    <div class="row">
                        <div class="col-sm-3">
                            <img class="img-fluid" id="img" src="${base_url}/assets/admin/img/users/${res.Foto}">
                        </div>
                        <div class="col-sm-9">
                            <table class="table table-sm table-borderless">
                                <tr>   
                                    <td>NIK</td>
                                    <td>:</td>
                                    <td>${res.NIK}</td>
                                </tr>           
                                <tr>   
                                    <td width="120">UserName</td>
                                    <td width="30">:</td>
                                    <td>${res.UserName}</td>
                                </tr>                            
                                <tr>   
                                    <td>Nama</td>
                                    <td>:</td>
                                    <td>${res.NamaUser}</td>
                                </tr>           
                                <tr>   
                                    <td>Alamat</td>
                                    <td>:</td>
                                    <td>${res.Alamat}</td>
                                </tr>           
                                <tr>   
                                    <td>TTL</td>
                                    <td>:</td>
                                    <td>${res.TempatLahir}, ${res.TglLahir}</td>
                                </tr>           
                                <tr>   
                                    <td>Password</td>
                                    <td>:</td>
                                    <td>${res.Password}</td>
                                </tr>           
                            </table>                 
                        </div>
                    </div>
                    `

                    modal.find('.modal-body').html(text);
                }
            });
        });
    });
</script>