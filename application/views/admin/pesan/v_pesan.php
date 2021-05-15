<h3 class="mb-4"><i class="fa fa-envelope"></i> Pesan </h3>

<div class="card">
    <div class="card-body">
        <ul class="list-group">
            <?php if (count($data) > 0) : ?>
                <?php foreach ($data as $row) : ?>
                    <li class="list-group-item flex-column align-items-start" href="#">
                        <?php if ((int)$row->IsDibaca === 0) : ?>
                            <span class="badge badge-primary badge-pill d-inline-block" style="position: static;">Pesan baru</span>
                        <?php endif ?>
                        <div class="d-flex w-100 align-items-center">
                            <h5 class="mb-1 text-dot" style="cursor: pointer;" data-id="<?= base64_encode($row->KodeKontak) ?>" data-toggle="modal" data-target="#modal-detail" data-judul="<?= $row->Subjek ?>" data-tgl="<?= date_indo(date('Y-m-d', strtotime($row->Tanggal))) ?>" data-pesan="<?= $row->IsiPesan ?>" data-pengirim="<?= $row->NamaPengirim ?> | <?= $row->Email ?> | <?= $row->NoTelepone ?>">
                                <?= $row->Subjek ?>
                            </h5>
                            <small class="text-muted ml-auto pl-3" style="min-width: 100px;"><?= date_indo(date('Y-m-d', strtotime($row->Tanggal))) ?></small>
                        </div>
                        <p class="mb-1 text-dot">
                            <?= $row->IsiPesan ?>
                        </p>
                        <small class="text-muted d-block mb-1"><?= $row->NamaPengirim ?> | <?= $row->Email ?> | <?= $row->NoTelepone ?></small>
                        <button class="btn btn-sm btn-ghost-secondary"><i class="fa fa-trash"></i> &nbsp;Hapus</button>
                    </li>
                <?php endforeach ?>
            <?php else : ?>
                <a class="list-group-item list-group-item-action flex-column align-items-start pesan-active" style="" href="#">
                    <p>Tidak ada data pesan</p>
                </a>
            <?php endif ?>
        </ul>
    </div>
</div>


<!-- modal detail -->
<div id="modal-detail" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-info"></i> Detail Pesan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="flex-column align-items-start">
                    <div class="d-flex w-100 align-items-center">
                        <h3 id="modal-detail-judul" class="mb-3"></h3>
                        <small id="modal-detail-tgl" class="text-muted ml-auto pl-3" style="min-width: 100px;"></small>
                    </div>
                    <p id="modal-detail-pesan" class="mb-1"></p>
                    <small id="modal-detail-pengirim" class="text-muted d-block mb-1"></small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<!-- modal detail -->

<script>
    $(document).ready(function() {
        $('#modal-detail').on('show.coreui.modal', function(event) {
            var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
            var modal = $(this)
            // Isi nilai pada field
            var id = div.data('id');
            $.ajax({
                type: "GET",
                url: "<?= base_url('admin/pesan/detail') ?>",
                data: {
                    id: id
                },
                dataType: "json",
                success: function(response) {
                    div.closest('.list-group-item').children('.badge').remove(); // Hapus badge pesan baru
                    console.log(div.data('id'))
                    $('#modal-detail-judul').text(div.data('judul'))
                    $('#modal-detail-tgl').html(div.data('tgl'))
                    $('#modal-detail-pesan').html(div.data('pesan'))
                    $('#modal-detail-pengirim').html(div.data('pengirim'))
                }
            });
        });
    });
</script>