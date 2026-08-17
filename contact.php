<?php include "header.php" ?>



<!--===== MOBILE HEADER STARTS =======-->



<!--===== HERO AREA STARTS =======-->

<div class="inner-main-hero-area">

    <div class="img1">

        <img src="assets/img/all-images/hero/hero-img1.png" alt="">

    </div>

    <div class="img2">

        <img src="assets/img/all-images/hero/hero-img2.png" alt="">

    </div>

    <div class="container">

        <div class="row">

            <div class="col-lg-5">

                <div class="inner-heading header-heading">

                    <h2>Contact Us</h2>

                    <div class="space24"></div>

                    <p><a href="index.php">Home <i class="fa-solid fa-angle-right"></i></a> </p>

                </div>

            </div>

            <div class="col-lg-2"></div>

            <div class="col-lg-4">

                <div class="auhtor-box">



                </div>

            </div>

        </div>

    </div>

</div>

<!--===== HERO AREA ENDS =======-->



<!--===== CONTACT AREA STARTS =======-->

<div class="contact-inner-area sp6">

    <div class="container">

        <div class="row">

            <div class="col-lg-12">

                <div class="contact-inner-boxarea">

                    <div class="row align-items-center">

                        <!-- ///// ----- this code use for form ---////// -->

                        <!-- <div class="col-lg-8">

                            <div class="contact-input-section">

                                <h3>Send us a Message</h3>

                                <div class="space16"></div>

                                <p>Contact us today and let's start your journey to living excellence. <br> Our

                                    team at Rahat Villas is here to answer your questions.</p>

                                <div class="space12"></div>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="space20"></div>
                                        <div class="input-area">
                                            <input type="text" id="firstName" placeholder="First Name" required>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="space20"></div>
                                        <div class="input-area">
                                            <input type="email" id="email" placeholder="Email" required>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="space20"></div>
                                        <div class="input-area">
                                            <input type="number" id="phone" placeholder="Phone" required>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="space20"></div>
                                        <div class="input-area">
                                            <input type="text" id="subject" placeholder="Subject">
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="space20"></div>
                                        <div class="input-area">
                                            <textarea id="message" placeholder="Your Message*" required></textarea>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="space32"></div>
                                        <div class="input-area text-end">
                                            <button type="button" class="header-btn4" onclick="sendMessage()">Send Message</button>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div> -->

                        <!-- ///// ----- end of the  form ---////// -->
                        <div class="col-lg-8">
                            <div class="contact-input-section">
                                <h3 class="fw-bold text-primary">Discover Luxury Living with Rahat Villas</h3>

                                <div class="space24"></div>

                                <p class="text-muted fs-5">
                                    Your dream home awaits! Experience elegant villas with modern designs, prime locations,
                                    and unmatched comfort. Let us help you find the perfect place to call home.
                                </p>

                                <div class="space20"></div>

                                <h4 class="fw-semibold text-dark">🏡 Why Choose Rahat Villas?</h4>

                                <ul class="list-unstyled mt-3">
                                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Spacious & Elegant Villas</li>
                                    <li class="mb-2"><i class="fas fa-map-marker-alt text-danger me-2"></i> Prime & Secure Locations</li>
                                    <li class="mb-2"><i class="fas fa-handshake text-warning me-2"></i> Smart Investment Opportunities</li>
                                    <li class="mb-2"><i class="fas fa-headset text-info me-2"></i> 24/7 Customer Assistance</li>
                                </ul>

                                <div class="space20"></div>

                                <p class="fs-5">
                                    📩 <strong>Let’s talk!</strong> Get in touch today and take the first step toward your dream villa.
                                </p>
                            </div>
                        </div>



                        <script>
                            function sendMessage() {
                                var firstName = document.getElementById('firstName').value.trim();
                                var email = document.getElementById('email').value.trim();
                                var phone = document.getElementById('phone').value.trim();
                                var subject = document.getElementById('subject').value.trim();
                                var message = document.getElementById('message').value.trim();

                                if (!firstName || !email || !phone || !message) {
                                    alert("Please fill all required fields!");
                                    return;
                                }

                                var whatsappMessage = `Villa Enquiry\n\nFirst Name: ${firstName}\nEmail: ${email}\nPhone: ${phone}\nSubject: ${subject}\nMessage: ${message}`;
                                var encodedMessage = encodeURIComponent(whatsappMessage);
                                var whatsappURL = `https://wa.me/9167866113?text=${encodedMessage}`;

                                window.open(whatsappURL, '_blank');
                            }
                        </script>



                        <div class="col-lg-4">

                            <div class="contact-box">

                                <div class="icons">

                                    <img src="assets/img/icons/contact-icon1.svg" alt="">

                                </div>

                                <div class="content">

                                    <p>Call</p>

                                    <a href="tel:+919167866632">


                                        +91 916-786-6632</a><br>

                                    <a href="tel:+919167866113">

                                        +91 916-786-6113</a>

                                </div>

                            </div>

                            <div class="space20"></div>

                            <div class="contact-box">

                                <div class="icons">

                                    <img src="assets/img/icons/contact-icon2.svg" alt="">

                                </div>

                                <div class="content">

                                    <p>Email</p>

                                    <a href="info@rahatvillas.com">info@rahatvillas.com</a>

                                </div>

                            </div>

                            <div class="space20"></div>

                            <div class="contact-box">

                                <div class="icons">

                                    <img src="assets/img/icons/contact-icon3.svg" alt="">

                                </div>

                                <div class="content">

                                    <p>Location</p>

                                    <a href="#">Gold Valley, Sector D, Lonavala.

                                    </a>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="space80"></div>



        <div class="row">

            <div class="col-lg-4">

                <div class="contact-author-box">

                    <div class="img1">

                        <img src="assets/img/all-images/testimonial/testimonial-img2.png" alt="">

                    </div>

                    <div class="space24"></div>

                    <p>My Name is Alexy Roy, Bot of Rahat Villas. I will answer all your question.</p>

                    <div class="space32"></div>

                    <div class="btn-area1">

                        <a

                            href="https://wa.me/+919167866113?text=Hello!%20I'm%20interested%20in%20learning%20more%20about%20Rahat%20Villas.%20Could%20you%20please%20provide%20me%20with%20details%20on%20availability,%20pricing,%20and%20amenities?%20Thank%20you!"><img

                                src="assets/img/icons/whatsapp.svg" alt=""> Ask Question On WhatsApp</a>

                    </div>

                </div>

            </div>

            <div class="col-lg-8">

                <div class="maps-area">

                    <iframe

                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d120893.26967600775!2d73.3293211218523!3d18.757347808086326!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be801098bdf8145%3A0x696b4a60a5e28658!2sLonavala%2C%20Maharashtra!5e0!3m2!1sen!2sin!4v1731152806401!5m2!1sen!2sin"

                        width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"

                        referrerpolicy="no-referrer-when-downgrade"></iframe>

                </div>

            </div>

        </div>

    </div>

</div>

<!--===== CONTACT AREA ENDS =======-->



<!--===== FOOTER AREA STARTS =======-->

<?php include "footer.php" ?>