<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    @include("$prefix.layout.head")
</head>
<!--end::Head-->

<!--begin::Body-->

<body id="kt_app_body" data-kt-app-layout="dark-sidebar" data-kt-app-header-fixed="true" data-kt-app-sidebar-enabled="true"
    data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true" data-kt-app-sidebar-push-header="true"
    data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true"
    class="app-default">
    <!--begin::App-->
    <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
        <!--begin::Page-->
        <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
            <!--begin::Header-->
            <div id="kt_app_header" class="app-header" data-kt-sticky="true"
                data-kt-sticky-activate="{default: true, lg: true}" data-kt-sticky-name="app-header-minimize"
                data-kt-sticky-offset="{default: '200px', lg: '0'}" data-kt-sticky-animation="false">
                @include("$prefix.layout.head-menu")
            </div>
            <!--end::Header-->
            <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">

                <!--begin::Sidebar-->
                @include("$prefix.layout.side-menu")
                <!--end::Sidebar-->

                <!--begin::Main-->
                <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                    <!--begin::Content wrapper-->
                    <div class="d-flex flex-column flex-column-fluid">
                        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
                            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">

                                <div class="container mt-5">
                                    <h2 class="text-center mb-4 text-dark">เพิ่มข้อมูลลูกค้า(บุคคล)</h2>
                                    <div class="shadow-lg p-4 bg-body-tertiary rounded">
                                        <form action="{{ route('ordinary_customer.insert') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="name" class="form-label">ชื่อ-นามสกุล</label>
                                                <input type="text" class="form-control" id="name" name="name"
                                                    placeholder="กรอกชื่อ-นามสกุล" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="email" class="form-label">อีเมล</label>
                                                <input type="email" class="form-control" id="email" name="email"
                                                    placeholder="กรอกอีเมล" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="pic_id_card" class="form-label">รูปบัตรประชาชน</label>
                                                <input type="file" class="form-control" id="pic_id_card"
                                                    name="pic_id_card" accept="image/*" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="id_card" class="form-label">เลขบัตรประชาชน</label>
                                                <input type="text" class="form-control" id="id_card" name="id_card"
                                                    placeholder="กรอกเลขบัตรประชาชน" maxlength="13" required
                                                    oninput="updateLengthIdCard()">
                                                <small id="charCount" class="form-text text-muted">กรอกไปแล้ว 0/13
                                                    ตัวอักษร</small>
                                            </div>

                                            <div class="mb-3">
                                                <label for="address" class="form-label">ที่อยู่</label>
                                                <textarea class="form-control" id="address" name="address" rows="3" placeholder="กรอกที่อยู่" required></textarea>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label for="tel" class="form-label">เบอร์โทร</label>
                                                <input type="text" class="form-control" id="tel" name="tel"
                                                    placeholder="กรอกเบอร์โทร" maxlength="10" required
                                                    oninput="updateLengthTel()">
                                                <div id="charCountTel" class="form-text text-muted mt-2">กรอกไปแล้ว 0/10
                                                    ตัวอักษร</div>
                                               
                                            </div>

                                            <div class="mb-3">
                                                <label for="tel2" class="form-label">ตัวแทนติดต่อ</label>
                                                <input type="text" class="form-control" id="tel2"
                                                    name="tel2" placeholder="กรอกเบอร์โทรตัวแทนติดต่อ"
                                                    maxlength="10" required oninput="updateLengthTel2()">
                                                <div id="charCountTel2" class="form-text text-muted mt-2">กรอกไปแล้ว
                                                    0/10 ตัวอักษร</div>             
                                            </div>
                                            <div class="mb-3">
                                                <label for="tax_id" class="form-label">เลขผู้เสียภาษี</label>
                                                <input type="text" class="form-control" id="tax_id"
                                                    name="tax_id" placeholder="กรอกเลขผู้เสียภาษี" maxlength="13"
                                                    required oninput="updateLengthTaxId()">
                                                <div id="charCountTaxId" class="form-text text-muted mt-2">กรอกไปแล้ว
                                                    0/13 ตัวอักษร</div>
                                             
                                            </div>
                                            <div class="text-center">
                                                <button type="submit" class="btn btn-primary">บันทึก</button>
                                                <a href="{{ route('ordinary_customer.index') }}"
                                                    class="btn btn-secondary">ยกเลิก</a>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div id="kt_app_content" class="app-content flex-column-fluid">
                    <!--begin::Content container-->
                    <div id="kt_app_content_container" class="app-container container-xxl">

                    </div>
                    <!--end::Content container-->
                </div>

            </div>
            <!--end::Content wrapper-->

            <!--begin::Footer-->
            <div id="kt_app_footer" class="app-footer">
                @include("$prefix.layout.footer")
            </div>
            <!--End::Footer-->
        </div>
        <!--End::Main-->
    </div>
    </div>
    </div>

    <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
        <i class="ki-duotone ki-arrow-up">
            <span class="path1"></span>
            <span class="path2"></span>
        </i>
    </div>

    <!--begin::Javascript-->
    @include("$prefix.layout.script")
    <!--end::Javascript-->

