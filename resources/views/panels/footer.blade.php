<!-- BEGIN: Footer-->
<footer
    class="footer footer-light {{ $configData['footerType'] === 'footer-hidden' ? 'd-none' : '' }} {{ $configData['footerType'] }}">
    <p class="clearfix mb-0">
        <span class="float-md-start d-block d-md-inline-block mt-25">COPYRIGHT &copy;
            <script>
                document.write(new Date().getFullYear())
            </script>,
            <span class="d-none d-sm-inline-block">All rights Reserved</span>
        </span>
        <span class="float-md-end d-none d-md-block">Developed by Imrul Afnan</span>
    </p>
</footer>
<button class="btn btn-primary btn-icon scroll-top" type="button"><i data-feather="arrow-up"></i></button>
<!-- END: Footer-->
