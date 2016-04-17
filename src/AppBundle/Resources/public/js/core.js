path = {
    env: window.location.href.search("app_dev.php/") > 0 ? "/app_dev.php" : "",
    images: "/bundles/app/images/",
    components: "/bundles/app/components/",
}

/*
 Toastr
 =======================

 Add Toastr Options
 */
toastr.options = {
    "closeButton": false,
    "debug": false,
    "newestOnTop": false,
    "progressBar": false,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "10000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
}

/*
 Ready
 =======================

 These will be the functions that initialise when the document loads
 */
$(document).ready(function (){

});