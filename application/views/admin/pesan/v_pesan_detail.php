<div class="page-title">
    <div class="title_left">
        <h3>
            <a href="javascript:history.back()"><i class="fa fa-arrow-circle-o-left"></i></a>
            Detail Pesan
        </h3>
    </div>

    <div class="title_right">
        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
        </div>
    </div>
</div>

<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_content">
                <div class="row">
                    <!-- CONTENT MAIL -->
                    <div class="col-xs-12">
                        <div class="inbox-body">
                            <div class="mail_heading row">
                                <div class="col-xs-12">
                                    <h4>
                                        <i class="fa fa-user"></i> <?= $data->NamaPengirim ?>
                                        <span class="pull-right">
                                            <small class="date"> <?= date_indo(date('Y-m-d', strtotime($data->Tanggal))) ?></small>
                                        </span>
                                        <br>
                                        <small><i class="fa fa-envelope"></i> <?= $data->Email ?></small>
                                        <br>
                                        <small><i class="fa fa-phone"></i> <?= $data->NoTelepone ?></small>
                                    </h4>
                                </div>
                            </div>
                            <div class="sender-info">
                                
                            </div>
                            <div class="view-mail">
                                <h4>Subjek : <?= $data->Subjek ?></h4>
                                <p><?= $data->IsiPesan ?></p>
                            </div>
                        </div>
                    </div>
                    <!-- /CONTENT MAIL -->
                </div>
            </div>
        </div>
    </div>
</div>