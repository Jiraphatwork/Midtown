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
                                    <h2 class="text-center mb-4 text-dark">เพิ่มข้อมูลลูกค้า(องกรณ์)</h2>
                                    <div class="shadow-lg p-4 bg-body-tertiary rounded">
                                        <form action="{{ route('organization_customer.insert') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="name" class="form-label">ชื่อ</label>
                                                <input type="text" class="form-control" id="name" name="name"
                                                    placeholder="กรอกชื่อ-นามสกุล" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="email" class="form-label">อีเมล</label>
                                                <input type="email" class="form-control" id="email" name="email"
                                                    placeholder="กรอกอีเมล" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="business_card" class="form-label">ใบประกอบกิจการ</label>
                                                <input type="file" class="form-control" id="business_card"
                                                    name="business_card" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="address" class="form-label">ที่อยู่ 1</label>
                                                <textarea class="form-control" id="address" name="address" rows="2" placeholder="กรอกที่อยู่ 1" required></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="address2" class="form-label">ที่อยู่ 2</label>
                                                <textarea class="form-control" id="address2" name="address2" rows="2" placeholder="กรอกที่อยู่ 2"></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="address3" class="form-label">ที่อยู่ 3</label>
                                                <textarea class="form-control" id="address3" name="address3" rows="2" placeholder="กรอกที่อยู่ 3"></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="tel" class="form-label">เบอร์โทร</label>
                                                <input type="text" class="form-control" id="tel" name="tel"
                                                    placeholder="กรอกเบอร์โทร" maxlength="10" required
                                                    oninput="validateTel()">
                                                <div id="charCountTel" class="form-text text-muted mt-2">กรอกไปแล้ว 0/10
                                                    ตัวอักษร</div>
                                                @error('tel')
                                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="fax" class="form-label">เบอร์แฟกซ์</label>
                                                <input type="text" class="form-control" id="fax"
                                                    name="fax" placeholder="กรอกเบอร์แฟกซ์">
                                            </div>
                                            <div class="mb-3">
                                                <label for="tel2" class="form-label">ตัวแทนติดต่อ</label>
                                                <input type="text" class="form-control" id="tel2"
                                                    name="tel2" placeholder="กรอกเบอร์ตัวแทนติดต่อ">
                                            </div>
                                            <div class="mb-3">
                                                <label for="tax_id" class="form-label">เลขผู้เสียภาษี</label>
                                                <input type="text" class="form-control" id="tax_id"
                                                    name="tax_id" placeholder="กรอกเลขผู้เสียภาษี" maxlength="13"
                                                    required oninput="validateTaxId()">
                                                <div id="charCountTaxId" class="form-text text-muted mt-2">กรอกไปแล้ว
                                                    0/13 ตัวอักษร</div>
                                                @error('tax_id')
                                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="card_slip" class="form-label">ใบหัก ณ ที่จ่าย</label>
                                                <input type="file" class="form-control" id="card_slip"
                                                    name="card_slip" accept="image/*">
                                            </div>
                                            <div class="text-center">
                                                <button type="submit" class="btn btn-primary">บันทึก</button>
                                                <a href="{{ route('organization_customer.index') }}"
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
    // ฟังก์ชันสำหรับแสดงจำนวนที่กรอกไปแล้ว
    function updateLengthTel() {
        var input = document.getElementById('tel');
        var charCount = document.getElementById('charCountTel');
        charCount.textContent = `กรอกไปแล้ว ${input.value.length}/10 ตัวอักษร`;
    }

    // ฟังก์ชันตรวจสอบเบอร์โทร
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

    // ฟังก์ชันสำหรับแสดงจำนวนที่กรอกไปแล้ว
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
</script>
