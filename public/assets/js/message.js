

(function($) {
    "use strict"


    $wire.on('switch' , (event)=>{
        Swal.fire({
            position: "top-start",
            icon: "success",
            title: event,
            showConfirmButton: false,
            timer: 1500
            });
    });

})(jQuery);