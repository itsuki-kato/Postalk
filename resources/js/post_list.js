$(function() {
    $('.card-open').on('click', function() {
        $(this).toggleClass('active');
        $(this).next('.card-inner').slideToggle();
    });
});
