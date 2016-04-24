function permuteTextAndValue(currentLabel, previousOrNextLabel, currentRank, previousOrNextRank) {
    $temp = currentLabel.text();
    currentLabel.text(previousOrNextLabel.text());
    previousOrNextLabel.text($temp);
    currentRank.val(currentLabel.text());
    previousOrNextRank.val(previousOrNextLabel.text());   
}

function setReorderControls(up, down) {
    up.click(function(event){
      if (event.preventDefault) event.preventDefault(); else event.returnValue = false;
        
      var current = $(this).closest('[class*="field-fbn_guidebundle_tutorialchapter"]');
      var currentLabel = current.children('label');
      var currentRank = current.find('[id*="rank"]').first();

      var previous = current.prev('[class*="field-fbn_guidebundle_tutorialchapter"]');
      var previousLabel = previous.children('label');
      var previousRank = previous.find('[id*="rank"]').first();

      if(previous.length !== 0){
        current.insertBefore(previous);
        permuteTextAndValue(currentLabel, previousLabel, currentRank, previousRank);
      }
    });

    down.click(function(event) {    
      if (event.preventDefault) event.preventDefault(); else event.returnValue = false;

      var current = $(this).closest('[class*="field-fbn_guidebundle_tutorialchapter"]');
      var currentLabel = current.children('label');
      var currentRank = current.find('[id*="rank"]').first();

      var next = current.next('[class*="field-fbn_guidebundle_tutorialchapter"]');
      var nextLabel = next.children('label');
      var nextRank = next.find('[id*="rank"]').first();   

      if(next.length !== 0){
        current.insertAfter(next);
        permuteTextAndValue(currentLabel, nextLabel, currentRank, nextRank);

      }
    });    
}

function initialize() {
    // Set fields design
    $('.field-fbn_guidebundle_tutorialchapter').css('border-style', 'solid');
    $('.field-fbn_guidebundle_tutorialchapter').css('border-color', 'red');
    $('.field-fbn_guidebundle_tutorialchapterpara').css('border-style', 'solid');
    $('.field-fbn_guidebundle_tutorialchapterpara').css('border-color', 'green'); 

    // Insert up and down controls if needed
    var divsDanger = $('.text-danger').parent();
    divsDanger.each(function(index, value) {
        if ($(this).prev().attr('class') !== 'text-right field-collection-item-action') {
            $('<div class="text-right field-collection-item-action"><a href="#" class="reorder-up text-primary"><i class="fa fa-long-arrow-up"></i>up </a><a href="#" class="reorder-down text-primary"><i class="fa fa-long-arrow-down">down </i></a></div>').insertBefore($(this));
            var up = $(this).prev().children('.reorder-up');
            var down = $(this).prev().children('.reorder-down');
            setReorderControls(up, down);
        }
    });

    // Set rank if needed
    var emptyRanks = $('[class*="field-fbn_guidebundle_tutorialchapter"]').find('[id*="rank"]').filter(function() {return !this.value;});
    emptyRanks.each(function(index, value) {
        var label = $(this).parents('[class*="field-fbn_guidebundle_tutorialchapter"]').children('label').first();
        $(this).val(label.text());
    });
}

$(function() {
    initialize();

    $(document).on('click', ".text-primary", function(event){
        initialize();
    });             
});

