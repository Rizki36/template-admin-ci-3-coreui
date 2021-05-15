<?php if ($msg = $this->session->flashdata('msg')) : ?>
    <script>
        const msg = <?= json_encode($msg); ?>;

        Swal.fire({
            title: msg.title,
            icon: msg.icon,
            text: msg.text
        })
    </script>
<?php endif ?>