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
                                    <h2 class="text-center mb-4">แก้ไขข้อมูลการจอง</h2>
                                    <div class="shadow-lg p-4 bg-body-tertiary rounded">
                                        <form action="{{ route('reserve_history.update', $history->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('POST')

                                            <div class="mb-3">
                                                <label for="name" class="form-label">ชื่อ-นามสกุล</label>
                                                <input type="text" class="form-control" id="name" name="name"
                                                    value="{{ old('name', $history->name) }}" required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="now_date" class="form-label">วันที่จ่ายเงิน</label>
                                                <input type="date" class="form-control" id="now_date"
                                                    name="now_date"
                                                    value="{{ old('now_date', \Carbon\Carbon::parse($history->now_date)->format('Y-m-d')) }}"
                                                    required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="first_date" class="form-label">วันแรก</label>
                                                <input type="date" class="form-control" id="first_date"
                                                    name="first_date"
                                                    value="{{ old('first_date', \Carbon\Carbon::parse($history->first_date)->format('Y-m-d')) }}"
                                                    required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="last_date" class="form-label">วันสุดท้าย</label>
                                                <input type="date" class="form-control" id="last_date"
                                                    name="last_date"
                                                    value="{{ old('last_date', \Carbon\Carbon::parse($history->last_date)->format('Y-m-d')) }}"
                                                    required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="status" class="form-label">สถานะ</label>
                                                <select class="form-select" id="status" name="status" required>
                                                    <option value="จ่ายแล้ว"
                                                        {{ old('status', $history->status) == 'จ่ายแล้ว' ? 'selected' : '' }}>
                                                        จ่ายแล้ว
                                                    </option>
                                                    <option value="ยังไม่จ่าย"
                                                        {{ old('status', $history->status) == 'ยังไม่จ่าย' ? 'selected' : '' }}>
                                                        ยังไม่จ่าย
                                                    </option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label for="product_type" class="form-label">ประเภทสินค้า</label>
                                                <input type="text" class="form-control" id="product_type"
                                                    name="product_type"
                                                    value="{{ old('product_type', $history->product_type) }}" required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="area" class="form-label">พื้นที่</label>
                                                <input type="text" class="form-control" id="area" name="area"
                                                    value="{{ old('area', $history->area) }}" required>
                                            </div>

                                            <div class="text-center">
                                                <button type="submit" class="btn btn-primary">บันทึก</button>
                                                <a href="{{ route('reserve_history.index') }}"
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
