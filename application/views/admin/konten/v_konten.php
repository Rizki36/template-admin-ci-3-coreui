<h3 class="mb-4"><i class="fa fa-users"></i> &nbsp; <?= ucfirst($jenisKonten) ?></h3>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <form action="<?= base_url("admin/konten/$jenisKonten") ?>">
                    <div class="row align-items-center">
                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="input-group">
                                <input id="v" name="v" value="<?= @$v ?>" type="text" class="form-control" placeholder="Cari judul konten" />
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
                            <a href="<?= base_url("admin/konten/tambah/$jenisKonten") ?>" class="btn btn-sm btn-primary w-100 d-inline-flex align-items-center justify-content-center"><i class="c-icon c-icon-sm cil-plus"></i> &nbsp; Tambah Data</a>
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
                                <th>Judul <?= $jenisKonten ?></th>
                                <th class="text-center">Status</th>
                                <th class="text-center" width="250">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data as $no => $row) : ?>
                                <tr>
                                    <td scope="row"><?= $no + 1 ?></td>
                                    <th><?= $row->JudulKonten ?></th>
                                    <td class="text-center">
                                        <?php $urlSetStatus = base_url("admin/konten/setStatus/$jenisKonten/" . base64_encode($row->KodeKonten)) ?>
                                        <?php if ((int)$row->IsAktif === 1) : ?>
                                            <a href="<?= $urlSetStatus . "/0" ?>" title="Nonaktifkan" type="button" class="btn btn-success btn-sm text-white">Aktif</a>
                                        <?php else : ?>
                                            <a href="<?= $urlSetStatus . "/1" ?>" title="Aktifkan" type="button" class="btn btn-warning btn-sm text-white">Nonaktif</a>
                                        <?php endif ?>
                                    </td>
                                    <td class="text-center">
                                        <a class="btn btn-primary btn-sm text-white" data-slug="<?= $row->Slug ?>" data-toggle="modal" data-target="#modal-detail"><i class="fa fa-eye"></i> Detail </a>
                                        <a href="<?= base_url("admin/konten/edit/$jenisKonten/" . base64_encode($row->KodeKonten)) ?>" class="btn btn-info btn-sm"><i class="fa fa-pencil-alt"></i> Edit </a>
                                        <a href="<?= base_url("admin/konten/hapus/$jenisKonten?id=" . base64_encode($row->KodeKonten) . '&img=' . $row->Gambar1) ?>" class="btn-hapus btn btn-danger btn-sm text-white"><i class="fa fa-trash"></i> Hapus </a>
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
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content" style="width: 90vw !important;height: 90vh !important;">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-info"></i> Detail <?= ucfirst($jenisKonten) ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <iframe id="iframe-detail" width="100%" height="100%" src="" frameborder="0"></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<!-- modal detail -->

<script>
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
        var slug = div.data('slug');
        $('#iframe-detail').attr('src', `${base_url}/blog/detail/${slug}`)
    });
</script>