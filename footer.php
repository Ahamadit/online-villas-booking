<!-- HTML Content Starts Here -->




<div class="footer3-section-area">

    <div class="container">

        <div class="row">

            <div class="col-lg-12">

                <div class="footer-instagram-area">

                    <div class="row">

                        <div class="col-lg-6">
                            <div class="footer-contact-box" data-aos="zoom-in-up" data-aos-duration="1000">
                                <h3 class="text-center mb-4">Send Us A Message</h3>

                                <div class="space16"></div>
                                <div class="row">
                                    <!-- Name Input -->
                                    <div class="col-lg-6 mb-3">
                                        <div class="input-area">
                                            <input type="text" id="userName" class="form-control p-3" placeholder="Your Name*" required>
                                        </div>
                                    </div>

                                    <!-- Mobile Number Input -->
                                    <div class="col-lg-6 mb-3">
                                        <div class="input-area">
                                            <input type="text" id="userMobile" class="form-control p-3" placeholder="Mobile Number*" required>
                                        </div>
                                    </div>

                                    <!-- Message Textarea -->
                                    <div class="col-lg-12 mb-3">
                                        <div class="input-area">
                                            <textarea id="userMessage" class="form-control p-3" rows="5" placeholder="Your Message*" required></textarea>
                                        </div>
                                    </div>



                                    <!-- Send Button -->
                                    <div class="col-lg-12">
                                        <div class="input-area text-end">
                                            <div class="g-recaptcha" data-sitekey="6LedO_QqAAAAAA-29y1Hgi6fa9IiHC2DvKKQfZK1"></div>
                                            <button type="button" class="btn btn-primary px-5 py-3" onclick="sendMessage()">Send Message</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script src="https://www.google.com/recaptcha/api.js" async defer></script>

                        


                        <script>
                            function sendMessage() {
                                let userName = document.getElementById("userName").value.trim();
                                let userMobile = document.getElementById("userMobile").value.trim();
                                let userMessage = document.getElementById("userMessage").value.trim();
                                let recaptchaResponse = grecaptcha.getResponse(); // Get reCAPTCHA response

                                // Extract file name without .php
                                let pageLocation = window.location.pathname.split("/").pop().replace(".php", "");

                                // Validate fields
                                if (!userName || !userMobile || !userMessage) {
                                    alert("Please fill all required fields!");
                                    return;
                                }

                                // Validate reCAPTCHA
                                if (!recaptchaResponse) {
                                    alert("reCAPTCHA verification failed!");
                                    return;
                                }

                                let formData = {
                                    name: userName,
                                    mobile: userMobile,
                                    message: userMessage,
                                    service: pageLocation, // Store only the file name
                                    recaptcha: recaptchaResponse // Send reCAPTCHA response to backend
                                };

                                // First, submit data to the database
                                fetch("submit_form.php", {
                                        method: "POST",
                                        headers: {
                                            "Content-Type": "application/json"
                                        },
                                        body: JSON.stringify(formData)
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        if (data.message) {
                                            alert("Data saved successfully!");

                                            // Construct the WhatsApp message
                                            let whatsappMessage =
                                                `Villa Enquiry%0A%0AName: ${userName}%0AMobile Number: ${userMobile}%0AMessage: ${userMessage}`;

                                            // WhatsApp URL
                                            let whatsappURL = `https://wa.me/9167866113?text=${whatsappMessage}`;

                                            // Redirect to WhatsApp after saving data
                                            window.open(whatsappURL, '_blank');
                                        } else {
                                            alert(data.error || "Something went wrong!");
                                        }
                                    })
                                    .catch(error => {
                                        console.error("Error:", error);
                                        alert("Something went wrong. Please try again later.");
                                    });
                            }
                        </script>










                        <div class="col-lg-6">

                            <div class="instagram-images">

                                <div class="row">

                                    <div class="col-lg-5 col-md-6">

                                        <div class="instagram-posts" data-aos="zoom-in-up" data-aos-duration="800">

                                            <div class="img1">

                                                <img src="assets/hillhouse/hillhouse7.jpg" alt="">

                                            </div>

                                            <div class="icons">

                                                <a href="#"><i class="fa-brands fa-instagram"></i></a>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-lg-7 col-md-6" data-aos="zoom-in-up" data-aos-duration="1000">

                                        <div class="instagram-posts">

                                            <div class="img1">

                                                <img src="assets/img/home/footer1.jpeg" alt="">

                                            </div>

                                            <div class="icons">

                                                <a href="#"><i class="fa-brands fa-instagram"></i></a>

                                            </div>

                                        </div>

                                    </div>



                                    <div class="col-lg-7 col-md-6" data-aos="zoom-in-up" data-aos-duration="1100">

                                        <div class="instagram-posts">

                                            <div class="img1">

                                                <img src="assets/waterfallvilla/waterfall.jpeg" alt="">

                                            </div>

                                            <div class="icons">

                                                <a href="#"><i class="fa-brands fa-instagram"></i></a>

                                            </div>

                                        </div>

                                    </div>



                                    <div class="col-lg-5 col-md-6" data-aos="zoom-in-up" data-aos-duration="1200">

                                        <div class="instagram-posts">

                                            <div class="img1">

                                                <img src="assets/retreatvilla/retraet4.jpeg" alt="">

                                            </div>

                                            <div class="icons">

                                                <a href="#"><i class="fa-brands fa-instagram"></i></a>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="space40"></div>

    <div class="footer3-bottom-section">

        <div class="container">

            <div class="row">

                <div class="col-lg-12">

                    <div class="footer-bottom-area">

                        <div class="footer-menu-area">

                            <div class="footer-logo">

                                <a href="index.php"><img src="assets/img/home/logo.png" alt=""></a>

                            </div>

                            <div class="footer-menu">

                                <ul>

                                    <li><a href="index.php">Home</a></li>

                                    <li class="space24"></li>

                                    <li><a href="about.php">About</a></li>

                                    <li class="space24"></li>

                                    <li><a href="villas.php">Villas</a></li>

                                    <li class="space24"></li>

                                    <li><a href="testmonial.php">Testimonial</a></li>

                                </ul>

                            </div>

                            <div class="footer-menu">

                                <ul>

                                    <li><a href="blog.php">Blog</a></li>

                                    <li class="space24"></li>

                                    <li><a href="villas.php">Gallery</a></li>

                                    <li class="space24"></li>

                                    <li><a href="contact.php">Contact</a></li>

                                    <li class="space24"></li>

                                    <li><a href="happy-customer.php">Happy Customer</a></li>

                                </ul>

                            </div>

                            <div class="footer-menu2">

                                <ul>

                                    <li><a href="#"> <span><i class="fa-solid fa-location-dot"></i></span> <span>

                                                Gold Valley, Sector D, Lonavala.</span></a></li>

                                    <li class="space24"></li>

                                    <li><a href="mailto:info@rahatvillas.com?subject=RFQ%20Enquiry%rahatvillas.com">

                                            <span><i class="fa-solid fa-envelope"></i></span>

                                            <span>info@rahatvillas.com</span></a></li>

                                    <li class="space24"></li>

                                    <li><a href="tel:+919167866113"><span><i class="fa-solid fa-phone"></i></span>

                                            <span> +91 916 7866 113</span></a></li> <br>

                                    <li><a href="tel:+919167866632"><span><i class="fa-solid fa-phone"></i></span>

                                            <span>+91 916 7866 632 </span></a></li>



                                </ul>

                            </div>

                        </div>

                        <div class="row">

                            <div class="col-lg-12">

                                <div class="space48"></div>

                                <div class="copyright-area">

                                    <p>© 2024 Rahat Villas - All Rights Reserved.</p>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<!--===== FOOTER AREA ENDS =======-->



<!--===== JS SCRIPT LINK =======-->

<script src="assets/js/plugins/bootstrap.min.js"></script>

<script src="assets/js/plugins/fontawesome.js"></script>

<script src="assets/js/plugins/aos.js"></script>

<script src="assets/js/plugins/counter.js"></script>

<script src="assets/js/plugins/sidebar.js"></script>

<script src="assets/js/plugins/magnific-popup.js"></script>

<script src="assets/js/plugins/mobilemenu.js"></script>

<script src="assets/js/plugins/owlcarousel.min.js"></script>

<script src="assets/js/plugins/nice-select.js"></script>

<script src="assets/js/plugins/waypoints.js"></script>

<script src="assets/js/plugins/slick-slider.js"></script>

<script src="assets/js/plugins/circle-progress.js"></script>

<script src="assets/js/plugins/gsap.min.js"></script>

<script src="assets/js/plugins/ScrollTrigger.min.js"></script>

<script src="assets/js/plugins/Splitetext.js"></script>

<script src="assets/js/main.js"></script>



</body>

</html>