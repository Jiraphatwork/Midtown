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
                                    <h2 class="text-center mb-4 text-dark">เพิ่มข้อมูลลูกค้า (องค์กร)</h2>
                                    <div class="shadow-lg p-4 bg-body-tertiary rounded">
                                        <form action="{{ route('organization_customer.insert') }}" method="POST"
                                            enctype="multipart/form-data" novalidate>
                                            @csrf

                                            <!-- ชื่อ และ อีเมล -->
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label for="name" class="form-label">ชื่อ</label>
                                                    <input type="text" class="form-control" id="name"
                                                        name="name" placeholder="กรอกชื่อ-นามสกุล" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="email" class="form-label">อีเมล</label>
                                                    <input type="email" class="form-control" id="email"
                                                        name="email" placeholder="กรอกอีเมล" required>
                                                </div>
                                            </div>

                                            <!-- ใบประกอบกิจการ และ ที่อยู่ 1 -->
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label for="business_card" class="form-label">ใบประกอบกิจการ</label>
                                                    <input type="file" class="form-control" id="business_card"
                                                        name="business_card" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="address" class="form-label">ที่อยู่ 1</label>
                                                    <textarea class="form-control" id="address" name="address" rows="2" placeholder="กรอกที่อยู่ 1" required></textarea>
                                                </div>
                                            </div>

                                            <!-- ที่อยู่ 2 และ ที่อยู่ 3 -->
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label for="address2" class="form-label">ที่อยู่ 2</label>
                                                    <textarea class="form-control" id="address2" name="address2" rows="2" placeholder="กรอกที่อยู่ 2"></textarea>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="address3" class="form-label">ที่อยู่ 3</label>
                                                    <textarea class="form-control" id="address3" name="address3" rows="2" placeholder="กรอกที่อยู่ 3"></textarea>
                                                </div>
                                            </div>

                                            <!-- เบอร์โทร และ เบอร์แฟกซ์ -->
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label for="tel" class="form-label">เบอร์โทร</label>
                                                    <input type="text" class="form-control" id="tel"
                                                        name="tel" maxlength="10" placeholder="กรอกเบอร์โทร"
                                                        required oninput="validateTel()">
                                                    <div id="charCountTel" class="form-text text-muted mt-2">กรอกไปแล้ว
                                                        0/10 ตัวอักษร</div>
                                                    @error('tel')
                                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="fax" class="form-label">เบอร์แฟกซ์</label>
                                                    <input type="text" class="form-control" id="fax"
                                                        name="fax" maxlength="10" placeholder="กรอกเบอร์แฟกซ์"
                                                        required oninput="validateFaxId()">
                                                    <div id="charCountfax" class="form-text text-muted mt-2">
                                                        กรอกไปแล้ว 0/10 ตัวอักษร</div>
                                                    @error('fax')
                                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <!-- ตัวแทนติดต่อ และ เลขผู้เสียภาษี -->
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label for="tel2" class="form-label">ตัวแทนติดต่อ</label>
                                                    <input type="text" class="form-control" id="tel2"
                                                        name="tel2" maxlength="10"
                                                        placeholder="กรอกเบอร์โทรตัวแทนติดต่อ" required
                                                        oninput="validateTel2()">
                                                    <div id="charCountTel2" class="form-text text-muted mt-2">
                                                        กรอกไปแล้ว 0/10 ตัวอักษร</div>
                                                    @error('tel2')
                                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="tax_id" class="form-label">เลขผู้เสียภาษี</label>
                                                    <input type="text" class="form-control" id="tax_id"
                                                        name="tax_id" maxlength="13"
                                                        placeholder="กรอกเลขผู้เสียภาษี" required
                                                        oninput="validateTaxId()">
                                                    <div id="charCountTaxId" class="form-text text-muted mt-2">
                                                        กรอกไปแล้ว 0/13 ตัวอักษร</div>
                                                    @error('tax_id')
                                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <!-- ใบหัก ณ ที่จ่าย -->
                                            <div class="mb-3">
                                                <label for="card_slip" class="form-label">ใบหัก ณ ที่จ่าย</label>
                                                <input type="file" class="form-control" id="card_slip"
                                                    name="card_slip" accept="image/*">
                                            </div>

                                            <!-- ปุ่มบันทึก และ ยกเลิก -->
                                            <div class="text-center mt-4">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fa-solid fa-save"></i> บันทึก
                                                </button>
                                                
                                                <a href="{{ route('organization_customer.index') }}" class="btn btn-secondary">
                                                    <i class="fa-solid fa-circle-xmark"></i> ยกเลิก
                                                </a>
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
    // ฟังก์ชันสำหรับแสดงจำนวนที่กรอกไปแล้ว สำหรับ tax_id
    function updateLengthTaxId() {
        var input = document.getElementById('tax_id');
        var charCount = document.getElementById('charCountTaxId');
        charCount.textContent = `กรอกไปแล้ว ${input.value.length}/13 ตัวอักษร`;
    }

    // ฟังก์ชันตรวจสอบเลขผู้เสียภาษี
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

    // ฟังก์ชันสำหรับแสดงจำนวนที่กรอกไปแล้ว สำหรับเบอร์โทร (tel1)
    function updateLengthTel() {
        var input = document.getElementById('tel');
        var charCount = document.getElementById('charCountTel');
        charCount.textContent = `กรอกไปแล้ว ${input.value.length}/10 ตัวอักษร`;
    }

    // ฟังก์ชันตรวจสอบเบอร์โทร (tel1)
    function validateTel() {
        var tel = document.getElementById('tel');
        var validTel = /^[0-9]{10}$/; // ตรวจสอบว่าเบอร์โทรเป็นตัวเลข 10 หลัก
        var charCount = document.getElementById('charCountTel');

        // แสดงจำนวนตัวอักษรที่กรอกไปแล้ว
        updateLengthTel();

        // ตรวจสอบว่าเบอร์โทรเป็นไปตามรูปแบบที่กำหนดหรือไม่
        if (!validTel.test(tel.value)) {
            tel.setCustomValidity("กรุณากรอกเบอร์โทรที่ถูกต้อง (10 หลัก)");
        } else {
            tel.setCustomValidity(""); // รีเซ็ตข้อความ error
        }
    }

    // ฟังก์ชันสำหรับแสดงจำนวนที่กรอกไปแล้ว สำหรับเบอร์โทร (tel2)
    function updateLengthTel2() {
        var input = document.getElementById('tel2');
        var charCount = document.getElementById('charCountTel2');
        charCount.textContent = `กรอกไปแล้ว ${input.value.length}/10 ตัวอักษร`;
    }

    // ฟังก์ชันตรวจสอบเบอร์โทร (tel2)
    function validateTel2() {
        var tel = document.getElementById('tel2');
        var validTel = /^[0-9]{10}$/; // ตรวจสอบว่าเบอร์โทรเป็นตัวเลข 10 หลัก
        var charCount = document.getElementById('charCountTel2');

        // แสดงจำนวนตัวอักษรที่กรอกไปแล้ว
        updateLengthTel2();

        // ตรวจสอบว่าเบอร์โทรเป็นไปตามรูปแบบที่กำหนดหรือไม่
        if (!validTel.test(tel.value)) {
            tel.setCustomValidity("กรุณากรอกเบอร์โทรที่ถูกต้อง (10 หลัก)");
        } else {
            tel.setCustomValidity(""); // รีเซ็ตข้อความ error
        }
    }

    // ฟังก์ชันสำหรับแสดงจำนวนที่กรอกไปแล้ว สำหรับเบอร์แฟกซ์
    function updateLengthFax() {
        var input = document.getElementById('fax');
        var charCount = document.getElementById('charCountfax');
        charCount.textContent = `กรอกไปแล้ว ${input.value.length}/10 ตัวอักษร`;
    }

    // ฟังก์ชันตรวจสอบเบอร์แฟกซ์
    function validateFaxId() {
        var faxId = document.getElementById('fax');
        var validfaxId = /^[0-9]{10}$/; // ตรวจสอบว่าเบอร์แฟกซ์เป็นตัวเลข 10 หลัก
        var charCount = document.getElementById('charCountfax');

        // แสดงจำนวนตัวอักษรที่กรอกไปแล้ว
        updateLengthFax();

        // ตรวจสอบว่าเบอร์แฟกซ์เป็นไปตามรูปแบบที่กำหนดหรือไม่
        if (!validfaxId.test(faxId.value)) {
            faxId.setCustomValidity("กรุณากรอกเบอร์แฟกซ์ที่ถูกต้อง (10 หลัก)");
        } else {
            faxId.setCustomValidity(""); // รีเซ็ตข้อความ error
        }
    }
</script>
