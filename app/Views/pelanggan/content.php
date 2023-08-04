<?php
echo $this->extend('template/index');
echo $this->section('content');
?>
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title"><?php echo $title_card; ?></h3>
            </div>

            <div class="card-body">
                <?php
                if (session()->getFlashdata('success')) { ?>
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                        <h5><i class="icon fas fa-check"></i>Success</h5>
                        <?php echo session()->getFlashdata('success'); ?>
                    </div>
                <?php
                } ?>
                <?php
                if (session()->getFlashdata('error')) { ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                        <h5><i class="fa-solid fa-circle-exclamation"></i> Error</h5>
                        <?php echo session()->getFlashdata('error'); ?>
                    </div>
                <?php
                } ?>
                <a class="btn btn-sm btn-primary" href="<?php echo base_url(); ?>/pelanggan/tambah"><i class="fa-solid fa-plus"></i> Tambah Pelanggan</a>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th style="width: 10px">No</th>
                            <th>Nama Pelanggan</th>
                            <th>Alamat</th>
                            <th>No HP</th>
                            <th>Kode Pos</th>
                            <th>Act</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($data_pelanggan as $r) {
                        ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $r['nama_pelanggan']; ?></td>
                                <td><?php echo $r['alamat']; ?></td>
                                <td><?php echo $r['no_hp']; ?></td>
                                <td><?php echo $r['kode_pos']; ?></td>
                                <td>
                                    <a href="<?php echo base_url(); ?>/pelanggan/edit/<?php echo $r['nama_pelanggan']; ?>" class="btn btn-xs btn-info"><i class="fa-solid fa-edit"></i></a>
                                    <a class="btn btn-xs btn-danger" href="#" onclick="return hapusConfig(<?php echo $r['nama_pelanggan']; ?>);"><i class="fa-solid fa-trash"></i></a>
                                </td>
                            </tr>
                        <?php
                            $no++;
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    function hapusConfig(id) {
        Swal.fire({
            title: 'Yakin Hapus Data ini?',
            text: "Data akan terhapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '<?php echo base_url(); ?>/pelanggan/hapus/' + id;
            }
        })
    }
</script>
<?php
echo $this->endSection();
