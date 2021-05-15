<h3 class="mb-4">
    <a class="text-secondary" href="javascript:history.back()" title="Kembali"><i class="fa fa-arrow-circle-left"></i></a>
    <?= isset($data) ? 'Upate' : 'Tambah' ?> Data User
</h3>


<form class="form" action="<?= base_url('admin/user/simpan') ?>" method="POST" enctype="multipart/form-data">
    <div class="row">
        <div class="col-xs-12 col-sm-4">
            <div class="kv-avatar">
                <div class="file-loading">
                    <input id="avatar-1" name="Foto" type="file" class="" accept=".png,.gif,.jpg,.jpeg,.bmp">
                </div>
            </div>
            <div class="kv-avatar-hint">
                <small>Pilih foto < 1 MB</small>
            </div>
        </div>
        <div class="col-xs-12 col-sm-8">
            <div class="form-group">
                <label>Username</label>
                <input id="UserName" name="UserName" value="<?= @$data->UserName ?>" <?= isset($data) ? 'disabled' : '' ?> type="text" class="form-control" placeholder="Username" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input name="Password" value="<?= base64_decode(@$data->Password) ?>" type="text" class="form-control" placeholder="Password" required>
            </div>
            <div class="form-group">
                <label>NIK</label>
                <input name="NIK" value="<?= @$data->NIK ?>" <?= isset($data) ? 'disabled' : '' ?> type="number" class="form-control" placeholder="NIK" required>
            </div>
            <div class="form-group">
                <label>Nama User</label>
                <input name="NamaUser" value="<?= @$data->NamaUser ?>" type="text" class="form-control" placeholder="Nama User" required>
            </div>
            <div class="form-group">
                <label>Alamat</label>
                <input name="Alamat" value="<?= @$data->Alamat ?>" type="text" class="form-control" placeholder="Alamat">
            </div>
            <div class="form-group">
                <label>Tempat Lahir</label>
                <input name="TempatLahir" value="<?= @$data->TempatLahir ?>" type="text" class="form-control" placeholder="Tempat Lahir">
            </div>
            <div class="form-group">
                <label>Tanggal Lahir</label>
                <input name="TglLahir" value="<?= isset($data) ? date('d-m-Y', strtotime(@$data->TglLahir)) : date('d-m-Y') ?>" type="text" class="form-control datepicker" placeholder="Tanggal Lahir">
            </div>
            <div class="form-group">
                <input name="UserNameLama" value="<?= @$data->UserName ?>" type="hidden">
                <input name="Foto" value="<?= @$data->Foto ?>" type="hidden">
                <a href="javascript:history.back()" class="btn btn-default">Kembali</a>
                <button type="submit" class="pull-right btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</form>

<script>
    var formAction = "<?= isset($data) ? 'edit' : 'tambah' ?>"

    $("#avatar-1").fileinput({
        theme: 'fa',
        overwriteInitial: true,
        maxFileSize: 1000,
        showClose: false,
        showCaption: false,
        browseLabel: '',
        removeLabel: '',
        browseIcon: '<i class="fa fa-folder"></i>',
        removeIcon: '<i class="fa fa-trash"></i>',
        removeTitle: 'Hapus perubahan',
        elErrorContainer: '#kv-avatar-errors-1',
        msgErrorClass: 'alert alert-block alert-danger',
        defaultPreviewContent: '<img src="<?= base_url('assets/admin/img/users/' . (isset($data) ? $data->Foto : 'no-image.jpg')) ?>">',
        layoutTemplates: {
            main2: '{preview} {remove} {browse}'
        }
    });

    var $form = $('form');
    $form.validate({
        ignore: ':hidden:not(.select)',
        errorPlacement: function(error, element) {
            if ($(element).is('select')) {
                element.next().after(error); // special placement for select elements
            } else {
                if (element.parent().hasClass('input-group')) {
                    element.closest('.input-group').after(error)
                } else {
                    element.closest('.form-group').append(error)
                }
            }
        }
    })

    function submit() {
        if ($form.valid()) {
            let timerInterval
            Swal.fire({
                html: 'Mohon Tunggu sebentar..',
                timer: 90000,
                showConfirmButton: false,
                willOpen: () => {
                    $form.submit();
                    Swal.showLoading();
                },
                willClose: () => {
                    clearInterval(timerInterval)
                }
            });
        }
    }

    $('button[type="submit"]').on('click', function(e) {
        e.preventDefault();
        const UserName = $('#UserName').val();
        if (formAction == 'tambah') {
            $.ajax({
                type: "GET",
                url: "<?= base_url('admin/user/cekAdaUserName') ?>",
                data: {
                    UserName: UserName
                },
                dataType: "json",
                success: function(adaUserName) {
                    if (adaUserName) {
                        Swal.fire({
                            icon: 'warning',
                            title: "Username sudah dipakai !",
                            text: "Ganti username lain..."
                        });
                    } else {
                        submit();
                        console.log('submit tambah')
                    }
                }
            });
        } else {
            submit();
            console.log('submit edit')
        }
    })
</script>