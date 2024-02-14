<!-- BEGIN: Vendor JS-->
<script src="{{ asset(mix('vendors/js/vendors.min.js')) }}"></script>
<!-- BEGIN Vendor JS-->
<!-- BEGIN: Page Vendor JS-->
<script src="{{ asset(mix('vendors/js/ui/jquery.sticky.js')) }}"></script>
@yield('vendor-script')
<script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/polyfill.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/jstree.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pagination/jquery.bootpag.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pagination/jquery.twbsPagination.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>

<!-- END: Page Vendor JS-->
<!-- BEGIN: Theme JS-->
<script src="{{ asset(mix('js/core/app-menu.js')) }}"></script>
<script src="{{ asset(mix('js/core/app.js')) }}"></script>

<!-- custome scripts file for user -->
<script src="{{ asset(mix('js/core/scripts.js')) }}"></script>

@if ($configData['blankPage'] === false)
    <script src="{{ asset(mix('js/scripts/customizer.js')) }}"></script>
@endif
<!-- END: Theme JS-->
<!-- BEGIN: Page JS-->
@yield('page-script')
<script src="{{ asset(mix('js/scripts/pages/page-profile.js')) }}"></script>
<script src="{{ asset(mix('js/scripts/extensions/ext-component-sweet-alerts.js')) }}"></script>
<script src="{{ asset(mix('js/scripts/extensions/ext-component-tree.js')) }}"></script>
<script src="{{ asset(mix('js/scripts/pagination/components-pagination.js')) }}"></script>
<script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>

@if (Session::has('success'))
    <script>
        $(function() {
            'use strict'
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: '{{ Session::get('success') }}',
                showConfirmButton: false,
                timer: 1500,
                customClass: {
                    confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false
            })
        })
    </script>
@endif

@if (Session::has('error'))
    <script>
        $(function() {
            'use strict'
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: '{{ Session::get('error') }}',
                showConfirmButton: false,
                timer: 1500,
                customClass: {
                    confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false
            })
        })
    </script>
@endif
<!-- END: Page JS-->
