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
                                    <h2 class="text-center mb-4 text-dark">เพิ่มข้อมูลลูกค้า(Agent)</h2>
                                    <div class="shadow-lg p-4 bg-body-tertiary rounded">
                                        <form action="{{ route('agent_customer.insert') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <!-- ชื่อ-นามสกุล -->
                                            <div class="mb-3">
                                                <label for="name" class="form-label">ชื่อ-นามสกุล</label>
                                                <input type="text" class="form-control" id="name" name="name"
                                                    placeholder="กรอกชื่อ" required>
                                            </div>

                                            <!-- อีเมล -->
                                            <div class="mb-3">
                                                <label for="email" class="form-label">อีเมล</label>
                                                <input type="email" class="form-control" id="email" name="email"
                                                    placeholder="กรอกอีเมล" required>
                                            </div>

                                            <!-- ใบประกอบกิจการ -->
                                            <div class="mb-3">
                                                <label for="business_card" class="form-label">ใบประกอบกิจการ</label>
                                                <input type="file" class="form-control" id="business_card"
                                                    name="business_card">
                                            </div>


                                            <!-- ใบทะเบียนภาษีมูลค่าเพิ่ม -->
                                            <div class="mb-3">
                                                <label for="tax_card"
                                                    class="form-label">ใบทะเบียนภาษีมูลค่าเพิ่ม</label>
                                                <input type="file" class="form-control" id="tax_card"
                                                    name="tax_card">
                                            </div>

                                            <!-- รูปบัตรประชาชน -->
                                            <div class="mb-3">
                                                <label for="pic_id_card" class="form-label">รูปบัตรประชาชน</label>
                                                <input type="file" class="form-control" id="pic_id_card"
                                                    name="pic_id_card" accept="image/*" required>
                                            </div>

                                            <!-- เลขบัตรประชาชน -->
                                            <div class="mb-3">
                                                <label for="id_card" class="form-label">เลขบัตรประชาชน</label>
                                                <input type="text" class="form-control" id="id_card" name="id_card"
                                                    placeholder="กรอกเลขบัตรประชาชน" required>
                                                    @error('id_card')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- ที่อยู่ -->
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

                                            <!-- เบอร์โทร -->
                                            <div class="mb-3">
                                                <label for="tel" class="form-label">เบอร์โทร</label>
                                                <input type="text" class="form-control" id="tel"
                                                    name="tel" placeholder="กรอกเบอร์โทร" required>
                                                    @error('tel')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- เบอร์แฟกซ์ -->
                                            <div class="mb-3">
                                                <label for="fax" class="form-label">เบอร์แฟกซ์</label>
                                                <input type="text" class="form-control" id="fax"
                                                    name="fax" placeholder="กรอกเบอร์แฟกซ์">
                                            </div>

                                            <!-- ตัวแทนติดต่อ -->
                                            <div class="mb-3">
                                                <label for="tel2" class="form-label">ตัวแทนติดต่อ</label>
                                                <input type="text" class="form-control" id="tel2"
                                                    name="tel2" placeholder="กรอกเบอร์ตัวแทนติดต่อ">
                                            </div>


                                            <!-- เลขผู้เสียภาษี -->
                                            <div class="mb-3">
                                                <label for="tax_id" class="form-label">เลขผู้เสียภาษี</label>
                                                <input type="text" class="form-control" id="tax_id"
                                                    name="tax_id" placeholder="กรอกเลขผู้เสียภาษี">
                                                    @error('tax_id')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- ใบ ณ ที่จ่าย -->
                                            <div class="mb-3">
                                                <label for="slip_card" class="form-label">ใบหัก ณ ที่จ่าย</label>
                                                <input type="file" class="form-control" id="slip_card"
                                                    name="slip_card" </div>

                                                <!-- ปุ่มบันทึกข้อมูล -->
                                                <div class="text-center">
                                                    <button type="submit" class="btn btn-primary">บันทึก</button>
                                                    <a href="{{ route('agent_customer.index') }}"
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
