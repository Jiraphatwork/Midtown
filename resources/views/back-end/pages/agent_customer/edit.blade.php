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
                                    <h2 class="text-center mb-4">แก้ไขข้อมูลลูกค้า(Agent)</h2>
                                    <div class="shadow-lg p-4 bg-body-tertiary rounded">
                                        <form action="{{ route('agent_customer.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('POST') 
                                            
                                            <div class="mb-3">
                                                <label for="name" class="form-label">ชื่อ</label>
                                                <input type="text" class="form-control" id="name" name="name" 
                                                    value="{{ old('name', $item->name) }}" placeholder="กรอกชื่อ" required>
                                            </div>
                                        
                                            <div class="mb-3">
                                                <label for="email" class="form-label">อีเมล</label>
                                                <input type="email" class="form-control" id="email" name="email" 
                                                    value="{{ old('email', $item->email) }}" placeholder="กรอกอีเมล" required>
                                            </div>
                                        
                                            <div class="mb-3">
                                                <label for="business_card" class="form-label">ใบประกอบกิจการ</label>
                                                @if ($item->business_card)
                                                    <div class="mb-2">
                                                        <img src="{{ asset('business_cards/' . $item->business_card) }}" alt="Business Card" width="150">
                                                    </div>
                                                @endif
                                                <input type="file" class="form-control" id="business_card" name="business_card" accept="image/*">
                                                <small class="text-muted">* หากไม่ต้องการเปลี่ยนไฟล์ ไม่ต้องเลือกไฟล์</small>
                                            </div>
                                        
                                            <div class="mb-3">
                                                <label for="tax_card" class="form-label">ใบทะเบียนภาษีมูลค่าเพิ่ม</label>
                                                @if ($item->tax_card)
                                                    <div class="mb-2">
                                                        <img src="{{ asset('tax_cards/' . $item->tax_card) }}" alt="Tax Card" width="150">
                                                    </div>
                                                @endif
                                                <input type="file" class="form-control" id="tax_card" name="tax_card" accept="image/*">
                                                <small class="text-muted">* หากไม่ต้องการเปลี่ยนไฟล์ ไม่ต้องเลือกไฟล์</small>
                                            </div>
                                        
                                            <div class="mb-3">
                                                <label for="pic_id_card" class="form-label">รูปบัตรประชาชน</label>
                                                @if ($item->pic_id_card)
                                                    <div class="mb-2">
                                                        <img src="{{ asset('pic_id_cards/' . $item->pic_id_card) }}" alt="ID Card" width="150">
                                                    </div>
                                                @endif
                                                <input type="file" class="form-control" id="pic_id_card" name="pic_id_card" accept="image/*">
                                                <small class="text-muted">* หากไม่ต้องการเปลี่ยนไฟล์ ไม่ต้องเลือกไฟล์</small>
                                            </div>
                                        
                                            <div class="mb-3">
                                                <label for="id_card" class="form-label">รหัสบัตรประชาชน</label>
                                                <input type="text" class="form-control" id="id_card" name="id_card" 
                                                    value="{{ old('id_card', $item->id_card) }}" placeholder="กรอกหมายเลขบัตรประชาชน" required>
                                            </div>
                                        
                                            <div class="mb-3">
                                                <label for="address" class="form-label">ที่อยู่ 1</label>
                                                <textarea class="form-control" id="address" name="address" rows="2" placeholder="กรอกที่อยู่ 1" required>{{ old('address', $item->address) }}</textarea>
                                            </div>
                                        
                                            <div class="mb-3">
                                                <label for="address2" class="form-label">ที่อยู่ 2</label>
                                                <textarea class="form-control" id="address2" name="address2" rows="2" placeholder="กรอกที่อยู่ 2">{{ old('address2', $item->address2) }}</textarea>
                                            </div>
                                        
                                            <div class="mb-3">
                                                <label for="address3" class="form-label">ที่อยู่ 3</label>
                                                <textarea class="form-control" id="address3" name="address3" rows="2" placeholder="กรอกที่อยู่ 3">{{ old('address3', $item->address3) }}</textarea>
                                            </div>
                                        
                                            <div class="mb-3">
                                                <label for="tel" class="form-label">เบอร์โทร</label>
                                                <input type="text" class="form-control" id="tel" name="tel" 
                                                    value="{{ old('tel', $item->tel) }}" placeholder="กรอกเบอร์โทร">
                                            </div>
                                        
                                            <div class="mb-3">
                                                <label for="fax" class="form-label">เบอร์แฟกซ์</label>
                                                <input type="text" class="form-control" id="fax" name="fax" 
                                                    value="{{ old('fax', $item->fax) }}" placeholder="กรอกเบอร์แฟกซ์">
                                            </div>
                                        
                                            <div class="mb-3">
                                                <label for="tel2" class="form-label">ตัวแทนติดต่อ</label>
                                                <input type="text" class="form-control" id="tel2" name="tel2" 
                                                    value="{{ old('tel2', $item->tel2) }}" placeholder="กรอกเบอร์ตัวแทนติดต่อ">
                                            </div>
                                        
                                            <div class="mb-3">
                                                <label for="tax_id" class="form-label">เลขผู้เสียภาษี</label>
                                                <input type="text" class="form-control" id="tax_id" name="tax_id" 
                                                    value="{{ old('tax_id', $item->tax_id) }}" placeholder="กรอกเลขผู้เสียภาษี">
                                            </div>
                                        
                                            <div class="mb-3">
                                                <label for="slip_card" class="form-label">ใบหัก ณ ที่จ่าย</label>
                                                @if ($item->slip_card)
                                                    <div class="mb-2">
                                                        <img src="{{ asset('slip_cards/' . $item->slip_card) }}" alt="Slip Card" width="150">
                                                    </div>
                                                @endif
                                                <input type="file" class="form-control" id="slip_card" name="slip_card" accept="image/*">
                                                <small class="text-muted">* หากไม่ต้องการเปลี่ยนไฟล์ ไม่ต้องเลือกไฟล์</small>
                                            </div>
                                        
                                            <div class="text-center">
                                                <button type="submit" class="btn btn-primary">บันทึก</button>
                                                <a href="{{ route('agent_customer.index') }}" class="btn btn-secondary">ยกเลิก</a>
                                            </div>
                                        </form>
                                        
                                        
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
