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
                                    <h2 class="text-center mb-4 text-dark">ตั้งค่าข้อมูลการสแกนจ่าย Qr Code
                                    </h2>
                                    <div class="d-flex justify-content-end mb-3">
                                        <a href="webpanel/settingqrcode/add" class="btn btn-success btn-sm"><i
                                                class="fas fa-plus"></i> เพิ่มข้อมูล</a>
                                    </div>
                                    <div class="card rounded ">
                                        <div class="card-body">
                                            <div class="table-responsive rounded">

                                                <table class="table table-hover table-striped text-center align-middle">
                                                    <thead class="table-dark">
                                                        <tr>
                                                            <th scope="col">ลำดับ</th>
                                                            <th scope="col">Qrcode</th>
                                                            <th scope="col">ชื่อบัญชี</th>
                                                            <th scope="col" style="width: 20%;">จัดการ</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($items as $index => $item)
                                                            <tr class="text-center">
                                                                <td>{{ $index + 1 }}</td>
                                                                <td>
                                                                    @if ($item->image_path)
                                                                        <!-- รูปภาพที่สามารถคลิกเพื่อดูใน Modal -->
                                                                        <img src="{{ asset($item->image_path) }}"
                                                                            alt="error" width="60px"
                                                                            style="cursor: pointer;"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#imageModal-{{ $item->id }}">
                                                                    @else
                                                                        ไม่มีรูปภาพ
                                                                    @endif
                                                                </td>
                                                                <td>{{ $item->name_account }}</td>
                                                                <td class="text-center">
                                                                    <a href="{{ route('settingqrcode.edit', $item->id) }}"
                                                                        class="btn btn-warning btn-sm"><i
                                                                            class="fas fa-edit"></i> แก้ไข</a>

                                                                    <a href="javascript:void(0);"
                                                                        class="btn btn-danger btn-sm"
                                                                        onclick="check_destroy({{ $item->id }}, '{{ Auth::guard('admin')->user()->role_name }}')"><i
                                                                            class="fas fa-trash-alt"></i> ลบ</a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                            <!-- Modal สำหรับแสดงรูปภาพ -->
                                            @foreach ($items as $index => $item)
                                                <div class="modal fade" id="imageModal-{{ $item->id }}"
                                                    tabindex="-1"
                                                    aria-labelledby="exampleModalLabel-{{ $item->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="exampleModalLabel{{ $item->id }}">
                                                                    ชื่อบัญชี: {{ $item->name_account }}
                                                                </h5>
                                                                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                                                                    data-bs-dismiss="modal" aria-label="Close">
                                                                    <i class="ki-duotone ki-cross fs-1"><span
                                                                            class="path1"></span><span
                                                                            class="path2"></span></i>
                                                                </div>
                                                            </div>
                                                            <div class="modal-body text-center">
                                                                <!-- แสดงรูปภาพใน Modal -->
                                                                <img src="{{ asset($item->image_path) }}"
                                                                    alt="Image" class="img-fluid">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
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
    function check_destroy(id) {
        // ตรวจสอบสิทธิ์ของผู้ใช้
        const roleName = "{{ Auth::guard('admin')->user()->role_name }}"; // ดึง role ของผู้ใช้จาก Laravel

        // หากไม่ใช่ Admin ให้แสดงแจ้งเตือน
        if (roleName !== 'Admin') {
            Swal.fire({
                icon: 'error',
                title: 'ข้อผิดพลาด',
                text: 'คุณไม่มีสิทธิ์ในการลบข้อมูล',
                confirmButtonText: 'ตกลง',
            });
            return; // หยุดการทำงานหากไม่ใช่ Admin
        }

        // ถ้าเป็น Admin ให้ดำเนินการลบข้อมูล
        Swal.fire({
            icon: 'warning',
            title: 'การลบข้อมูลนี้ไม่สามารถกู้คืนได้!',
            showCancelButton: true,
            confirmButtonText: 'ใช่, ลบเลย!',
            cancelButtonText: 'ยกเลิก',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'GET',
                    url: "{{ url('webpanel/settingqrcode/destroy') }}/" + id, // ใช้ URL สำหรับลบข้อมูล
                    dataType: 'json',
                    success: function(data) {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: "ลบสำเร็จ!",
                                text: "ข้อมูลได้ถูกลบเรียบร้อยแล้ว.",
                                showCancelButton: false,
                                confirmButtonText: 'Close',
                            }).then(() => {
                                location.reload(); // รีโหลดหน้าเพื่อให้ข้อมูลอัพเดต
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: "ข้อผิดพลาด!",
                                text: "ข้อผิดพลาดในการลบข้อมูล",
                                showCancelButton: false,
                                confirmButtonText: 'ตกลง',
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: "ข้อผิดพลาด!",
                            text: "เกิดข้อผิดพลาดในการลบข้อมูล",
                            confirmButtonText: 'ตกลง',
                        });
                    }
                });
            }
        });
    }
</script>

@if (session('success'))
    <script>
        Swal.fire({
            title: 'สำเร็จ!',
            text: "{{ session('success') }}",
            icon: 'success',
            timer: 2000,
            showConfirmButton: false,
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
