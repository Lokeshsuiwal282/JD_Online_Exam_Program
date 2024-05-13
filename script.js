$(document).ready(function(){
    // Show login form by default
    $('#pills-login').addClass('show active');
    
    // Show login form when clicking on login tab
    $('#tab-login').click(function(){
        $('#pills-login').addClass('show active');
        $('#pills-register').removeClass('show active');
    });
    
    // Show registration form when clicking on registration tab
    $('#tab-register').click(function(){
        $('#pills-login').removeClass('show active');
        $('#pills-register').addClass('show active');
    });
});
