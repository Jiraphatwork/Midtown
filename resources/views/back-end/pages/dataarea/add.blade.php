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
                                    <h2 class="text-center mb-4 text-dark">เพิ่มข้อมูลอุปกรณ์</h2>
                                    <div class="shadow-lg p-4 bg-body-tertiary rounded">
                                        <form action="{{ route('dataarea.insert') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <!-- รูปแบบพื้นที่ -->
                                            <div class="mb-3">
                                                <label for="type" class="form-label">รูปแบบพื้นที่</label>
                                                <select class="form-select" id="type" name="type" required>
                                                    <option value="" disabled selected>-- เลือกรูปแบบพื้นที่ --
                                                    </option>
                                                    <option value="รูปแบบที่1">รูปแบบที่1</option>
                                                    <option value="รูปแบบที่2">รูปแบบที่2</option>
                                                    <option value="รูปแบบที่3">รูปแบบที่3</option>
                                                </select>
                                            </div>
                                            <!-- รูปพื้นที่ -->
                                            <div class="mb-3">
                                                <label for="pic_area" class="form-label">รูปพื้นที่</label>
                                                <input type="file" class="form-control" id="pic_area"
                                                    name="pic_area" accept="image/*" required>
                                                <small class="form-text text-muted">กรุณาอัปโหลดไฟล์ภาพ (JPG, PNG,
                                                    GIF)</small>
                                            </div>
                                            <!-- พื้นที่ -->
                                            <div class="mb-3">
                                                <label for="area" class="form-label">พื้นที่</label>
                                                <input type="text" class="form-control" id="area" name="area"
                                                    placeholder="กรอกพื้นที่" required>
                                                @if ($errors->has('area'))
                                                    <div class="text-danger">{{ $errors->first('area') }}</div>
                                                @endif
                                            </div>

                                            <!-- ราคา -->
                                            <div class="mb-3">
                                                <label for="price" class="form-label">ราคา (บาท)</label>
                                                <input type="number" class="form-control" id="price" name="price"
                                                    placeholder="กรอกราคา" min="0" step="0.01" required>
                                            </div>
                                            <!-- ปุ่ม -->
                                             <div class="text-center mt-4">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fa-solid fa-save"></i> บันทึก
                                                </button>
                                                
                                                <a href="{{ route('dataarea.index') }}" class="btn btn-secondary">
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
