<?php	

include "__header.php";



    session_destroy();
    session_unset();


    header("Location: /");

?>

            <section class="py-8 bg-white">
                <div class="container my-lg-4">
                    <div class="row">
                        <div class="offset-lg-2 col-lg-8 col-md-12 col-12 mb-8">
                            <h1 class="display-2 fw-bold mb-3">You've been logged out <span class="text-success">successfully</span>.</h1>
                        </div>
                    </div>
                </div>
           </section>




<?php	include "__footer.php";	?>
