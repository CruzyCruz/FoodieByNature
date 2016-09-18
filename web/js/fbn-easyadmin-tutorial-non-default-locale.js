/**
 * Set fields design (chapters and paragraphs).
 */
function initialize() {
    // Set fields design
    $('.field-fbn_guidebundle_tutorialchapter').css('border-style', 'solid');
    $('.field-fbn_guidebundle_tutorialchapter').css('border-color', 'red');
    $('.field-fbn_guidebundle_tutorialchapterpara').css('border-style', 'solid');
    $('.field-fbn_guidebundle_tutorialchapterpara').css('border-color', 'green'); 
}

$(function() {

    // Initialize page on first loading.
    initialize();    
});

