@php
    use Illuminate\Support\Str;

    $prefix = '';
    $member = App\Models\Backend\AdminModel::find(Auth::guard('admin')->id());
    $image = 'backend/assets/media/avatars/300-1.jpg';
@endphp

<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar"
    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px"
    data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
    <!--begin::Logo-->
    <div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
        <a href="{{ url($segment) }}">
            <img alt="Logo" src="backend/assets/media/logos/default-dark.svg"
                class="h-25px app-sidebar-logo-default" />
            <img alt="Logo" src="backend/assets/media/logos/default-small.svg"
                class="h-20px app-sidebar-logo-minimize" />
        </a>
        <div id="kt_app_sidebar_toggle"
            class="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-primary h-30px w-30px position-absolute top-50 start-100 translate-middle rotate"
            data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body"
            data-kt-toggle-name="app-sidebar-minimize">
            <i class="ki-duotone ki-black-left-line fs-3 rotate-180">
                <span class="path1"></span>
                <span class="path2"></span>
            </i>
        </div>
    </div>
    <!--end::Logo-->

    <div class="app-sidebar-menu overflow-hidden flex-column-fluid">
        <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper">
            <div id="kt_app_sidebar_menu_scroll" class="scroll-y my-5 mx-3" data-kt-scroll="true"
                data-kt-scroll-activate="true" data-kt-scroll-height="auto"
                data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer"
                data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px"
                data-kt-scroll-save-state="true">
                <div class="menu menu-column menu-rounded menu-sub-indention fw-semibold fs-6" id="#kt_app_sidebar_menu"
                    data-kt-menu="true" data-kt-menu-expand="false">

                    @php $menus = \Helper::mainMenu(); @endphp
                    @if ($menus)
                        @foreach ($menus as $key => $menu)
                            @php
                                $arraymenu = [];
                                $subs = \Helper::subMenu($menu->id);
                                if ($subs->count() > 0) {
                                    foreach ($subs as $submenu) {
                                        $arraymenu[] = $submenu->url;
                                    }
                                }
                                $mainActive =
                                    request()->is(trim($menu->url, '/')) ||
                                    collect($arraymenu)->contains(request()->path());
                            @endphp

                            @if ($menu->position == 'topic')
                                <div class="menu-item pt-5">
                                    <div class="menu-content">
                                        <span
                                            class="menu-heading fw-bold text-uppercase fs-7">{{ $menu->name }}</span>
                                    </div>
                                </div>
                            @else
                                <!-- Begin:Menu -->
                                @if ($subs->count() <= 0)
                                    <div class="menu-item">
                                        <a class="menu-link @if (request()->is(trim($menu->url, '/'))) active @endif"
                                            href="{{ $menu->url }}" style="text-decoration: none;">
                                            <span class="menu-icon">
                                                <i class="{{ $menu->icon }}"> </i>
                                            </span>
                                            <span class="menu-title"
                                                style="font-size: 14px; font-weight: 500;">{{ $menu->name }}</span>
                                        </a>
                                    </div>
                                @else
                                    <div data-kt-menu-trigger="click" id="main_menu_{{ $menu->id }}"
                                        class="menu-item menu-accordion @if ($mainActive) show @endif">
                                        <span class="menu-link">
                                            <span class="menu-icon">
                                                <i class="{{ $menu->icon }}"> </i>
                                            </span>
                                            <span class="menu-title">{{ $menu->name }}</span>
                                            <span class="menu-arrow"></span>
                                        </span>
                                        <div class="menu-sub menu-sub-accordion">
                                            @foreach ($subs as $sub)
                                                @php
                                                    $isActive =
                                                        Str::startsWith(request()->path(), trim($sub->url, '/')) ||
                                                        in_array($folder, $arraymenu);
                                                @endphp
                                                <div class="menu-item">
                                                    <a class="menu-link @if ($isActive) active @endif"
                                                        href="{{ $sub->url }}">
                                                        <span class="menu-bullet">
                                                            <span class="bullet bullet-dot"></span>
                                                        </span>
                                                        <span class="menu-title">{{ $sub->name }}</span>
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            @endif
                        @endforeach
                    @endif

                    {{-- <!-- Help Section -->
                    <div class="menu-item pt-5">
                        <div class="menu-content">
                            <span class="menu-heading fw-bold text-uppercase fs-7">Help</span>
                        </div>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link" href="javascript:void(0);">
                            <span class="menu-icon">
                                <i class="ki-duotone ki-rocket fs-2"></i>
                            </span>
                            <span class="menu-title">Components</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link" href="javascript:void(0);">
                            <span class="menu-icon">
                                <i class="ki-duotone ki-abstract-26 fs-2"></i>
                            </span>
                            <span class="menu-title">Documentation</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link" href="javascript:void(0);">
                            <span class="menu-icon">
                                <i class="ki-duotone ki-code fs-2"></i>
                            </span>
                            <span class="menu-title">Changelog v8.2.0</span>
                        </a>
                    </div> --}}

                </div>
            </div>
        </div>
    </div>

    <!--begin::Footer-->
    <div class="app-sidebar-footer flex-column-auto pt-2 pb-6 px-6" id="kt_app_sidebar_footer">
        <a href="{{ url("$segment/logout") }}"
            class="btn btn-flex flex-center btn-custom btn-primary overflow-hidden text-nowrap px-0 h-40px w-100"
            data-bs-trigger="hover" data-bs-dismiss-="click" title="Sign Out">
            <span class="btn-label">Sign Out</span>
            <i class="ki-duotone ki-document btn-icon fs-2 m-0"></i>
        </a>
    </div>
    <!--end::Footer-->
</div>

<style>
    a.menu-link.active {
        background-color: #d94949 !important;
    }

    a.menu-link {
        text-decoration: none !important;
    }
</style>
