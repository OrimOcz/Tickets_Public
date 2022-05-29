// JavaScript Document
jQuery(function($) {

  $(".quantity-btn").on("click", function(e) {
    e.preventDefault();                               // Don't scroll top.
    var $inp = $(this).closest("div").find("input"),  // Get input
        isUp = $(this).is(".quantity-input-up"),      // Is up clicked? (Boolean)
        currVal = parseInt($inp.val(), 10);           // Get curr val
    $inp.val(Math.max(0, currVal += isUp ? 1 : -1));  // Assign new val
  });

  // Other DOM ready code here
  
});