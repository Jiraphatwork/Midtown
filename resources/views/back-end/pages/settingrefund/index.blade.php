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
                                    <h2 class="text-center mb-4 text-dark">ตั้งค่าข้อมูลเงื่อนไขการคืนเงินการยกเลิก</h2>
                                    <div class="d-flex justify-content-end mb-3">
                                        <a href="webpanel/settingrefund/add"
                                            class="btn btn-success">+เพิ่มข้อมูล</a>
                                    </div>
                                    <div class="table-responsive shadow-lg rounded">
                                        <table class="table table-hover table-striped  text-center align-middle">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th scope="col">ลำดับ</th>
                                                    <th scope="col">ชื่อเงื่อนไข</th>
                                                    <th scope="col">รายละเอียด</th>
                                                    <th scope="col">จัดการ</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Loop through the items to display each one -->
                                                @foreach ($items as $index => $item)
                                                    <tr class="text-center">
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $item->name }}</td>
                                                        <td>
                                                            @php
                                                                $text = $item->details;
                                                                $shortText = Str::limit($text, 30); // ตัดข้อความให้เหลือ 100 ตัว
                                                            @endphp

                                                            <span>{{ $shortText }}</span>
                                                            @if (strlen($text) > 30)
                                                                <button class="btn btn-link p-0" data-bs-toggle="modal"
                                                                    data-bs-target="#detailsModal{{ $item->id }}">
                                                                    อ่านเพิ่มเติม
                                                                </button>
                                                            @endif
                                                        <td class="text-center">
                                                            <a href="{{ route('settingrefund.edit', $item->id) }}"
                                                                class="btn btn-warning btn-sm">แก้ไข</a>
                                                            <a href="javascript:void(0);" class="btn btn-danger btn-sm"
                                                                onclick="check_destroy({{ $item->id }}, '{{ Auth::guard('admin')->user()->role_name }}')">ลบ</a>
                                                        </td>
                                                    </tr>
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="detailsModal{{ $item->id }}"
                                                        tabindex="-1"
                                                        aria-labelledby="detailsModalLabel{{ $item->id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="detailsModalLabel{{ $item->id }}">
                                                                        รายละเอียด: {{ $item->name }}
                                                                    </h5>
                                                                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                                                                        data-bs-dismiss="modal" aria-label="Close">
                                                                        <i class="ki-duotone ki-cross fs-1"><span
                                                                                class="path1"></span><span
                                                                                class="path2"></span></i>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-body">
                                                                    {{ $text }}
                                                                </div>
                                                                <div class="modal-footer">

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </tbody>
                                        </table>
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
    function check_destroy(id, roleName) {
        if (roleName !== 'Admin') {
            // แสดงข้อความแจ้งเตือนหากไม่มีสิทธิ์
            Swal.fire({
                icon: 'error',
                title: 'ข้อผิดพลาด',
                text: 'คุณไม่มีสิทธิ์ในการลบข้อมูล',
                confirmButtonText: 'ตกลง',
            });
            return;
        }

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
                    url: "{{ url('webpanel/settingrefund/destroy') }}/" + id, // ใช้ URL สำหรับลบข้อมูล
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
                                text: data.message || "เกิดข้อผิดพลาดในการลบข้อมูล",
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
            showConfirmButton: false,        });
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

