/**
 * Permute text and values of elements when a new element is inserted.
 *
 * @param  {object} currentLabel        
 * @param  {object} previousOrNextLabel 
 * @param  {object} currentRank         
 * @param  {object} previousOrNextRank  
 */
function permuteTextAndValue(currentLabel, previousOrNextLabel, currentRank, previousOrNextRank) {

    $temp = currentLabel.text();
    currentLabel.text(previousOrNextLabel.text());
    previousOrNextLabel.text($temp);
    currentRank.val(currentLabel.text());
    previousOrNextRank.val(previousOrNextLabel.text());   
}

/**
 * Set reorder controls on up and down links : new element insertion and text and value of previous elements permutation.
 *
 * @param {object} up   Up link.
 * @param {object} down Down link.
 */
function setReorderControls(up, down) {

    up.click(function(event) {
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

/**
 * Reorder rank and label (when an collection item is removed).
 *
 * @param  {object} collectionContainer Container for chapter or paragraphs.
 * @param  {string} collectionItemClass Class of the reordered items.
 */
function reorderRankAndLabel(collectionContainer, collectionItemClass) {

    var collection = collectionContainer.find(collectionItemClass);

    if (collection.length > 0) {
        collection.each(function(index) {                    
            rank = $(this).find('[id*="rank"]').first();
            rank.val(index);
            label = $(this).children('label');
            label.text(index);       
        });              
    }  
}

/**
 * Set fields design (chapters and paragraphs).
 * Insert up and down controls if needed.
 * Set rank if needed. 
 */
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

    // Initialize page on first loading.
    initialize();    

    // Update page when a new element is created.
    $(document).on('click', ".text-primary", function(event){
        initialize();
    });             

    // Reorder ranks and labels when a collection item is removed.
    $(document).on('click', ".text-danger", function(event){
        if (event.preventDefault) event.preventDefault(); else event.returnValue = false;
        
        // Chapters
        reorderRankAndLabel($('#tutorial_tutorialChapter'), '.field-fbn_guidebundle_tutorialchapter');

        // Chapters Paras
        var chaptersParasContainer = $('div[id*="tutorial_tutorialChapter_"]').not('[id*="tutorialChapterParas"]');
        chaptersParasContainer.each(function(index) {
            reorderRankAndLabel($(this), '.field-fbn_guidebundle_tutorialchapterpara');
        });                                
    }); 
});

