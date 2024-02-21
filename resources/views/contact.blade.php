@extends('layouts.layout')
@section('content')

<main id="main">

  <!-- ======= Breadcrumbs ======= -->
  <section id="breadcrumbs" class="breadcrumbs breadcrumbs-label">
    <div class="container">

      <ol>
        <li><a href="/" class="breadcrumbs-link">Home</a></li>
        <li>Contact</li>
      </ol>
      <h2 style="color: white;">Contact Us</h2>

    </div>
  </section><!-- End Breadcrumbs -->

  <!-- ======= Portfolio Details Section ======= -->

  <!-- ======= Contact Section ======= -->
  <section id="contact" class="contact">
    <div class="container" data-aos="fade-up">

      <div class="section-title">
        <h2>Contact us</h2>
        <p>Speak to our experts now.</p>
      </div>

      <div class="row">

        <div class="col-lg-5 d-flex align-items-stretch">
          <div class="info">
            <div class="address">
              <i class="icofont-google-map"></i>
              <h4>Location:</h4>
              <p> NO. 5, unity street,<br>
                Chika Off Airport Road,<br>
                Abuja-FCT. <br></p>
            </div>

            <div class="email">
              <i class="icofont-envelope"></i>
              <h4>Email:</h4>
              <p>info@aprodigitals.com</p>
            </div>

            <div class="phone">
              <i class="icofont-phone"></i>
              <h4>Call:</h4>
              <p> +234 909 219 8646</p>
            </div>

            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3940.7678178222745!2d7.405428214293037!3d8.993499993545482!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x104e73a5520e7d2f%3A0xc84193652ec5212a!2sAPRO%20DIGITAL%20SERVICES!5e0!3m2!1sen!2sng!4v1615847402999!5m2!1sen!2sng" frameborder="0" style="border:0; width: 100%; height: 290px;" allowfullscreen></iframe>
          </div>

        </div>

        <div class="col-lg-7 mt-5 mt-lg-0 d-flex align-items-stretch">
          <div class="container box">

            <form action="{{ route('contact.email') }}" method="post" role="form" class="php-email-form">
              @csrf

              <h6 class="md-1">Feed back form</h6>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="name">Your Name</label>
                  <input type="text" name="name" class="form-control" value="{{ old('name') }}" id="name" data-rule="minlen:4" data-msg="Please enter at least 4 chars" />
                  <div class="validate"></div>
                  @if ($errors->has('name'))
                  <span class="text-danger font-weight-bold" role="alert">
                    {{ $errors->first('name') }}
                  </span>
                  @endif
                </div>
                <div class="form-group col-md-6">
                  <label for="name">Your Email</label>
                  <input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}" data-rule="email" data-msg="Please enter a valid email" />
                  <div class="validate"></div>
                  @if ($errors->has('email'))
                  <span class="text-danger font-weight-bold" role="alert">
                    {{ $errors->first('email') }}
                  </span>
                  @endif
                </div>
              </div>
              <div class="form-group">
                <label for="name">Subject</label>
                <input type="text" class="form-control" name="subject" value="{{ old('subject') }}" id="subject" data-rule="minlen:4" data-msg="Please enter at least 8 chars of subject" />
                <div class="validate"></div>
                @if ($errors->has('subject'))
                <span class="text-danger font-weight-bold" role="alert">
                  {{ $errors->first('subject') }}
                </span>
                @endif
              </div>
              <div class="form-group">
                <label for="name">Message</label>
                <textarea class="form-control" name="message" rows="10" data-rule="required" data-msg="Please write something for us">{{ old('message') }}</textarea>
                <div class="validate"></div>
                @if ($errors->has('message'))
                <span class="text-danger font-weight-bold" role="alert">
                  {{ $errors->first('message') }}
                </span>
                @endif
              </div>
              <div class="mb-3">
                <div class="loading">Loading</div>
                <div class="error-message"></div>
                <div class="sent-message">Your message has been sent. Thank you!</div>
              </div>
              <div class="text-center"><button type="submit" name="send">Send Message</button></div>
            </form>
          </div>

        </div>

      </div>
  </section><!-- End Contact Section -->

</main><!-- End #main -->
@endsection