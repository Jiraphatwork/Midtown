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
                                    <h1 class="text-center mb-4 text-dark">ข้อมูลโปรโมชั่น</h1>
                                    <div class="d-flex justify-content-end mb-3">
                                        <a href="{{ route('promotion.add') }}" class="btn btn-success btn-sm"><i
                                                class="fas fa-plus"></i> เพิ่มข้อมูล</a>
                                    </div>
                                    <div class="card rounded ">
                                        <div class="card-body">
                                            <div class="table-responsive rounded">
                                                <table class="table table-hover table-striped text-center align-middle">
                                                    <thead class="table-dark">
                                                        <tr>
                                                            <th scope="col" style="width: 10%">ลำดับ</th>
                                                            <th scope="col">ชื่อโปรโมชั่น</th>
                                                            <th scope="col">รูปภาพ</th>
                                                            <th scope="col">รายละเอียด</th>
                                                            <th scope="col">วันเริ่มต้นโปรโมชั่น</th>
                                                            <th scope="col">วันสิ้นสุดโปรโมชั่น</th>
                                                            <th scope="col" style="width: 20%;">จัดการ</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($promotion_models as $index => $item)
                                                            <tr class="text-center">
                                                                <td>{{ $index + 1 }}</td>
                                                                <td>{{ $item->name_promotion }}</td>
                                                                <td>
                                                                    @if ($item->pic_promotion)
                                                                        <img src="{{ asset('pic_promotions/' . $item->pic_promotion) }}"
                                                                            alt="error" width="60px"
                                                                            style="cursor: pointer;"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#imageModal{{ $item->id }}">
                                                                    @else
                                                                        ไม่มีรูปภาพ
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @php
                                                                        $text = $item->detail;
                                                                        $shortText = Str::limit($text, 30); // ตัดข้อความให้เหลือ 100 ตัว
                                                                    @endphp

                                                                    <span>{{ $shortText }}</span>
                                                                    @if (strlen($text) > 30)
                                                                        <button class="btn btn-link p-0" style="font-size: 0.8rem;"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#detailsModal{{ $item->id }}">
                                                                            อ่านเพิ่มเติม
                                                                        </button>
                                                                    @endif
                                                                </td>
                                                                <td>{{ \Carbon\Carbon::parse($item->first_date)->locale('th')->isoFormat('D MMMM YYYY') }}
                                                                </td>
                                                                <td>{{ \Carbon\Carbon::parse($item->last_date)->locale('th')->isoFormat('D MMMM YYYY') }}
                                                                </td>

                                                                <td>
                                                                    <a href="{{ route('promotion.edit', $item->id) }}"
                                                                        class="btn btn-warning btn-sm"> <i
                                                                            class="fas fa-edit"></i> แก้ไข</a>

                                                                    <!-- ฟอร์มสำหรับส่งคำขอการลบ -->
                                                                    <form id="delete-form-{{ $item->id }}"
                                                                        method="POST"
                                                                        action="{{ route('promotion.destroy', $item->id) }}"
                                                                        style="display: none;">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                    </form>

                                                                    <!-- ปุ่มลบ -->
                                                                    <button type="button" class="btn btn-danger btn-sm"
                                                                        onclick="confirmDelete('{{ $item->id }}', '{{ Auth::guard('admin')->user()->role_name }}')">
                                                                        <i class="fas fa-trash-alt"></i> ลบ
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                            <!-- Modal สำหรับแต่ละแถว -->
                                                            <div class="modal fade" id="imageModal{{ $item->id }}"
                                                                tabindex="-1"
                                                                aria-labelledby="pic_promotion{{ $item->id }}"
                                                                aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <!-- แสดงชื่อโปรโมชั่นในหัวข้อของ Modal -->
                                                                            <h5 class="modal-title"
                                                                                id="pic_promotion{{ $item->id }}">
                                                                                รูปโปรโมชั่น:
                                                                                {{ $item->name_promotion }}</h5>
                                                                            <div class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                                                                                data-bs-dismiss="modal"
                                                                                aria-label="Close">
                                                                                <i class="ki-duotone ki-cross fs-1"><span
                                                                                        class="path1"></span><span
                                                                                        class="path2"></span></i>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-body text-center">
                                                                            @if ($item->pic_promotion)
                                                                                <img src="{{ asset('pic_promotions/' . $item->pic_promotion) }}"
                                                                                    alt="promotion" class="img-fluid">
                                                                            @else
                                                                                <p>ไม่มีรูปภาพ</p>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- Modal สำหรับแสดงรายละเอียด -->
                                                            <div class="modal fade"
                                                                id="detailsModal{{ $item->id }}" tabindex="-1"
                                                                aria-labelledby="detailsModalLabel{{ $item->id }}"
                                                                aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title"
                                                                                id="detailsModalLabel{{ $item->id }}">
                                                                                รายละเอียดโปรโมชั่น:
                                                                                {{ $item->name_promotion }}</h5>
                                                                            <div class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                                                                                data-bs-dismiss="modal"
                                                                                aria-label="Close">
                                                                                <i class="ki-duotone ki-cross fs-1"><span
                                                                                        class="path1"></span><span
                                                                                        class="path2"></span></i>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-body text-center">
                                                                            <p>{{ $item->detail }}</p>
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
    // แจ้งเตือนการลบ
    function confirmDelete(promotionID, roleName) {
        if (roleName !== 'Admin') {
            // แสดงข้อความแจ้งเตือนหากไม่มีสิทธิ์
            Swal.fire({
                title: 'ข้อผิดพลาด',
                text: 'คุณไม่มีสิทธิ์ในการลบข้อมูล',
                icon: 'error',
                confirmButtonText: 'ตกลง',
            });
            return;
        }

        // หากมีสิทธิ์ (roleName เป็น Admin)
        Swal.fire({
            title: 'คุณแน่ใจหรือไม่?',
            text: "การลบข้อมูลนี้ไม่สามารถกู้คืนได้!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ใช่, ลบเลย!',
            cancelButtonText: 'ยกเลิก',
        }).then((result) => {
            if (result.isConfirmed) {
                // ส่งฟอร์มลบ
                document.getElementById(`delete-form-${promotionID}`).submit();

                // แจ้งเตือนหลังลบ
                Swal.fire({
                    title: 'ลบสำเร็จ!',
                    text: 'ข้อมูลได้ถูกลบเรียบร้อยแล้ว.',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false,
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
