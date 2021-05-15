<!DOCTYPE html>
<html lang="en">

<head>
    <!-- head -->
    <?php $this->load->view('admin/layout/_head') ?>
    <script>
        var base_url = "<?= base_url('') ?>";
    </script>
    <!-- /head -->
</head>

<body class="c-app">
    <?php $this->load->view('admin/layout/_sidebar') ?>
    <div class="c-wrapper c-fixed-components">
        <!-- header -->
        <?php $this->load->view('admin/layout/_header') ?>
        <!-- /header -->
        <div class="c-body">
            <main class="c-main">
                <div class="container-fluid">
                    <div class="fade-in">
                        <?php $this->load->view(@$view) ?>
                        <?= @$pagination ?>
                    </div>
                </div>
            </main>
            <!-- footer -->
            <?php $this->load->view('admin/layout/_footer') ?>
            <!-- /footer -->
        </div>
    </div>
    <!-- scripts -->
    <?php $this->load->view('admin/layout/_scripts') ?>
    <script>
        $(function() {
            $('.datepicker').datepicker({
                format: 'dd-mm-yyyy',
            });

            $('.summernote').summernote({
                height: 200
            });
        })
    </script>

    <?php $this->load->view('admin/layout/_msg') ?>
    <!-- /scripts -->
</body>

</html>