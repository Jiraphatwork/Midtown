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
                                    <h2 class="text-center mb-4 text-dark">แก้ไขตั้งค่าข้อมูลการสแกนจ่าย Qr Code</h2>
                                </div>
                            </div>
                        </div>

                        <div id="kt_app_content" class="app-content flex-column-fluid">
                            <!--begin::Content container-->
                            <div id="kt_app_content_container" class="app-container container-xxl">
                                <div class="card">
                                    <div class="card-body">
                                        <form id="form_submit" method="POST" enctype="multipart/form-data"class="">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="name_account" class="form-label">ชื่อบัญชี</label>
                                                <input type="text" class="form-control" id="name_account" name="name_account" value="{{$item->name_account}}"
                                                    placeholder="กรอกชื่อเงื่อนไข" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="image_path" class="form-label">อัปโหลดรูปภาพ</label>
                                                <input type="file" class="form-control" id="image_path" name="image_path">
                                            
                                                @if ($item->image_path)
                                                    <div class="mt-2">
                                                        <img src="{{ asset($item->image_path) }}" alt="Current Image" width="100">
                                                        <!-- ปุ่มลบรูปภาพ -->
                                                        <button type="button" class="btn btn-danger mt-2" id="deleteImageButton" onclick="deleteImage()">ลบรูปภาพ</button>
                                                    </div>
                                                @else
                                                    <p class="text-muted mt-2">ไม่มีรูปภาพ</p>
                                                @endif
                                            </div>
                                            
                                            <!-- Hidden input เพื่อเก็บค่าการลบรูปภาพ -->
                                            <input type="hidden" name="delete_image" id="delete_image" value="">

                                            <div class="d-flex justify-content-center text-center">
                                                <!-- ปุ่มบันทึก  -->
                                                <a href="javascript:void(0)" class="btn btn-primary me-2" id="submit"
                                                    onclick="check_add()">
                                                    <i class="fa-solid fa-save"></i> บันทึก
                                                </a>

                                                <!-- ปุ่มยกเลิก  -->
                                                <button type="reset" onclick="history.back()"
                                                    class="btn btn-light btn-active-light-primary">
                                                    <i class="fa-solid fa-circle-xmark"></i> ยกเลิก
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!--end::Content container-->
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
     function deleteImage() {
        // เมื่อคลิกปุ่มลบรูปภาพ, ให้ตั้งค่า hidden input เพื่อติดตามว่ามีการลบรูปหรือไม่
        if (confirm('คุณแน่ใจหรือไม่ที่จะลบรูปภาพนี้?')) {
            document.getElementById('delete_image').value = '1'; // ตั้งค่าเป็น 1 เพื่อบอกว่าให้ลบรูป
            // ซ่อนรูปภาพและปุ่มลบ
            document.querySelector('img').style.display = 'none';
            document.getElementById('deleteImageButton').style.display = 'none';
        }
    }

    function check_add() {
        var formData = new FormData($("#form_submit")[0]);

        Swal.fire({
            icon: 'warning',
            title: 'ยืนยันการแก้ไข!',
            showCancelButton: true,
            confirmButtonText: 'ยืนยัน',
            cancelButtonText: `ยกเลิก`,
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: "{{ url('webpanel/settingqrcode/edit', $item->id) }}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        if (data) {
                            Swal.fire({
                                icon: 'success',
                                title: "สำเร็จ!",
                                text: "แก้ไขข้อมูลสำเร็จ",
                                timer: 2000,
                                showConfirmButton: false,
                            }).then((result) => {
                                location.href = "{{ url('webpanel/settingqrcode') }}";
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: "Error",
                                text: "Something is wrong",
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

        return false;
    }
</script>