</body>
<!--end::Body-->

</html>
<script>
    function updateLengthIdCard() {
        var input = document.getElementById('id_card');
        var charCount = document.getElementById('charCount');
        charCount.textContent = `กรอกไปแล้ว ${input.value.length}/13 ตัวอักษร`;
    }

    function updateLengthTel() {
        var input = document.getElementById('tel');
        var charCount = document.getElementById('charCountTel');
        charCount.textContent = `กรอกไปแล้ว ${input.value.length}/10 ตัวอักษร`;
    }

    function updateLengthTel2() {
        var input = document.getElementById('tel2');
        var charCount = document.getElementById('charCountTel2');
        charCount.textContent = `กรอกไปแล้ว ${input.value.length}/10 ตัวอักษร`;
    }

    function updateLengthTaxId() {
        var input = document.getElementById('tax_id');
        var charCount = document.getElementById('charCountTaxId');
        charCount.textContent = `กรอกไปแล้ว ${input.value.length}/13 ตัวอักษร`;
    }

    function validateTel(inputId, charCountId) {
        var tel = document.getElementById(inputId);
        var validTel = /^[0-9]{10}$/; // ตรวจสอบว่าเบอร์โทรเป็นตัวเลข 10 หลัก
        var charCount = document.getElementById(charCountId);

        // แสดงจำนวนตัวอักษรที่กรอกไปแล้ว
        charCount.textContent = `กรอกไปแล้ว ${tel.value.length}/10 ตัวอักษร`;

        // ตรวจสอบว่าเบอร์โทรเป็นไปตามรูปแบบที่กำหนดหรือไม่
        if (!validTel.test(tel.value)) {
            tel.setCustomValidity("กรุณากรอกเบอร์โทรที่ถูกต้อง (10 หลัก)");
        } else {
            tel.setCustomValidity(""); // รีเซ็ตข้อความ error
        }
    }

    function validateTaxId() {
        var taxId = document.getElementById('tax_id');
        var validTaxId = /^[0-9]{13}$/; // ตรวจสอบว่าเลขผู้เสียภาษีเป็นตัวเลข 13 หลัก
        var charCount = document.getElementById('charCountTaxId');

        // แสดงจำนวนตัวอักษรที่กรอกไปแล้ว
        updateLengthTaxId();

        // ตรวจสอบว่าเลขผู้เสียภาษีเป็นไปตามรูปแบบที่กำหนดหรือไม่
        if (!validTaxId.test(taxId.value)) {
            taxId.setCustomValidity("กรุณากรอกเลขผู้เสียภาษีที่ถูกต้อง (13 หลัก)");
        } else {
            taxId.setCustomValidity(""); // รีเซ็ตข้อความ error
        }
    }

    // Call the validation functions for phone and tax id
    document.getElementById('tel').addEventListener('input', function() {
        validateTel('tel', 'charCountTel');
    });

    document.getElementById('tel2').addEventListener('input', function() {
        validateTel('tel2', 'charCountTel2');
    });

    document.getElementById('tax_id').addEventListener('input', function() {
        validateTaxId();
    });
</script>
