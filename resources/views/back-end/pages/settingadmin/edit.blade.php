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
                                <div class="container mt-5 d-flex justify-content-center">
                                    <div class="card shadow-sm"
                                        style="width: 40rem; border-radius: 12px; border: none;">
                                        <div class="card-header text-center"
                                            style="background: linear-gradient(135deg, #293038, #2b3032); color: white; padding: 1.5rem;">
                                            <h4 class="mb-0" style="font-size: 1.75rem; font-weight: 600;">
                                                แก้ไขข้อมูลผู้ดูแลระบบ</h4>
                                        </div>
                                        <div class="card-body p-4" style="background-color: #f7f9fc;">
                                            <form action="{{ route('settingadmin.update', $item->id) }}" method="POST">
                                                @csrf
                                                @method('POST')

                                                <!-- ชื่อ -->
                                                <div class="form-group mb-4">
                                                    <label for="name" class="form-label"
                                                        style="font-size: 1rem;">ชื่อ</label>
                                                    <input type="text"
                                                        class="form-control @error('name') is-invalid @enderror"
                                                        id="name" name="name" placeholder="กรอกชื่อ"
                                                        value="{{ old('name', $item->name) }}" required
                                                        style="border-radius: 8px; box-shadow: none;">
                                                    @error('name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <!-- Role -->
                                                <div class="form-group mb-4">
                                                    <label for="role_name" class="form-label"
                                                        style="font-size: 1rem;">Role</label>
                                                    <select class="form-select @error('role_name') is-invalid @enderror"
                                                        id="role_name" name="role_name" required
                                                        style="border-radius: 8px; box-shadow: none;">
                                                        <option value="Admin"
                                                            {{ old('role_name', $item->role_name) == 'Admin' ? 'selected' : '' }}>
                                                            Admin</option>
                                                        <option value="User"
                                                            {{ old('role_name', $item->role_name) == 'User' ? 'selected' : '' }}>
                                                            User</option>
                                                    </select>
                                                    @error('role_name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <!-- ปุ่ม -->
                                                <div class="text-center mt-4">
                                                    <button type="submit" class="btn btn-primary px-4 py-2"
                                                        style="border-radius: 30px; font-weight: 600;">
                                                        <i class="bi bi-save"></i> บันทึก
                                                    </button>
                                                    <a href="{{ route('settingadmin.index') }}"
                                                        class="btn btn-outline-secondary px-4 py-2"
                                                        style="border-radius: 30px; font-weight: 600;">
                                                        <i class="bi bi-x-circle"></i> ยกเลิก
                                                    </a>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>


                            </div>
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
