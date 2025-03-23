@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')
<section id="contact">
    <h2>Contact Us</h2>
    <p>Email: info@evgpetcare.com</p>
    <p>Phone: (123) 456-7890</p>
    <form action="#" method="POST">
        @csrf
        <input type="text" name="name" placeholder="Your Name" required>
        <input type="email" name="email" placeholder="Your Email" required>
        <textarea name="message" placeholder="Your Message" required></textarea>
        <button type="submit">Submit</button>
    </form>
</section>
@endsection
