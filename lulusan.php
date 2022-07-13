<?php include('layout/header.php');

if (!isset($_POST)) {
    header("Location:/pin-kw/home.php");
    exit;
}else {
    $_SESSION['smt'] = $_POST['tahun'];
}
// var_dump($_SESSION);


//kalo 2 query [+] lebih ringan
$data = pg_query($conn,"select rp.id_reg_pd, rp.id_pd, rp.id_sms, rp.nipd, rp.mulai_smt , rp.sks_diakui, pd.nm_pd, pd.nik from reg_pd rp join peserta_didik pd on rp.id_pd = pd.id_pd where rp.soft_delete = '0' and pd.soft_delete = '0' and rp.id_jns_keluar is null and id_sms = '".$_SESSION['sms']."'");
$mhs = pg_fetch_all($data);

$data_prodi = pg_query($conn,"
select s.id_sms, s.nm_lemb , jp.nm_jenj_didik 
from sms s 
join ref.jenjang_pendidikan jp on jp.id_jenj_didik = s.id_jenj_didik 
where s.id_sms = '".$_SESSION['sms']."'");
$prodi = pg_fetch_all($data_prodi);

foreach ($prodi as $key => $value) {
    $a_prodi[$value['id_sms']] = $value;
}

foreach ($mhs as $key => $value) {
    $key_mhs[] = $value['id_reg_pd'];
    $a_mhs[$value['id_reg_pd']] = $value;  
}

$data_akm = pg_query($conn,"select id_reg_pd, id_smt, sks_smt, ipk, sks_total from kuliah_mhs km where soft_delete = '0' and id_reg_pd in ('".implode("','",$key_mhs)."') order by km.id_reg_pd , km.id_smt asc");
$akm = pg_fetch_all($data_akm);

foreach ($akm as $key => $value) {
    $a_akm[$value['id_reg_pd']][$value['id_smt']] = $value;
}

foreach ($mhs as $key => $value) {
    $a_mhs[$value['id_reg_pd']] = $value;
    $mhs_id[] = $value['id_reg_pd'];
    foreach ($a_akm as $k => $v) {
        $a_mhs[$k]['smt_terakhir'] = max(array_keys($v));
        $a_mhs[$k]['total_sks'] = $v[max(array_keys($v))]['sks_total'];
        $a_mhs[$k]['ipk_terakhir'] = $v[max(array_keys($v))]['ipk'];
        $a_mhs[$k]['akm'] = $v;
    }
}

$jenj_aturan = array(
    "S1" => '2',
    "D1" => '2',
    "D2" => '2',
    "D3" => '2',
    "D4" => '2',
    "S3" => '3',
    "S2" => '3',    
);

$tempuh_aturan = array(
    "D1" => '12',
    "D2" => '48',
    "D3" => '84',
    "D4" => '120',
    "S1" => '120',
    "S2" => '12',    
    "S3" => '18',
);

$max_lulus = array(
    "D1" => '1',
    "D2" => '2',
    "D3" => '4',
    "D4" => '6',
    "S1" => '3',
    "S2" => '3',    
    "S3" => '3',
);


//ini kalo 1 query

// $data = pg_query($conn,"
// select rp.id_reg_pd, pd.nm_pd, max(km.sks_total) as sks_total, max(km.sks_smt) as sks_smt , count(km.id_reg_pd) as total_smt , km.ipk, s.nm_lemb , jp.nm_jenj_didik from reg_pd rp 
// join kuliah_mhs km on rp.id_reg_pd = km.id_reg_pd
// join peserta_didik pd on rp.id_pd = pd.id_pd
// join sms s using(id_sms)
// join ref.jenjang_pendidikan jp on jp.id_jenj_didik = s.id_jenj_didik
// where km.soft_delete = 0 and rp.soft_delete = 0
// group by rp.id_reg_pd , pd.nm_pd , s.nm_lemb , jp.nm_jenj_didik ,km.ipk ,km.last_update 
// order by km.last_update desc ");
// $mhs = pg_fetch_all($data);

foreach ($a_mhs as $key => $value) {
    if ((int)$max_lulus[$a_prodi[$value['id_sms']]['nm_jenj_didik']] > count($value['akm'])) {
        $a_tdk_eli[] = $key;
        $tdk_eli[$key]['alasan'][] = "Masa studi tidak memenuhi ketentuan";
    }
    foreach ($value['akm'] as $k => $v) {
        if ((int)$v['sks_smt'] > 24) {
            $tdk_eli[$key]['alasan'][] = "SKS Lebih dari 24";
            $a_tdk_eli[] = $key;
        }
        if (strpos((string)$k,'3')) {
            if ((int)$v['sks_smt'] > 9) {
                $tdk_eli[$key]['alasan'][] = "SKS Pada Semester Pendek Melebihi 9";
                $a_tdk_eli[] = $key;
            }
        }    
    }
    if (!is_numeric($value['nik'])) {
        $tdk_eli[$key]['alasan'][] = "Nomor NIK tidak sesuai format";
        $a_tdk_eli[] = $key;
    }elseif (strlen($value['nik']) != 16) {
        $tdk_eli[$key]['alasan'][] = "Nomor NIK tidak sesuai format";
        $a_tdk_eli[] = $key;
    }elseif (strlen($value['nik']) == 0) {
        $tdk_eli[$key]['alasan'][] = "Nomor NIK pada PDDikti kosong";
        $a_tdk_eli[] = $key;
    }
    if ((int)$jenj_aturan[$a_prodi[$value['id_sms']]['nm_jenj_didik']] > (int)$value['ipk_terakhir'] ) {
        $tdk_eli[$key]['alasan'][] = "IPK tidak memenuhi ketentuan";
        $a_tdk_eli[] = $key;
    }
    if ((int)$tempuh_aturan[$a_prodi[$value['id_sms']]['nm_jenj_didik']] > ((int)$value['total_sks'] + (int)$value['sks_diakui'])) {
        $tdk_eli[$key]['alasan'][] = "SKS Total tidak memenuhi ketentuan";
        $a_tdk_eli[] = $key;
    }
}

// foreach ($a_mhs as $key => $value) {
//     if (in_array($key,$a_tdk_eli)) {
//         echo '<pre>';
//         print_r($value);
//         echo '</pre>';
//     }
// }


?>
<div class="wrapper wrapper-content gray-bg">
    <div class="container" style="font-size:150%">

        <div class="row">
            <div class="col-lg-12 text-center">
                <a href="https://pin.kemdikbud.go.id/pin/index.php/prodi/" class="btn btn-info"
                    style="font-size:100%">1. Pilih Program Studi</a>
                <a href="https://pin.kemdikbud.go.id/pin/index.php/form/" class="btn btn-info" style="font-size:100%">2.
                    Pilih Tahun Ijazah</a>
                <a href="https://pin.kemdikbud.go.id/pin/index.php/lulusan/" class="btn btn-primary"
                    style="font-size:100%">3. Periksa Daftar Calon Lulusan</a>
                <button class="btn btn-default disabled" style="font-size:100%">4. Daftar Nomor Ijazah</button>
                <button class="btn btn-default disabled" style="font-size:100%">5. Selesai</button>
            </div>
        </div>
        <div class="wrapper container wrapper-content animated fadeInRight gray-bg">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h2>
                                <strong>Periksa Daftar Lulusan Prodi <?= $_POST['namaProdi'] ?></strong>
                            </h2>
                            <a href="https://pin.kemdikbud.go.id/pin/index.php/lulusan/?refresh=1"
                                class="btn btn-success">REFRESH DATA</a>
                            <div class="modal inmodal" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content animated bounceInRight">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span
                                                    aria-hidden="true">&times;</span><span
                                                    class="sr-only">Close</span></button>
                                            <i class="fa fa-search modal-icon"></i>
                                            <h4 class="modal-title">Periksa Status Calon Lulusan</h4>
                                            <small class="font-bold"></small>
                                        </div>
                                        <div class="modal-body text-center">
                                            <form role="form" class="form-inline">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail2" class="sr-only">NIM</label>
                                                    <input type="email" placeholder="Masukan NIM"
                                                        id="exampleInputEmail2" class="form-control" required="">
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail2" class="sr-only">Nama</label>
                                                    <input type="email" placeholder="Masukan Nama"
                                                        id="exampleInputEmail2" class="form-control" required="">
                                                </div>
                                                <button class="btn btn-primary" type="submit">Cari</button>
                                            </form>
                                            <br>
                                            <br>
                                            <br>
                                            <div class="alert alert-info text-left">
                                                <h3>Hasil :</h3>
                                                <p>Tidak lulus karena</p>
                                            </div>

                                        </div>
                                        <div class="modal-footer">

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="ibox-tools">

                            </div>
                        </div>
                        <div class="ibox-content">



                            <div class="alert alert-warning">
                                <h2><strong>Perhatian</strong></h2>
                                <ol>
                                    <li> Periksa seluruh Nama, NIM, dan Jumlah SKS calon lulusan yang tertera pada tabel
                                        "Daftar
                                        Mahasiswa Eligible";</li>
                                    <li>Jika calon lulusan Anda tidak tertera pada tabel lulusan, segera kontak
                                        Perguruan Tinggi
                                        atau Kopertis Wilayah Anda;</li>
                                    <li>Apabila calon lulusan telah pernah diproses pada batch sebelumnya maka anda
                                        dapat
                                        melihat informasi tersebut pada menu "<b>Arsip</b>"; dan</li>
                                    <li>Calon lulusan yang tidak memenuhi syarat dapat dicek pada table "Daftar
                                        Mahasiswa yang
                                        tidak Eligible" , silahkan cek kembali data yang telah dilaporkan pada PD-DIKTI
                                        <!--<br>3. Untuk mengetahui status calon lulusan Anda, klik tombol <a class="btn btn-info" data-toggle="modal" data-target="#myModal">Periksa Status Calon Lulusan</a>-->.
                                    </li>
                                </ol>
                            </div>
                            <div class="alert alert-warning">
                                <h2><strong>Langkah-langkah</strong></h2>
                                <ol>
                                    <li>Pilih calon lulusan yang akan mendapatkan PIN dengan mencentang box yang telah
                                        disediakan, dan diakhiri dengan menekan tombol "<b>Proses Nomor Ijazah</b>" yang
                                        terdapat pada
                                        bagian bawah daftar calon lulusan; dan</li>
                                    <li>Unduh berkas mahasiswa dan Nomor Ijazah yang sudah direservasi PIN pada menu
                                        Arsip.</li>
                                </ol>
                            </div>
                            <div class="text-center">

                                <div class="modal inmodal" id="modalUnggah" tabindex="-1" role="dialog"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content animated bounceInRight">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"><span
                                                        aria-hidden="true">&times;</span><span
                                                        class="sr-only">Close</span></button>
                                                <i class="fa fa-upload modal-icon"></i>
                                                <h4 class="modal-title">Unggah Calon Lulusan</h4>
                                                <small class="font-bold"></small>
                                            </div>
                                            <div class="modal-body text-center">
                                                <form action="https://pin.kemdikbud.go.id/pin/lulusan/do_upload"
                                                    class="form-inline text-center" enctype="multipart/form-data"
                                                    method="post" accept-charset="utf-8">

                                                    <input type="hidden" name="kodeProdi" value="44201">

                                                    <div class="form-group">
                                                        <label class="sr-only">File</label>
                                                        <input type="file" name="userfile" class="form-control"
                                                            required="">
                                                    </div>

                                                    <button class="btn btn-primary" type="submit">Unggah</button>
                                                </form>


                                            </div>
                                            <div class="modal-footer">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <form id="form_lulusan" role="form" method="POST"
                                action="/pin-kw/generate"><br><br>
                                <h2>DAFTAR MAHASISWA ELIGIBLE</h2>
                                <HR>
                                <div class="table-responsive">
                                    <table id="example" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" name="select_all" value="1"
                                                        id="example-select-all" checked></th>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>NIM</th>
                                                <th>SKS</th>
                                                <th>IPK</th>
                                                <th>ALASAN</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $no = 1;
                                            foreach ($a_mhs as $key => $value) {
                                                if (!in_array($key,$a_tdk_eli)) {
                                                    ?>
                                                    <tr>
                                                        <td><input type="checkbox" name="select_all" value="1"
                                                            id="example-select-all"></td>
                                                        <td><?= $no++ ?></td>
                                                        <td><?= $value['nm_pd'] ?></td>
                                                        <td><?= $value['nipd'] ?></td>
                                                        <td><?= (int)$value['sks_diakui'] + (int)$value['total_sks'] ?></td>
                                                        <td><?= $value['ipk_terakhir'] ?></td>
                                                        <td> OK </td>
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Tandai</th>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>NIM</th>
                                                <th>SKS</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                                <div class="alert alert-info">
                                          <center>
                                                <input type="hidden" name="ci_csrf_token" value="">
                                                <input type="hidden" name="action" value="1">
                                                <input type="hidden" name="tahun" value="<?=$_SESSION['smt'] ?>">
                                                <input type="hidden" name="kodeProdi" value="<?=$_SESSION['kode_prodi'] ?>">
                                                <input type="hidden" name="namaProdi" value="<?=$_SESSION['nama_prodi'] ?>">
                                                <input type="hidden" name="jlhLulusan" value="3">
                                                <input type="hidden" name="jlhUncheked" id="jlhUncheked" value="">
                                                <input type="hidden" name="uncheked" id="uncheked" value="">
                                  Dengan ini saya menyatakan bahwa daftar calon lulusan yang tertera pada tabel sudah valid  
                                                    <input class="btn btn-primary btn-rounded text-center" type="submit" value="Proses Nomor Ijazah">                                      
                                 
                                    
                                         
                               </center>
                            </form>

                        </div>
                        <br><br>
                        <h2>DAFTAR MAHASISWA YANG TIDAK ELIGIBLE</h2>
                        <HR>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>NIM</th>
                                        <th>SKS</th>
                                        <th>IPK</th>
                                        <th>ALASAN</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $no = 1;
                                        foreach ($a_mhs as $key => $value) {
                                            if (in_array($key,$a_tdk_eli)) {
                                                ?>
                                                <tr>
                                                    <td><?= $no++ ?></td>
                                                    <td><?= $value['nm_pd'] ?></td>
                                                    <td><?= $value['nipd'] ?></td>
                                                    <td><?= ((int)$value['sks_diakui'] + (int)$value['total_sks']) ?: '0' ?></td>
                                                    <td><?= $value['ipk_terakhir']?: '0' ?></td>
                                                    <td><?php foreach ($tdk_eli[$key] as $k => $v) {?>
                                                            <?= implode(' , ',$v)?>
                                                        <?php } ?></td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Tandai</th>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>NIM</th>
                                        <th>SKS</th>
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
<br>
<?php include('layout/footer.php')?>
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