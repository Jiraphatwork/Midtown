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
                                    <div style="overflow-x: auto;">
                                        <table
                                            class="table table-hover table-striped table-bordered align-middle table-sm w-100"
                                            style="table-layout: fixed; width: 100%;">
                                            <thead class="table-primary text-center">
                                                <tr>
                                                    <th scope="col" style="width: 15%;">ลำดับ</th>
                                                    <th scope="col" style="width: 30%;">ชื่อ-นามสกุล</th>
                                                    <th scope="col" style="width: 50%;">อีเมล</th>
                                                    <th scope="col" style="width: 20%;">ใบประกอบกิจการ</th>
                                                    <th scope="col" style="width: 30%;">ใบทะเบียนภาษีมูลค่าเพิ่ม</th>
                                                    <th scope="col" style="width: 30%;">รูปบัตรประชาชน</th>
                                                    <th scope="col" style="width: 35%;">เลขบัตรประชาชน</th>
                                                    <th scope="col" style="width: 25%;">ที่อยู่</th>
                                                    <th scope="col" style="width: 25%;">เบอร์โทร</th>
                                                    <th scope="col" style="width: 15%;">เบอร์แฟกซ์</th>
                                                    <th scope="col" style="width: 25%;">ตัวแทนติดต่อ</th>
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
                                                        <td>{{ $item->business_card }}</td>
                                                        <td>{{ $item->tax_card }}</td>
                                                        <td>
                                                            <img src="{{ asset('storage/' . $item->pic_id_card) }}"
                                                                alt="ID Card" class="img-thumbnail"
                                                                style="width: 70px;">
                                                        </td>
                                                        <td>{{ $item->id_card }}</td>
                                                        <td>
                                                            <button type="button" class="btn btn-info btn-sm"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#addressModal-{{ $item->id }}">ดูที่อยู่</button>
                                                        </td>
                                                        <td>{{ $item->tel }}</td>
                                                        <td>{{ $item->fax }}</td>
                                                        <td>{{ $item->tel2 }}</td>
                                                        <td>{{ $item->tax_id }}</td>
                                                        <td>{{ $item->slip_card }}</td>
                                                        <td>
                                                            <a href="{{ route('ordinary_customer.edit', $item->id) }}"
                                                                class="btn btn-warning btn-sm">แก้ไข</a>
                                                            <form id="delete-form-{{ $item->id }}"
                                                                action="{{ route('ordinary_customer.destroy', $item->id) }}"
                                                                method="POST" style="display:none;">
                                                                @csrf
                                                                @method('DELETE')
                                                            </form>
                                                            <button type="button" class="btn btn-danger btn-sm"
                                                                onclick="if(confirm('คุณแน่ใจหรือไม่ว่าต้องการลบ?')) { document.getElementById('delete-form-{{ $item->id }}').submit(); }">ลบ</button>
                                                        </td>
                                                    </tr>
                                                    <!-- Modal -->
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

