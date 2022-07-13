<?php 
include('layout/header.php');
?>

<div class="wrapper wrapper-content">
    <div class="container">
        </br></br>
        <div class="row">
            <h1 class="text-center"><strong>Sistem Penomoran Ijazah Nasional</strong></h1>
            <br>
            <div class="alert alert-info" style="font-size:120%">
                Melalui portal ini, Anda dapat melakukan “Reservasi Nomor Ijazah” untuk setiap calon
                lulusan. Untuk calon lulusan yang sudah mereservasi nomor ijazah, Anda dapat melakukan
                pemasangan nomor ijazah dengan NIM calon lulusan pada menu “Pemasangan Nomor Ijazah”.
            </div>

        </div>
        </br></br></br></br>

        <div class="row">
            <div class="col-lg-6">
                <form class="form-inline" role="form" method="POST" action="/pin-kw/core">
                    <input type="hidden" name="action" value="1" />
                    <input type="hidden" name="ci_csrf_token" value=""></input>
                    <button type="submit" class="jumbotron btn btn-lg btn-block btn-primary" style="font-size:130%">
                        <i class="fa fa-plus"></i> <strong> Reservasi Nomor Ijazah </strong>
                    </button>
                </form>
            </div>
            <div class="col-lg-6">
                <form class="form-inline" method="POST" role="form" action="/pin-kw/core">
                    <input type="hidden" name="action" value="2" />
                    <input type="hidden" name="ci_csrf_token" value=""></input>
                    <button type="submit" class="jumbotron btn btn-lg btn-block btn-info" style="font-size:130%">
                        <i class="fa fa-pencil"></i> <strong>Pemasangan Nomor Ijazah</strong>
                    </button>
                </form>
            </div>
            <div class="col-lg-6">
                <form class="form-inline" role="form" method="POST"
                    action="https://pin.kemdikbud.go.id/pin/index.php/historyhome">
                    <input type="hidden" name="action" value="3" />
                    <input type="hidden" name="ci_csrf_token" value=""></input>
                    <button type="submit" class="jumbotron btn btn-lg btn-block btn-success" style="font-size:130%">
                        <i class="fa fa-book"></i> <strong> Arsip + Template</strong>
                    </button>
                </form>
            </div>
            <div class="col-lg-6">
                <form class="form-inline" role="form" method="POST"
                    action="https://pin.kemdikbud.go.id/pin/index.php/carimhs">
                    <input type="hidden" name="action" value="3" />
                    <input type="hidden" name="ci_csrf_token" value=""></input>
                    <button type="submit" class="jumbotron btn btn-lg btn-block btn-warning" style="font-size:130%">
                        <i class="fa fa-search-plus"></i> <strong> Cari Data Mahasiswa</strong>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
<br>

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