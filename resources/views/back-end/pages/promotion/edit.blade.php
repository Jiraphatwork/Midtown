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
                                    <h2 class="text-center mb-4">แก้ไขข้อมูลอุปกรณ์</h2>
                                    <div class="shadow-lg p-4 bg-body-tertiary rounded">
                                        <form action="{{ route('promotion.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('POST') 
                                            
                                            <div class="mb-3">
                                                <label for="name_promotion" class="form-label">ชื่ออุปกรณ์</label>
                                                <input type="text" class="form-control" id="name_promotion" name="name_promotion" 
                                                    value="{{ old('name_promotion', $item->name_promotion) }}" placeholder="กรอกชื่อโปรโมชั่น" required>
                                            </div>
                                        
                                            <div class="mb-3">
                                                <label for="pic_promotion" class="form-label">ใบประกอบกิจการ</label>
                                                @if ($item->pic_promotion)
                                                    <div class="mb-2">
                                                        <img src="{{ asset('pic_promotions/' . $item->pic_promotion) }}" alt="Business Card" width="150">
                                                    </div>
                                                @endif
                                                <input type="file" class="form-control" id="pic_promotion" name="pic_promotion" accept="image/*">
                                                <small class="text-muted">* หากไม่ต้องการเปลี่ยนไฟล์ ไม่ต้องเลือกไฟล์</small>
                                            </div>
                                        
                                            <div class="mb-3">
                                                <label for="detail" class="form-label">รายละเอียด</label>
                                                <input type="text" class="form-control" id="detail" name="detail" 
                                                    value="{{ old('detail', $item->detail) }}" placeholder="กรอกรายละเอียด" required>
                                            </div>
                                        
                                            <div class="mb-3">
                                                <label for="first_date" class="form-label">วันเริ่มต้น</label>
                                                <input type="date" class="form-control" id="first_date" name="first_date" 
                                                    value="{{ old('first_date', $item->first_date) }}" placeholder="วันเริ่มต้น" required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="last_date" class="form-label">วันสิ้นสุด</label>
                                                <input type="date" class="form-control" id="last_date" name="last_date" 
                                                    value="{{ old('last_date', $item->last_date) }}" placeholder="วันสิ้นสุด" required>
                                            </div>
                                        
                                            <div class="text-center">
                                                <button type="submit" class="btn btn-primary">บันทึก</button>
                                                <a href="{{ route('promotion.index') }}" class="btn btn-secondary">ยกเลิก</a>
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
