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
            <div class="loading-spinner"></div>
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
                                    <h2 class="text-center mb-4 text-dark">ตั้งค่าสิทธิ์ผู้ใช้งาน</h2>
                                    <div class="table-responsive shadow-lg rounded">
                                        <table class="table table-hover table-striped align-middle text-center">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th>ลำดับ</th>
                                                    <th>ชื่อ</th>
                                                    <th>Username</th>
                                                    <th>Password</th>
                                                    <th>Role</th>
                                                    <th>จัดการ</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($tb_admin as $index => $item)
                                                    <tr>
                                                        <td class="text-muted">{{ $index + 1 }}</td>
                                                        <td class="fw-bold">{{ $item->name }}</td>
                                                        <td>{{ $item->email }}</td>
                                                        <td class="text-truncate" style="max-width: 150px;">
                                                            {{ $item->password }}
                                                        </td>

                                                        <td>
                                                            @if ($item->role_name == 'Admin')
                                                                <span class="badge bg-success" style="font-size: 11px">Admin</span>
                                                            @else
                                                                <span class="badge bg-primary" style="font-size: 11px">User</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-warning btn-sm"
                                                                onclick="confirmEdit('{{ $item->id }}', '{{ Auth::guard('admin')->user()->role_name }}')">
                                                                <i class="bi bi-pencil-square"></i> แก้ไข
                                                            </button>
                                                        </td>
                                                        
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Toolbar-->

                    <!--begin::Content-->
                    <div id="kt_app_content" class="app-content flex-column-fluid">
                        <div id="kt_app_content_container" class="app-container container-xxl">

                        </div>
                        <!--end::Table-->

                    </div>
                </div>
                <!--end::Content-->

            </div>
            <!--end::Content wrapper-->

            <!--begin::Footer-->
            <div id="kt_app_footer" class="app-footer">
                @include("$prefix.layout.footer")
            </div>
            <!--End::Footer-->
        </div>
        <!--end::Main-->
    </div>
    </div>
    </div>

    <!--begin::Scrolltop-->
    <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
        <i class="ki-duotone ki-arrow-up">
            <span class="path1"></span>
            <span class="path2"></span>
        </i>
    </div>
    <!--end::Scrolltop-->

    <!--begin::Javascript-->
    @include("$prefix.layout.script")
    <!--end::Javascript-->

</body>
<!--end::Body-->
<script>
    function confirmEdit(id, roleName) {
        // ถ้า role_name เป็น User จะไม่สามารถแก้ไขได้
        if (roleName === 'User') {
            Swal.fire({
                icon: 'error',
                title: 'ข้อผิดพลาด',
                text: 'คุณไม่มีสิทธิ์ในการแก้ไขข้อมูล',
                confirmButtonText: 'ตกลง'
            });
        } else {
            // ถ้า role_name เป็น Admin ก็จะให้ไปที่หน้าการแก้ไข
            window.location.href = "{{ url('webpanel/settingadmin/edit') }}/" + id;
        }
    }
</script>
@if (session('success'))
    <script>
        Swal.fire({
            title: 'สำเร็จ!',
            text: "{{ session('success') }}",
            icon: 'success',
            confirmButtonText: 'ตกลง'
        });
    </script>
@endif

@if (session('error'))
    <script>
        Swal.fire({
            title: 'ข้อผิดพลาด!',
            text: "{{ session('error') }}",
            icon: 'error',
            confirmButtonText: 'ตกลง'
        });
    </script>
@endif
