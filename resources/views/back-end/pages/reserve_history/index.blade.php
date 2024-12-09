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
                                    <h2 class="text-center mb-4 text-dark">ประวัติการจอง</h2>

                                    <div class="d-flex justify-content-between mb-3">
                                        <form action="{{ route('reserve_history.index') }}" method="GET"
                                            class="d-flex align-items-center">
                                            <div class="input-group">
                                                <select name="type" class="form-select me-3"
                                                    onchange="this.form.submit()">
                                                    <option value="">-- เลือกรูปแบบพื้นที่ --</option>
                                                    <option value="รูปแบบที่1"
                                                        {{ request('type') == 'รูปแบบที่1' ? 'selected' : '' }}>
                                                        รูปแบบที่1</option>
                                                    <option value="รูปแบบที่2"
                                                        {{ request('type') == 'รูปแบบที่2' ? 'selected' : '' }}>
                                                        รูปแบบที่2</option>
                                                    <option value="รูปแบบที่3"
                                                        {{ request('type') == 'รูปแบบที่3' ? 'selected' : '' }}>
                                                        รูปแบบที่3</option>
                                                </select>
                                            </div>
                                        </form>

                                        <a href="{{ route('reserve_history.add') }}"
                                            class="btn btn-success">+เพิ่มข้อมูล</a>
                                    </div>
                                    <div class="table-responsive shadow-lg rounded">
                                        <table class="table table-hover table-striped align-middle text-center">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th scope="col">ลำดับ</th>
                                                    <th scope="col">ชื่อ-นามสกุล</th>
                                                    <th scope="col">รวมวันที่</th>
                                                    <th scope="col">สถานะ</th>
                                                    <th scope="col">ประเภทสินค้า</th>
                                                    <th scope="col">รูปแบบพื้นที่</th>
                                                    <th scope="col">รูปภาพ</th>
                                                    <th scope="col">พื้นที่</th>
                                                    <th scope="col">ราคา</th>
                                                    <th scope="col">จัดการ</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($reserveHistories as $index => $history)
                                                    <tr class="text-center">
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $history->name }}</td>
                                                        <td>
                                                            <!-- ปุ่มสำหรับเปิด Modal -->
                                                            <button type="button" class="btn btn-primary btn-sm"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#dateModal{{ $history->id }}">
                                                                ดูข้อมูล
                                                            </button>
                                                        </td>
                                                        <td>
                                                            @if ($history->status == 'จ่ายแล้ว')
                                                                <span class="badge bg-success">จ่ายแล้ว</span>
                                                            @else
                                                                <span class="badge bg-danger">ยังไม่จ่าย</span>
                                                            @endif
                                                        </td>
                                                        <td>{{ $history->product_type }}</td>
                                                        <td>{{ $history->type }}</td>
                                                        <td>
                                                            @if ($history->pic_area)
                                                                <img src="{{ asset('pic_areas_reserve/' . $history->pic_area) }}"
                                                                    alt="error" width="80px"
                                                                    style="cursor: pointer;" data-bs-toggle="modal"
                                                                    data-bs-target="#imageModal{{ $history->id }}">
                                                            @else
                                                                ไม่มีรูปภาพ
                                                            @endif
                                                        </td>
                                                        <td>{{ $history->area }}</td>
                                                        <td>{{ $history->price }}</td>

                                                        <td>
                                                            <a href="{{ route('reserve_history.edit', $history->id) }}"
                                                                class="btn btn-warning btn-sm">แก้ไข</a>

                                                            <form id="delete-form-{{ $history->id }}" method="POST"
                                                                action="{{ route('reserve_history.destroy', $history->id) }}"
                                                                style="display: none;">
                                                                @csrf
                                                                @method('DELETE')
                                                            </form>

                                                            <button type="button" class="btn btn-danger btn-sm"
                                                                onclick="confirmDelete('{{ $history->id }}', '{{ Auth::guard('admin')->user()->role_name }}', '{{ Auth::guard('admin')->user()->email }}', '{{ $history->created_by }}')">
                                                                ลบ
                                                            </button>

                                                        </td>
                                                    </tr>

                                                    <!-- Modal สำหรับแสดงข้อมูลวันที่ -->
                                                    <div class="modal fade" id="dateModal{{ $history->id }}"
                                                        tabindex="-1" aria-labelledby="dateModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="detailsModalLabel{{ $history->id }}">
                                                                        ข้อมูลของ: {{ $history->name }}
                                                                    </h5>
                                                                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                                                                        data-bs-dismiss="modal" aria-label="Close">
                                                                        <i class="ki-duotone ki-cross fs-1"><span
                                                                                class="path1"></span><span
                                                                                class="path2"></span></i>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-body text-start">
                                                                    <p><strong>วันที่จ่ายเงิน:</strong>
                                                                        {{ \Carbon\Carbon::parse($history->now_date)->locale('th')->isoFormat('D MMMM YYYY') }}
                                                                    </p>
                                                                    <p><strong>วันแรกของการจอง:</strong>
                                                                        {{ \Carbon\Carbon::parse($history->first_date)->locale('th')->isoFormat('D MMMM YYYY') }}
                                                                    </p>
                                                                    <p><strong>วันสุดท้ายของการจอง:</strong>
                                                                        {{ \Carbon\Carbon::parse($history->last_date)->locale('th')->isoFormat('D MMMM YYYY') }}
                                                                    </p>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Modal สำหรับรูป -->
                                                    <div class="modal fade" id="imageModal{{ $history->id }}"
                                                        tabindex="-1"
                                                        aria-labelledby="PicareaModalLabel{{ $history->id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="PicareaModalLabel{{ $history->id }}">
                                                                        รูปภาพพื้นที่: {{ $history->type }}
                                                                    </h5>
                                                                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                                                                        data-bs-dismiss="modal" aria-label="Close">
                                                                        <i class="ki-duotone ki-cross fs-1"><span
                                                                                class="path1"></span><span
                                                                                class="path2"></span></i>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-body text-center">
                                                                    @if ($history->pic_area)
                                                                        <img src="{{ asset('pic_areas_reserve/' . $history->pic_area) }}"
                                                                            alt="picarea" class="img-fluid">
                                                                    @else
                                                                        <p>ไม่มีรูปภาพ</p>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @empty
                                                    <tr>
                                                        <td colspan="10" class="text-center">ไม่มีข้อมูล</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
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
    function confirmDelete(historyId, roleName, currentUserEmail, createdBy) {
        // ตรวจสอบสิทธิ์: ให้ Admin ลบได้ทั้งหมด, หรือ email ต้องตรงกับ created_by
        if (roleName !== 'Admin' && currentUserEmail !== createdBy) {
            // แสดงข้อความแจ้งเตือนหากไม่มีสิทธิ์
            Swal.fire({
                title: 'คุณไม่มีสิทธิ์ในการลบข้อมูลของผู้อื่น',
                text: 'โปรดติดต่อผู้ดูแลระบบหากคุณต้องการสิทธิ์เพิ่มเติม',
                icon: 'error',
                confirmButtonText: 'ตกลง',
            });
            return;
        }

        // หากมีสิทธิ์ (roleName เป็น Admin หรือ email ตรงกับ created_by)
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
                document.getElementById(`delete-form-${historyId}`).submit();

                // แจ้งเตือนหลังลบ
                Swal.fire({
                    title: 'ลบสำเร็จ!',
                    text: 'ข้อมูลได้ถูกลบเรียบร้อยแล้ว.',
                    icon: 'success',
                    timer: 3000,
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
