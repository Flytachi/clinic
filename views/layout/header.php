<div class="<?= $classes['header'] ?>">
    <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
        <div class="d-flex">
            <div class="breadcrumb">
                <a href="index.php" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
                <span class="breadcrumb-item active"><?= $header ?></span>
            </div>

            <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>

        <div class="header-elements d-none">
            <div class="breadcrumb justify-content-center">
                <a href="" class="breadcrumb-elements-item" class="dropdown-toggle legitRipple" data-toggle="dropdown">
                    <i class="icon-book3 mr-2"></i>
                    ICD
                </a>
                <div class="dropdown-menu dropdown-menu-right content card-body" style="width:500px;">
                
                    <div class="form-group-feedback form-group-feedback-right row">

                        <div class="col-md-12">
                            <input type="text" class="form-control border-pink text-pink wmin-200 mb-2" id="search_input_icd" placeholder="Поиск..." title="Введите название болезни или код">
                            <div class="form-control-feedback">
                                <i class="icon-search4 font-size-base text-muted"></i>
                            </div>
                        </div>

                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover table-sm">
                            <tbody id="icd_result">
                                <tr class="alpha-pink text-center"><td>Справочник</td></tr>
                            </tbody>
                        </table>
                    </div>

                </div>

                <!-- <a href="#" class="breadcrumb-elements-item">
                    <i class="icon-comment-discussion mr-2"></i>
                    Support
                </a>

                <div class="breadcrumb-elements-item dropdown p-0">
                    <a href="#" class="breadcrumb-elements-item dropdown-toggle" data-toggle="dropdown">
                        <i class="icon-gear mr-2"></i>
                        Settings
                    </a>

                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="#" class="dropdown-item"><i class="icon-user-lock"></i> Account security</a>
                        <a href="#" class="dropdown-item"><i class="icon-statistics"></i> Analytics</a>
                        <a href="#" class="dropdown-item"><i class="icon-accessibility"></i> Accessibility</a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item"><i class="icon-gear"></i> All settings</a>
                    </div>
                </div> -->

            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    $("#search_input_icd").keyup(function() {
        $.ajax({
            type: "GET",
            url: "<?= ajax('search/icd') ?>",
            data: {
                search: this.value,
            },
            success: function (result) {
                $('#icd_result').html(result);
            },
        });
    });

</script>
