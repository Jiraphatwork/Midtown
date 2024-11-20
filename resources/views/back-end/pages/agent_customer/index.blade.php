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
                                <div class="container-fluid mt-3">
                                    <h2 class="text-center mb-4 text-primary">ข้อมูลลูกค้า(Agent)</h2>
                                    <div class="d-flex justify-content-end mb-3">
                                        <a href="{{ route('agent_customer.add') }}"
                                            class="btn btn-success">+เพิ่มข้อมูล</a>
                                    </div>
                                    <div class="table-responsive shadow-lg p-3 bg-body-tertiary rounded">
                                    <div style="overflow-x: auto;">
                                        <table
                                            class="table table-hover table-striped table-bordered align-middle table-sm w-100"
                                            style="table-layout: fixed; width: 100%;">
                                            <thead class="table-primary text-center">
                                                <tr>
                                                    <th scope="col" style="width: 15%;">ลำดับ</th>
                                                    <th scope="col" style="width: 40%;">ชื่อ-นามสกุล</th>
                                                    <th scope="col" style="width: 70%;">อีเมล</th>
                                                    <th scope="col" style="width: 20%;">ใบประกอบกิจการ</th>
                                                    <th scope="col" style="width: 30%;">ใบทะเบียนภาษีมูลค่าเพิ่ม</th>
                                                    <th scope="col" style="width: 30%;">รูปบัตรประชาชน</th>
                                                    <th scope="col" style="width: 35%;">เลขบัตรประชาชน</th>
                                                    <th scope="col" style="width: 25%;">ที่อยู่</th>
                                                    <th scope="col" style="width: 25%;">เบอร์โทร</th>
                                                    <th scope="col" style="width: 20%;">เลขผู้เสียภาษี</th>
                                                    <th scope="col" style="width: 20%;">ใบ ณ ที่จ่าย</th>
                                                    <th scope="col" style="width: 40%;">จัดการ</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($agent_customer as $index => $item)
                                                    <tr class="text-center">
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $item->name }}</td>
                                                        <td>{{ $item->email }}</td>
                                                        <td>
                                                            @if ($item->business_card)
                                                                <img src="{{ asset('business_cards/' . $item->business_card) }}"
                                                                    alt="Business_card" width="50"
                                                                    style="cursor: pointer;" data-bs-toggle="modal"
                                                                    data-bs-target="#business_cardModal-{{ $item->id }}">
                                                            @else
                                                                ไม่มีรูปภาพ
                                                            @endif
                                                        </td>

                                                        <td>
                                                            @if ($item->tax_card)
                                                                <img src="{{ asset('tax_cards/' . $item->tax_card) }}"
                                                                    alt="Tax_card" width="50"
                                                                    style="cursor: pointer;" data-bs-toggle="modal"
                                                                    data-bs-target="#tax_CardModal-{{ $item->id }}">
                                                            @else
                                                                ไม่มีรูปภาพ
                                                            @endif
                                                        </td>

                                                        <td>
                                                            @if ($item->pic_id_card)
                                                                <img src="{{ asset('pic_id_cards/' . $item->pic_id_card) }}"
                                                                    alt="Pic_id_card" width="50"
                                                                    style="cursor: pointer;" data-bs-toggle="modal"
                                                                    data-bs-target="#pic_id_cardModal-{{ $item->id }}">
                                                            @else
                                                                ไม่มีรูปภาพ
                                                            @endif
                                                        </td>

                                                        <td>{{ $item->id_card }}</td>
                                                        <td>
                                                            <button type="button" class="btn btn-info btn-sm"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#addressModal-{{ $item->id }}">ดูที่อยู่</button>
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-info btn-sm"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#telModal-{{ $item->id }}">ดูเบอร์</button>
                                                        </td>
                                                        <td>{{ $item->tax_id }}</td>
                                                        <td>
                                                            @if ($item->slip_card)
                                                                <img src="{{ asset('slip_cards/' . $item->slip_card) }}"
                                                                    alt="slip_card" width="50"
                                                                    style="cursor: pointer;" data-bs-toggle="modal"
                                                                    data-bs-target="#slip_CardModal-{{ $item->id }}">
                                                            @else
                                                                ไม่มีรูปภาพ
                                                            @endif
                                                        </td>

                                                        <td>
                                                            <!-- ปุ่มแก้ไข -->
                                                            <a href="{{ route('agent_customer.edit', $item->id) }}"
                                                                class="btn btn-warning btn-sm">แก้ไข</a>

                                                            </a>
                                                            <!-- ฟอร์มลบ -->
                                                            <form id="delete-form-{{ $item->id }}"
                                                                action="{{ route('agent_customer.destroy', $item->id) }}"
                                                                method="POST" style="display:none;">
                                                                @csrf
                                                                @method('DELETE') <!-- แปลง POST เป็น DELETE -->
                                                            </form>
                                                            <button type="button" class="btn btn-danger btn-sm"
                                                                onclick="confirmDelete('{{ $item->id }}')">ลบ</button>

                                                        </td>
                                                    </tr>

                                                    <!-- Modal สำหรับแสดงที่อยู่ -->
                                                    <div class="modal fade" id="addressModal-{{ $item->id }}"
                                                        tabindex="-1"
                                                        aria-labelledby="addressModalLabel-{{ $item->id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="addressModalLabel-{{ $item->id }}">
                                                                        ที่อยู่ของ {{ $item->name }}</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p><strong>ที่อยู่ 1:</strong> {{ $item->address }}
                                                                    </p>
                                                                    <p><strong>ที่อยู่ 2:</strong>
                                                                        {{ $item->address2 ?? 'ไม่มีข้อมูล' }}</p>
                                                                    <p><strong>ที่อยู่ 3:</strong>
                                                                        {{ $item->address3 ?? 'ไม่มีข้อมูล' }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Modal สำหรับข้อมูลเบอร์โทรศัพท์ -->
                                                    <div class="modal fade" id="telModal-{{ $item->id }}"
                                                        tabindex="-1"
                                                        aria-labelledby="telModalLabel-{{ $item->id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="telModalLabel-{{ $item->id }}">
                                                                        ข้อมูลเบอร์โทรศัพท์ของ {{ $item->name }}</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p><strong>เบอร์โทร:</strong> {{ $item->tel }}
                                                                    </p>
                                                                    <p><strong>เบอร์แฟกซ์:</strong>
                                                                        {{ $item->fax ?? 'ไม่มีข้อมูล' }}</p>
                                                                    <p><strong>เบอร์โทร 2:</strong>
                                                                        {{ $item->tel2 ?? 'ไม่มีข้อมูล' }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <!-- Modal สำหรับ Business Card -->
                                                    <div class="modal fade"
                                                        id="business_cardModal-{{ $item->id }}" tabindex="-1"
                                                        aria-labelledby="businessCardModalLabel-{{ $item->id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="businessCardModalLabel-{{ $item->id }}">
                                                                        ใบประกอบกิจการ</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body text-center">
                                                                    @if ($item->business_card)
                                                                        <img src="{{ asset('business_cards/' . $item->business_card) }}"
                                                                            alt="Business Card" class="img-fluid">
                                                                    @else
                                                                        <p>ไม่มีรูปภาพ</p>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Modal สำหรับ Tax_card -->
                                                    <div class="modal fade" id="tax_CardModal-{{ $item->id }}"
                                                        tabindex="-1"
                                                        aria-labelledby="tax_CardModalLabel-{{ $item->id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="tax_CardModalLabel-{{ $item->id }}">
                                                                        ใบทะเบียนภาษีมูลค่าเพิ่ม
                                                                    </h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body text-center">
                                                                    @if ($item->tax_card)
                                                                        <img src="{{ asset('tax_cards/' . $item->tax_card) }}"
                                                                            alt="Tax_card" class="img-fluid">
                                                                    @else
                                                                        <p>ไม่มีรูปภาพ</p>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="modal fade" id="pic_id_cardModal-{{ $item->id }}"
                                                        tabindex="-1"
                                                        aria-labelledby="pic_id_CardModalLabel-{{ $item->id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="pic_id_CardModalLabel-{{ $item->id }}">
                                                                        รูปบัตรประชาชน
                                                                    </h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body text-center">
                                                                    @if ($item->pic_id_card)
                                                                        <img src="{{ asset('pic_id_cards/' . $item->pic_id_card) }}"
                                                                            alt="pic_id_card" class="img-fluid">
                                                                    @else
                                                                        <p>ไม่มีรูปภาพ</p>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="modal fade" id="slip_CardModal-{{ $item->id }}"
                                                        tabindex="-1"
                                                        aria-labelledby="slip_CardModalLabel-{{ $item->id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="slip_CardModalLabel-{{ $item->id }}">
                                                                        ใบทะเบียนภาษีมูลค่าเพิ่ม
                                                                    </h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body text-center">
                                                                    @if ($item->slip_card)
                                                                        <img src="{{ asset('slip_cards/' . $item->slip_card) }}"
                                                                            alt="slip_card" class="img-fluid">
                                                                    @else
                                                                        <p>ไม่มีรูปภาพ</p>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                                @if ($agent_customer->isEmpty())
                                                    <tr>
                                                        <td colspan="15" class="text-center">ไม่มีข้อมูล</td>
                                                    </tr>
                                                @endif
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
    function confirmDelete(agentcustomerId) {
        Swal.fire({
            title: 'คุณแน่ใจหรือไม่?',
            text: "การลบข้อมูลนี้ไม่สามารถกู้คืนได้!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ใช่, ลบเลย!',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                // ส่งฟอร์มลบ
                document.getElementById(`delete-form-${agentcustomerId}`).submit();

                // แจ้งเตือนหลังลบ
                Swal.fire({
                    title: 'ลบสำเร็จ!',
                    text: "ข้อมูลได้ถูกลบเรียบร้อยแล้ว.",
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false
                });
            }
        });
    }
</script>

</script>

//แจ้งเตือนการแก้ไข
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
