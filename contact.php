<?php
include 'partials/header.php';

?>



<section class="contact">
    <form action="https://formspree.io/f/mleqkepp" method="POST">
        <div class="content">
            <h2>Contact us</h2>
            <p>We'd love to hear from you! <br>
                Whether you have questions, feedback, or just want to get in touch, the Info Surakarta team is here to assist you. Please reach out to us using any of the methods below, and we’ll get back to you as soon as possible.</p>
        </div>
        <div class="contact__container">
            <div class="contactInfo">
                <div class="box">
                    <div class="icon"><i class="uil uil-map-marker-alt"></i></div>
                    <div class="text">
                        <h3>Address</h3>
                        <p>Jl. Siwalankerto Permai No.1A, Siwalankerto, Wonocolo District <br> Surabaya, East Java, <br> 60236</p>
                    </div>
                </div>
                <div class="box">
                    <div class="icon"><i class="uil uil-phone"></i></div>
                    <div class="text">
                        <h3>Phone</h3>
                        <p>+62 896-1606-5384</p>
                    </div>
                </div>
                <div class="box">
                    <div class="icon"><i class="uil uil-envelope"></i></div>
                    <div class="text">
                        <h3>Email</h3>
                        <p>infosurakarta.ind@gmail.com</p>
                    </div>
                </div>
            </div>
            <div class="contactForm">
                <form action="">
                    <h2>Send Messege</h2>
                    <div class="inputBox">
                        <input type="text" name="Full Name" required="required">
                        <span>Full Name</span>
                    </div>
                    <div class="inputBox">
                        <input type="text" name="email" required="required">
                        <span>Email</span>
                    </div>
                    <div class="inputBox">
                        <textarea name="message" required="required"></textarea>
                        <span>Type your Messege</span>
                    </div>
                    <div class="inputBox">
                        <input type="submit" name="" value="Send">
                    </div>
                </form>
            </div>
        </div>
    </form>
</section>




<?php
include 'partials/footer.php';

?>