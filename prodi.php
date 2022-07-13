<?php 
include('layout/header.php');
include('config.php');
if (empty($_SESSION['sms'])) {
    header("Location:/pin-kw/home.php");
}
?>

<div class="wrapper wrapper-content gray-bg">
    <div class="container" style="font-size:150%">

        <div class="row">
            <div class="col-lg-12 text-center">
                <a href="https://pin.kemdikbud.go.id/pin/index.php/prodi/" class="btn btn-primary"
                    style="font-size:100%">1. Pilih Program Studi</a>
                <button class="btn btn-default disabled" style="font-size:100%">2. 1Pilih Tahun Ijazah</button>
                <button class="btn btn-default disabled" style="font-size:100%">3. Periksa Daftar Calon Lulusan</button>
                <button class="btn btn-default disabled" style="font-size:100%">4. Daftar Nomor Ijazah</button>
                <button class="btn btn-default disabled" style="font-size:100%">5. Selesai</button> </div>
        </div>
        <div class="wrapper container wrapper-content animated fadeInRight gray-bg">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h2>
                                <strong>Pilih salah satu Program Studi</strong>
                            </h2>
                        </div>
                        <div class="ibox-content">
                            <?php
                                       $data = pg_query($conn,"select id_sms, nm_lemb, nm_jenj_didik , kode_prodi, sks_lulus from sms s join ref.jenjang_pendidikan jp using(id_jenj_didik) where id_sp = (select id_sp from sync.instalasi i limit 1) and id_jns_sms = '3' and stat_prodi = 'A'");
                                       $arr = pg_fetch_all($data);
                            ?>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kode</th>
                                            <th>Nama</th>
                                            <th>Operasi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        foreach ($arr as $key => $value) {
                                        ?>
                                        <tr class="gradeX">
                                            <td><?= $no++ ?></td>
                                            <td><?= $value['kode_prodi'] ?></td>
                                            <td><?= $value['nm_jenj_didik'] ?> <?= $value['nm_lemb'] ?></td>
                                            <td>
                                                <form method="POST"
                                                    action="/pin-kw/form.php/">
                                                    <input type="hidden" name="action" value="1" />
                                                    <input type="hidden" name="kodeProdi" value="<?=$value['kode_prodi']?>" />
                                                    <input type="hidden" name="namaProdi" value="<?= $value['nm_jenj_didik'] ?> <?= $value['nm_lemb'] ?>" />
                                                    <input type="hidden" name="id_sms" value="<?= $value['id_sms'] ?>" />
                                                    <input type="submit" class="btn btn-xs btn-block btn-primary "
                                                        value="Pilih" style="font-size:100%">
                                                </form>
                                            </td>
                                        </tr>
                                        <?php } ?>

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Kode</th>
                                            <th>Nama</th>
                                            <th>Operasi</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>


                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    </body>
    <?php include('layout/footer.php') ?>

    <script>
        $(document).ready(function () {
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
        });
    </script>

    <script>
        $(document).ready(function () {
            $('.dataTables-example').DataTable();
            var table = $('#example').DataTable({
                'columnDefs': [{
                    'targets': 0,
                    'searchable': false,
                    'orderable': false,
                    'className': 'dt-body-center',
                }],
                'order': [
                    [1, 'asc']
                ]
            });
            $('#example-select-all').on('click', function () {
                // Get all rows with search applied
                var rows = table.rows({
                    'search': 'applied'
                }).nodes();
                // Check/uncheck checkboxes for all rows in the table
                $('input[type="checkbox"]', rows).prop('checked', this.checked);
            });
            $('#example tbody').on('change', 'input[type="checkbox"]', function () {
                // If checkbox is not checked
                if (!this.checked) {
                    var el = $('#example-select-all').get(0);
                    // If "Select all" control is checked and has 'indeterminate' property
                    if (el && el.checked && ('indeterminate' in el)) {
                        // Set visual state of "Select all" control
                        // as 'indeterminate'
                        el.indeterminate = true;
                    }
                }
            });
            // Handle form submission event
            $('#form_lulusan').on('submit', function (e) {
                var form = this;

                // Iterate over all checkboxes in the table
                table.$('input[type="checkbox"]').each(function () {
                    // If checkbox doesn't exist in DOM
                    if (!$.contains(document, this)) {
                        // If checkbox is checked
                        if (this.checked) {
                            // Create a hidden element
                            $(form).append(
                                $('<input>')
                                .attr('type', 'hidden')
                                .attr('name', this.name)
                                .val(this.value)
                            );
                        }
                    }
                });
            });

            $('#tabel-isu').DataTable({
                "columns": [
                    null,
                    null,
                    null,
                    null,
                    {
                        "width": "5%"
                    },
                    null,
                    null,
                    null,
                    null
                ]
            });
        });
    </script>
    <script>
        $(document).ready(function () {

            var updateOutput = function (e) {
                var list = e.length ? e : $(e.target),
                    output = list.data('output');
                if (window.JSON) {
                    output.val(window.JSON.stringify(list.nestable('serialize'))); //, null, 2));
                } else {
                    output.val('JSON browser support required for this demo.');
                }
            };
            // activate Nestable for list 1
            $('#nestable').nestable({
                group: 1
            }).on('change', updateOutput);

            // activate Nestable for list 2
            $('#nestable2').nestable({
                group: 1
            }).on('change', updateOutput);

            // output initial serialised data
            updateOutput($('#nestable').data('output', $('#nestable-output')));
            updateOutput($('#nestable2').data('output', $('#nestable2-output')));

            $('#nestable-menu').on('click', function (e) {
                var target = $(e.target),
                    action = target.data('action');
                if (action === 'expand-all') {
                    $('.dd').nestable('expandAll');
                }
                if (action === 'collapse-all') {
                    $('.dd').nestable('collapseAll');
                }
            });
        });
    </script>

    </body>

    </html>