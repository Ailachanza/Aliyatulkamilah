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

            <form action="<?php echo $action; ?>" method="post">
                <div class="card-body">
                    <?php if (validation_errors()) { ?>
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <h5><i class="icon fas fa-ban"></i>Alert!</h5>
                            <?php echo validation_list_errors(); ?>
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
                    <?php echo csrf_field(); ?>
                    <?php
                    if (current_url(true)->getSegment(2) == 'edit') {
                    ?>
                        <input type="hidden" name="param" id="param" value="<?php echo $edit_data['no_barang']; ?>">
                    <?php
                    }
                    ?>
                    <div class="form-group">
                        <label for="no_barang">No Barang</label>
                        <input type="text" class="form-control" value="<?php echo empty(set_value('no_barang')) ? (empty($edit_data['no_barang']) ? "" : $edit_data['no_barang']) : set_value('no_barang'); ?>" id="no_barang" name="no_barang">
                    </div>
                    <div class="form-group">
                        <label for="nama_barang">Nama Barang</label>
                        <input type="text" class="form-control" value="<?php echo empty(set_value('nama_barang')) ? (empty($edit_data['nama_barang']) ? "" : $edit_data['nama_barang']) : set_value('nama_barang'); ?>" id="nama_barang" name="nama_barang">
                    </div>
                    <div class="form-group">
                        <label for="satuan">Satuan</label>
                        <input type="text" class="form-control" value="<?php echo empty(set_value('satuan')) ? (empty($edit_data['satuan']) ? "" : $edit_data['satuan']) : set_value('satuan'); ?>" id="satuan" name="satuan">
                    </div>
                    <div class="form-group">
                        <label for="harga">Harga</label>
                        <input type="text" class="form-control" value="<?php echo empty(set_value('harga')) ? (empty($edit_data['harga']) ? "" : $edit_data['harga']) : set_value('harga'); ?>" id="harga" name="harga">
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary"><i class="fa-regular fa-floppy-disk"></i> Simpan</button>
                        <a class="btn btn-danger float-right" href="javascript:history.back()"><i class="fa-solid fa-chevron-left"></i> Kembali</a>
                    </div>
                </div>
            </form>

        </div>
    </div>
    <?php
    echo $this->endSection();
