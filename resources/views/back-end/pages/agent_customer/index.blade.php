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
                                    <h2 class="text-center mb-4 text-dark">ข้อมูลลูกค้า(Agent)</h2>
                                    <div class="d-flex justify-content-end mb-3">
                                        <a href="{{ route('agent_customer.add') }}"
                                            class="btn btn-success">+เพิ่มข้อมูล</a>
                                    </div>
                                    <div class="table-responsive shadow-lg rounded">
                                        <table class="table table-hover table-striped  text-center align-middle">
                                            <thead class="table-dark">
                                                    <tr>
                                                        <th scope="col" style="width: 5%;">ลำดับ</th>
                                                        <th scope="col" style="width: 25%;">ชื่อ-นามสกุล</th>
                                                        <th scope="col" style="width: 30%;">อีเมล</th>
                                                        <th scope="col" style="width: 10%;">รายละเอียด</th>
                                                        <th scope="col" style="width: 20%;">จัดการ</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($agent_customer as $index => $item)
                                                        <tr class="text-center">
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ $item->name }}</td>
                                                            <td>{{ $item->email }}</td>
                                                            <td>
                                                                <!-- ปุ่มดูรายละเอียด -->
                                                                <button type="button" class="btn btn-primary btn-sm"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#detailModal-{{ $item->id }}">
                                                                    ดูข้อมูล
                                                                </button>
                                                            </td>
                                                            <td>
                                                                <a href="{{ route('agent_customer.edit', $item->id) }}"
                                                                    class="btn btn-warning btn-sm">แก้ไข</a>
    
                                                                <!-- ฟอร์มสำหรับส่งคำขอการลบ -->
                                                                <form id="delete-form-{{ $item->id }}" method="POST"
                                                                    action="{{ route('agent_customer.destroy', $item->id) }}"
                                                                    style="display: none;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                </form>
    
                                                                <!-- ปุ่มลบ -->
                                                                <button type="button" class="btn btn-danger btn-sm"
                                                                    onclick="confirmDelete('{{ $item->id }}', '{{ Auth::guard('admin')->user()->role_name }}')">
                                                                    ลบ
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                        <!-- Modal -->
                                        @foreach ($agent_customer as $item)
                                            <div class="modal fade" id="detailModal-{{ $item->id }}" tabindex="-1"
                                                aria-labelledby="detailModalLabel-{{ $item->id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="detailsModalLabel{{ $item->id }}">
                                                                รายละเอียดลูกค้า: {{ $item->name }}
                                                            </h5>
                                                            <div class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                                                            data-bs-dismiss="modal" aria-label="Close">
                                                            <i class="ki-duotone ki-cross fs-1"><span
                                                                    class="path1"></span><span
                                                                    class="path2"></span></i>
                                                        </div>
                                                        </div>
                                                        <div class="modal-body">
                                                            <table class="table table-bordered">
                                                                <tbody>
                                                                    
                                                                    <tr>
                                                                        <th class="text-end" style="width: 30%;">
                                                                            ใบประกอบกิจการ</th>
                                                                        <td class="text-center">
                                                                            @if ($item->business_card)
                                                                                <img src="{{ asset('business_cards/' . $item->business_card) }}"
                                                                                    style="width: 50%"
                                                                                    alt="Business Card"
                                                                                    class="img-fluid">
                                                                            @else
                                                                                <p>ไม่มีข้อมูล</p>
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="text-end">ใบทะเบียนภาษีมูลค่าเพิ่ม</th>
                                                                        <td class="text-center">
                                                                            @if ($item->tax_card)
                                                                                <img src="{{ asset('tax_cards/' . $item->tax_card) }}"
                                                                                    style="width: 50%" alt="Tax_card"
                                                                                    class="img-fluid">
                                                                            @else
                                                                                <p>ไม่มีข้อมูล</p>
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="text-end">ใบหัก ณ ที่จ่าย</th>
                                                                        <td class="text-center">
                                                                            @if ($item->slip_card)
                                                                                <img src="{{ asset('slip_cards/' . $item->slip_card) }}"
                                                                                    style="width: 50%" alt="Slip Card"
                                                                                    class="img-fluid">
                                                                            @else
                                                                                <p>ไม่มีข้อมูล</p>
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="text-end">บัตรประชาชน</th>
                                                                        <td class="text-center">
                                                                            @if ($item->pic_id_card)
                                                                                <img src="{{ asset('pic_id_cards/' . $item->pic_id_card) }}"
                                                                                    style="width: 50%" alt="ID Card"
                                                                                    class="img-fluid">
                                                                            @else
                                                                                <p>ไม่มีข้อมูล</p>
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="text-end">ที่อยู่</th>
                                                                        <td>{{ $item->address ?? 'ไม่มีข้อมูล' }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="text-end">ที่อยู่ 2</th>
                                                                        <td>{{ $item->address2 ?? 'ไม่มีข้อมูล' }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="text-end">ที่อยู่ 3</th>
                                                                        <td>{{ $item->address3 ?? 'ไม่มีข้อมูล' }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="text-end">เบอร์แฟกซ์</th>
                                                                        <td>{{ $item->fax ?? 'ไม่มีข้อมูล' }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="text-end">ตัวแทนติดต่อ</th>
                                                                        <td>{{ $item->tel2 ?? 'ไม่มีข้อมูล' }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="text-end">เบอร์โทร</th>
                                                                        <td>{{ $item->tel ?? 'ไม่มีข้อมูล' }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="text-end">เลขผู้เสียภาษี</th>
                                                                        <td>{{ $item->tax_id ?? 'ไม่มีข้อมูล' }}</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="modal-footer">
                                                         
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
    // แจ้งเตือนการลบ
    function confirmDelete(agentID, roleName) {
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
                document.getElementById(`delete-form-${agentID}`).submit();

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
