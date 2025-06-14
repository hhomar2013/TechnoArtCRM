<script>
    $wire.on('message' , (event)=>{
        Swal.fire({
            // position: "top-start",
            position: "center",
            title: event.message,
            type: "success",
            showConfirmButton: false,
            timer: 1500
            });
    });


    $wire.on('error' , (event)=>{
        Swal.fire({
            // position: "top-start",
            position: "center",
            title: event.message,
            type: "error",
            showConfirmButton: false,
            timer: 1500
            });
    });
</script>


