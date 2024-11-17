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
                                    <h2 class="text-center mb-4 text-primary">ตั้งค่าข้อมูลการสแกนจ่าย Qr Code</h2>
                                    <div class="d-flex justify-content-end mb-3">
                                        <a href="webpanel/settingqrcode/add" class="btn btn-success">+เพิ่มข้อมูล</a>
                                    </div>
                                    <div class="table-responsive shadow-lg p-3 bg-body-tertiary rounded">
                                        <table class="table table-hover table-striped table-bordered align-middle">
                                            <thead class="table-primary text-center">
                                                <tr>
                                                    <th scope="col">ลำดับ</th>
                                                    <th scope="col">Qrcode</th>
                                                    <th scope="col">ชื่อบัญชี</th>
                                                    <th scope="col">จัดการ</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($items as $index => $item)
                                                <tr class="text-center">
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>
                                                        @if ($item->image_path)
                                                            <!-- รูปภาพที่สามารถคลิกเพื่อดูใน Modal -->
                                                            <img src="{{ asset($item->image_path) }}" alt="Image" width="100" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#imageModal-{{ $item->id }}">
                                                        @else
                                                            ไม่มีรูปภาพ
                                                        @endif
                                                    </td>
                                                    <td>{{ $item->name_account }}</td>
                                                    <td class="text-center">
                                                        <a href="{{ url('webpanel/settingqrcode/edit/' . $item->id) }}"
                                                            class="btn btn-warning btn-sm">แก้ไข</a>
                                                        <a href="javascript:void(0);" class="btn btn-danger btn-sm"
                                                            onclick="check_destroy({{ $item->id }})">ลบ</a>

                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                    <!-- Modal สำหรับแสดงรูปภาพ -->
                                    @foreach($items as $index => $item)
                                        <div class="modal fade" id="imageModal-{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel-{{ $item->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel-{{ $item->id }}">รูปภาพ</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body text-center">
                                                        <!-- แสดงรูปภาพใน Modal -->
                                                        <img src="{{ asset($item->image_path) }}" alt="Image" class="img-fluid">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
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
        Swal.fire({
            icon: 'warning',
            title: 'Are you sure you want to delete this item?',
            showCancelButton: true,
            confirmButtonText: 'Delete',
            cancelButtonText: 'Cancel',
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
                                title: "Deleted Successfully",
                                text: "The data has been deleted successfully.",
                                showCancelButton: false,
                                confirmButtonText: 'Close',
                            }).then((result) => {
                                location.reload(); // รีโหลดหน้าเพื่อให้ข้อมูลอัพเดต
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: "Error",
                                text: "Something went wrong.",
                                showCancelButton: false,
                                confirmButtonText: 'Close',
                            });
                        }
                    }
                });
            } else {
                return false;
            }
        });
    }
</script>
