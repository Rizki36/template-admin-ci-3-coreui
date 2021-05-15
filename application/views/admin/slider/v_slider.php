        <div class="mb-4 d-flex align-items-center justify-content-between">
            <h3 class="d-inline-block">
                <i class="fa fa-image"></i> <?= $jenisKonten ?>
            </h3>
            <button id="btn-tambah" data-toggle="modal" data-target="#modal-tambah" class="btn btn-sm btn-primary d-inline-flex align-items-center justify-content-center"><i class="c-icon c-icon-sm cil-plus"></i> &nbsp; Tambah Data</button>
        </div>
        <div class="card-deck">
            <?php foreach ($data as $row) : ?>
                <div class="card">
                    <div class="card-header text-dot">
                        <?= $row->JudulKonten ?>
                    </div>
                    <div class="card-body">
                        <img src="<?= base_url('assets/img/slider/thum_' . $row->Gambar1) ?>" class="card-img" style="max-height: 100px; width: 100%;border-radius: 0;object-fit: cover;" alt="...">
                    </div>
                    <div class="card-footer d-flex justify-between">
                        <a class="btn" data-judul="<?= $row->JudulKonten ?>" data-img="<?= base_url('assets/img/slider/' . $row->Gambar1) ?>" data-toggle="modal" data-target="#modal-detail" title="Detail data"><i class="fa fa-eye"></i></a>
                        <a class="btn btn-hapus ml-auto" href="<?= base_url('admin/slider/hapus?id=' . base64_encode($row->KodeKonten) . '&img=' . $row->Gambar1) ?>" title="Hapus data"><i class="fa fa-trash"></i></a>
                    </div>
                </div>
            <?php endforeach ?>
        </div>

        <!-- modal tambah -->
        <form action="<?= base_url('admin/slider/simpan') ?>" method="POST" enctype="multipart/form-data">
            <div id="modal-tambah" class="modal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"><i class="fa fa-info"></i> Tambah Slider</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Gambar Slider</label>
                                <input name="Gambar1" class="file" type="file">
                            </div>
                            <div class="form-group">
                                <label>Judul Slider</label>
                                <input name="JudulKonten" class="form-control" type="text">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!-- modal tambah -->

        <!-- modal detail -->
        <div id="modal-detail" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fa fa-info"></i> &nbsp; Detail Slider</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h3 id="modal-detail-judul"></h3>
                        <img id="modal-detail-gambar1" class="img-fluid" alt="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- modal detail -->

        <script>
            $(document).ready(function() {
                $('#modal-detail').on('show.coreui.modal', function(event) {
                    var div = $(event.relatedTarget)
                    var modal = $(this)
                    modal.find('#modal-detail-judul').html(div.data('judul'));
                    modal.find('#modal-detail-gambar1').attr("src", div.data('img'));
                });

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
            })
        </script>