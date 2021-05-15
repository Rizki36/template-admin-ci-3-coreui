        <h3 class="mb-4">
            <a class="text-secondary" href="javascript:history.back()" title="Kembali"><i class="fa fa-arrow-circle-left"></i></a>
            Tambah Data <?= $jenisKonten ?>
        </h3>


        <form action="<?= base_url("admin/konten/simpan/$jenisKonten") ?>" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-sm-5">
                    <label style="display: block;">Banner <?= $jenisKonten ?></label>
                    <div class="kv-avatar">
                        <div class="file-loading">
                            <input id="avatar-1" name="Gambar1" accept=".jpg,.jpeg,.png" type="file" class="">
                        </div>
                    </div>
                    <div class="kv-avatar-hint">
                        <small>Pilih foto < 1.5 MB</small>
                    </div>
                </div>
                <div class="col-sm-7">
                    <div class="form-group">
                        <label>Judul <?= $jenisKonten ?></label>
                        <input name="JudulKonten" value="<?= @$data->JudulKonten ?>" type="text" class="form-control" placeholder="Judul <?= $jenisKonten ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Tanggal <?= $jenisKonten ?></label>
                        <input name="TanggalKonten" value="<?= isset($data) ? date('d-m-Y', strtotime($data->TanggalKonten)) : date('d-m-Y') ?>" type="text" class="form-control datepicker" placeholder="Tanggal <?= $jenisKonten ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Isi <?= $jenisKonten ?></label>
                        <textarea name="IsiKonten" id="IsiKonten" class="summernote" rows="20">
                            <?= @$data->IsiKonten ?>
                        </textarea>
                    </div>
                    <div class="form-group">
                        <input name="UserNameLama" value="<?= @$data->UserName ?>" type="hidden">
                        <input name="Gambar1" value="<?= @$data->Gambar1 ?>" type="hidden">
                        <input name="KodeKonten" value="<?= @$data->KodeKonten ?>" type="hidden">
                        <a href="javascript:history.back()" class="btn btn-default">Kembali</a>
                        <button type="submit" class="pull-right btn btn-primary">Kirim</button>
                    </div>
                </div>
            </div>
        </form>


        <script>
            $("#avatar-1").fileinput({
                theme: 'fa',
                overwriteInitial: true,
                maxFileSize: 1500,
                showClose: false,
                showCaption: false,
                browseLabel: '',
                removeLabel: '',
                browseIcon: '<i class="fa fa-folder"></i>',
                removeIcon: '<i class="fa fa-trash"></i>',
                removeTitle: 'Hapus perubahan',
                elErrorContainer: '#kv-avatar-errors-1',
                msgErrorClass: 'alert alert-block alert-danger',
                defaultPreviewContent: '<img src="<?= base_url((isset($data) ? ("assets/img/$jenisKonten/thum_" . $data->Gambar1) : ('assets/img/no-image.png'))) ?>">',
                layoutTemplates: {
                    main2: '{preview} {remove} {browse}'
                },
                allowedFileExtensions: ["jpg", "jpeg", "png"]
            });


            var $form = $('form');
            if ($form.length > 0) {
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
            }

            $form.validate()
        </script>