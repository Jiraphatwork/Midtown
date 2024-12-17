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
                                    <h2 class="text-center mb-4">แก้ไขข้อมูลลูกค้า(Agent)</h2>
                                    <div class="shadow-lg p-4 bg-body-tertiary rounded">
                                        <form action="{{ route('agent_customer.update', $item->id) }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            @method('POST')

                                            <div class="mb-3">
                                                <label for="name" class="form-label">ชื่อ</label>
                                                <input type="text" class="form-control" id="name" name="name"
                                                    value="{{ old('name', $item->name) }}" placeholder="กรอกชื่อ"
                                                    required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="email" class="form-label">อีเมล</label>
                                                <input type="email" class="form-control" id="email" name="email"
                                                    value="{{ old('email', $item->email) }}" placeholder="กรอกอีเมล"
                                                    required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="business_card" class="form-label">ใบประกอบกิจการ</label>
                                                @if ($item->business_card)
                                                    <div class="mb-2">
                                                        <img src="{{ asset('business_cards/' . $item->business_card) }}"
                                                            alt="Business Card" width="150">
                                                    </div>
                                                @endif
                                                <input type="file" class="form-control" id="business_card"
                                                    name="business_card" accept="image/*">
                                                <small class="text-muted">* หากไม่ต้องการเปลี่ยนไฟล์
                                                    ไม่ต้องเลือกไฟล์</small>
                                            </div>

                                            <div class="mb-3">
                                                <label for="tax_card"
                                                    class="form-label">ใบทะเบียนภาษีมูลค่าเพิ่ม</label>
                                                @if ($item->tax_card)
                                                    <div class="mb-2">
                                                        <img src="{{ asset('tax_cards/' . $item->tax_card) }}"
                                                            alt="Tax Card" width="150">
                                                    </div>
                                                @endif
                                                <input type="file" class="form-control" id="tax_card"
                                                    name="tax_card" accept="image/*">
                                                <small class="text-muted">* หากไม่ต้องการเปลี่ยนไฟล์
                                                    ไม่ต้องเลือกไฟล์</small>
                                            </div>

                                            <div class="mb-3">
                                                <label for="pic_id_card" class="form-label">รูปบัตรประชาชน</label>
                                                @if ($item->pic_id_card)
                                                    <div class="mb-2">
                                                        <img src="{{ asset('pic_id_cards/' . $item->pic_id_card) }}"
                                                            alt="ID Card" width="150">
                                                    </div>
                                                @endif
                                                <input type="file" class="form-control" id="pic_id_card"
                                                    name="pic_id_card" accept="image/*">
                                                <small class="text-muted">* หากไม่ต้องการเปลี่ยนไฟล์
                                                    ไม่ต้องเลือกไฟล์</small>
                                            </div>

                                            <div class="mb-3">
                                                <label for="id_card" class="form-label">รหัสบัตรประชาชน</label>
                                                <input type="text" class="form-control" id="id_card"
                                                    name="id_card" value="{{ old('id_card', $item->id_card) }}"
                                                    placeholder="กรอกเลขบัตรประชาชน" maxlength="13" required
                                                    oninput="updateLength()" onblur="validateTaxId()">
                                                <span id="charCount" class="text-muted"></span>
                                            </div>

                                            <div class="mb-3">
                                                <label for="address" class="form-label">ที่อยู่ 1</label>
                                                <textarea class="form-control" id="address" name="address" rows="2" placeholder="กรอกที่อยู่ 1" required>{{ old('address', $item->address) }}</textarea>
                                            </div>

                                            <div class="mb-3">
                                                <label for="address2" class="form-label">ที่อยู่ 2</label>
                                                <textarea class="form-control" id="address2" name="address2" rows="2" placeholder="กรอกที่อยู่ 2">{{ old('address2', $item->address2) }}</textarea>
                                            </div>

                                            <div class="mb-3">
                                                <label for="address3" class="form-label">ที่อยู่ 3</label>
                                                <textarea class="form-control" id="address3" name="address3" rows="2" placeholder="กรอกที่อยู่ 3">{{ old('address3', $item->address3) }}</textarea>
                                            </div>

                                            <div class="mb-3">
                                                <label for="tel" class="form-label">เบอร์โทร</label>
                                                <input type="text" class="form-control" id="tel"
                                                    name="tel" value="{{ old('tel', $item->tel) }}"
                                                    placeholder="กรอกเบอร์โทร"maxlength="10"
                                                    oninput="updateLengthTel()" onblur="validateTel()">
                                                <span id="charCountTel" class="text-muted"></span>
                                            </div>

                                            <div class="mb-3">
                                                <label for="fax" class="form-label">เบอร์แฟกซ์</label>
                                                <input type="text" class="form-control" id="fax" name="fax"
                                                    value="{{ old('fax', $item->fax) }}"
                                                    placeholder="กรอกเบอร์แฟกซ์"maxlength="10"
                                                    oninput="updateLengthFax()" onblur="validateFax()">
                                                <span id="charCountFax" class="text-muted"></span>
                                            </div>

                                            <div class="mb-3">
                                                <label for="tel2" class="form-label">ตัวแทนติดต่อ</label>
                                                <input type="text" class="form-control" id="tel2"
                                                    name="tel2" value="{{ old('tel2', $item->tel2) }}"
                                                    placeholder="กรอกตัวแทนติดต่อ" maxlength="10"
                                                    oninput="updateLengthTel2()" onblur="validateTel2()">
                                                <span id="charCountTel2" class="text-muted"></span>
                                            </div>
                                            <div class="mb-3">
                                                <label for="tax_id" class="form-label">เลขผู้เสียภาษี</label>
                                                <input type="text" class="form-control" id="tax_id"
                                                    name="tax_id" value="{{ old('tax_id', $item->tax_id) }}"
                                                    placeholder="กรอกเลขผู้เสียภาษี" maxlength="13"
                                                    oninput="updateLengthTaxId()" onblur="validateTaxId()">
                                                <span id="charCountTaxId" class="text-muted"></span>
                                                @error('tax_id')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="slip_card" class="form-label">ใบหัก ณ ที่จ่าย</label>
                                                @if ($item->slip_card)
                                                    <div class="mb-2">
                                                        <img src="{{ asset('slip_cards/' . $item->slip_card) }}"
                                                            alt="Slip Card" width="150">
                                                    </div>
                                                @endif
                                                <input type="file" class="form-control" id="slip_card"
                                                    name="slip_card" accept="image/*">
                                                <small class="text-muted">* หากไม่ต้องการเปลี่ยนไฟล์
                                                    ไม่ต้องเลือกไฟล์</small>
                                            </div>

                                           <!-- ปุ่มบันทึกข้อมูล -->
                                           <div class="text-center mt-4">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa-solid fa-save"></i> บันทึก
                                            </button>
                                            
                                          <a href="{{ route('agent_customer.index') }}" class="btn btn-secondary">
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
    function updateLength() {
        var input = document.getElementById('id_card');
        var charCount = document.getElementById('charCount');
        charCount.textContent = `กรอกไปแล้ว ${input.value.length}/13 ตัวอักษร`;
    }

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

    // ฟังก์ชันสำหรับแสดงจำนวนตัวอักษรที่กรอกไปแล้ว (tel2)
    function updateLengthTel2() {
        var input = document.getElementById('tel2');
        var charCount = document.getElementById('charCountTel2');
        charCount.textContent = `กรอกไปแล้ว ${input.value.length}/10 ตัวอักษร`;
    }

    // ฟังก์ชันตรวจสอบเบอร์โทรตัวแทนติดต่อ
    function validateTel2() {
        var tel2 = document.getElementById('tel2');
        var validTel = /^[0-9]{10}$/; // ตรวจสอบว่าเบอร์โทรตัวแทนติดต่อเป็นตัวเลข 10 หลัก
        var charCount = document.getElementById('charCountTel2');

        // แสดงจำนวนตัวอักษรที่กรอกไปแล้ว
        updateLengthTel2();

        // ตรวจสอบว่าเบอร์โทรตัวแทนติดต่อเป็นไปตามรูปแบบที่กำหนดหรือไม่
        if (!validTel.test(tel2.value)) {
            tel2.setCustomValidity("กรุณากรอกเบอร์โทรตัวแทนติดต่อที่ถูกต้อง (10 หลัก)");
        } else {
            tel2.setCustomValidity(""); // รีเซ็ตข้อความ error
        }
    }

    // ฟังก์ชันสำหรับแสดงจำนวนตัวอักษรที่กรอกไปแล้ว (tax_id)
    function updateLengthTaxId() {
        var input = document.getElementById('tax_id');
        var charCount = document.getElementById('charCountTaxId');
        charCount.textContent = `กรอกไปแล้ว ${input.value.length}/13 ตัวอักษร`;
    }


    // ฟังก์ชันสำหรับแสดงจำนวนตัวอักษรที่กรอกไปแล้ว (tax_id)
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

         // ฟังก์ชันสำหรับแสดงจำนวนที่กรอกไปแล้ว
         function updateLengthFax() {
        var input = document.getElementById('fax');
        var charCount = document.getElementById('charCountFax');
        charCount.textContent = `กรอกไปแล้ว ${input.value.length}/10 ตัวอักษร`;
    }

    // ฟังก์ชันตรวจสอบเบอร์แฟกซ์
    function validateFax() {
        var Fax = document.getElementById('fax');
        var validTel = /^[0-9]{10}$/; 
        var charCount = document.getElementById('charCountFax');

        // แสดงจำนวนตัวอักษรที่กรอกไปแล้ว
        updateLengthTel();

        // ตรวจสอบว่าเบอร์โทรเป็นไปตามรูปแบบที่กำหนดหรือไม่
        if (!validTel.test(fax.value)) {
            fax.setCustomValidity("กรุณากรอกเบอร์แฟกซ์ที่ถูกต้อง (10 หลัก)");
        } else {
            fax.setCustomValidity(""); // รีเซ็ตข้อความ error
        }
    }
    
</script>
