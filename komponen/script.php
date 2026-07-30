<!-- Core Vendor -->
<script src="./assets/js/vendor.min.js"></script>

<!-- Bootstrap -->
<script src="./assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

<!-- Simplebar -->
<script src="./assets/libs/simplebar/dist/simplebar.min.js"></script>

<!-- Theme -->
<script src="./assets/js/theme/app.init.js"></script>
<script src="./assets/js/theme/theme.js"></script>
<script src="./assets/js/theme/app.min.js"></script>
<script src="./assets/js/theme/sidebarmenu.js"></script>

<!-- Iconify -->
<script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>

<!-- Owl Carousel -->
<script src="./assets/libs/owl.carousel/dist/owl.carousel.min.js"></script>

<!-- ApexCharts -->
<script src="./assets/libs/apexcharts/dist/apexcharts.min.js"></script>

<?php if ($page == "home") { ?>

    <!-- Dashboard JS -->
    <script src="./assets/js/dashboards/dashboard.js"></script>

<?php } ?>

<?php if (
    $page == "tambahbarang" ||
    $page == "editbarang"
) { ?>

    <!-- Quill -->
    <script src="./assets/libs/quill/dist/quill.min.js"></script>
    <script src="./assets/js/forms/quill-init.js"></script>

<?php } ?>

<!-- Dropzone -->
<script src="./assets/libs/dropzone/dist/min/dropzone.min.js"></script>

<!-- Select2 -->
<script src="./assets/libs/select2/dist/js/select2.full.min.js"></script>
<script src="./assets/libs/select2/dist/js/select2.min.js"></script>
<script src="./assets/js/forms/select2.init.js"></script>

<!-- Repeater -->
<script src="./assets/libs/jquery.repeater/jquery.repeater.min.js"></script>
<script src="./assets/js/forms/repeater-init.js"></script>

<!-- Validation -->
<script src="./assets/libs/jquery-validation/dist/jquery.validate.min.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>