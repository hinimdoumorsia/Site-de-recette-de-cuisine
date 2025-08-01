$(document).ready(function(){
    (function($) {
        "use strict";

        // Validate contactForm form
        $(function() {
            $('#contactForm').validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 2
                    },
                    subject: {
                        required: true,
                        minlength: 4
                    },
                    number: {
                        required: true,
                        minlength: 5
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    message: {
                        required: true,
                        minlength: 20
                    }
                },
                messages: {
                    name: {
                        required: "Please enter your name.",
                        minlength: "Your name must be at least 2 characters long."
                    },
                    subject: {
                        required: "Please enter a subject.",
                        minlength: "Your subject must be at least 4 characters long."
                    },
                    number: {
                        required: "Please enter a number.",
                        minlength: "Your number must be at least 5 characters long."
                    },
                    email: {
                        required: "Please enter your email address.",
                        email: "Please enter a valid email address."
                    },
                    message: {
                        required: "Please write your message.",
                        minlength: "Your message must be at least 20 characters long."
                    }
                },
                submitHandler: function(form) {
                    $(form).ajaxSubmit({
                        type: "POST",
                        data: $(form).serialize(),
                        url: "contact_process.php",
                        success: function() {
                            $('#contactForm :input').attr('disabled', 'disabled');
                            $('#contactForm').fadeTo("slow", 1, function() {
                                $('#success').fadeIn();
                                $('#success').text('Thank you! Your message has been sent.');
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error('Error details:', xhr.responseText);
                            $('#contactForm').fadeTo("slow", 1, function() {
                                $('#error').fadeIn();
                                $('#error').text('Oops! Something went wrong. Please try again.');
                            });
                        }
                    });
                }
            });
        });
    })(jQuery);
});
$(document).ready(function(){
    (function($) {
        "use strict";

        // Validate contactForm form
        $(function() {
            $('#contactForm').validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 2
                    },
                    subject: {
                        required: true,
                        minlength: 4
                    },
                    number: {
                        required: true,
                        minlength: 5
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    message: {
                        required: true,
                        minlength: 20
                    }
                },
                messages: {
                    name: {
                        required: "Please enter your name.",
                        minlength: "Your name must be at least 2 characters long."
                    },
                    subject: {
                        required: "Please enter a subject.",
                        minlength: "Your subject must be at least 4 characters long."
                    },
                    number: {
                        required: "Please enter a number.",
                        minlength: "Your number must be at least 5 characters long."
                    },
                    email: {
                        required: "Please enter your email address.",
                        email: "Please enter a valid email address."
                    },
                    message: {
                        required: "Please write your message.",
                        minlength: "Your message must be at least 20 characters long."
                    }
                },
                submitHandler: function(form) {
                    $(form).ajaxSubmit({
                        type: "POST",
                        data: $(form).serialize(),
                        url: "contact_process.php",
                        success: function() {
                            $('#contactForm :input').attr('disabled', 'disabled');
                            $('#contactForm').fadeTo("slow", 1, function() {
                                $('#success').fadeIn();
                                $('#success').text('Thank you! Your message has been sent.');
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error('Error details:', xhr.responseText);
                            $('#contactForm').fadeTo("slow", 1, function() {
                                $('#error').fadeIn();
                                $('#error').text('Oops! Something went wrong. Please try again.');
                            });
                        }
                    });
                }
            });
        });
    })(jQuery);
});
