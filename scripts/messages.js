$(window).load(function(){
  var origBottom = numb($('#message-wrapper').css('height'));
  var leaveExposed = 5; // amount to leave exposed (in px)
  
  // after x seconds, slide message up
  var timerFunc = function() {
    messageTimer = setTimeout(function() {
      //$('#message-wrapper').slideUp('slow');
      $('#message-wrapper').animate({
        top: leaveExposed - origBottom // this will leave 5 px showing at top
      }, 1000, rebind);
    }, 4000);
  }
  timerFunc();
  var clearTimer = function(){
    clearTimeout(messageTimer);
  }
  // if mouseover message, stop timer
  $('#message-wrapper')
    .mouseover(clearTimer)
    .mouseout(timerFunc) // restart timer
    .click(function() {
      clearTimer();
      $(this).stop().animate({top: leaveExposed - origBottom}, 200, rebind);
    });
    
  /**
   * Ensure that a number is a number... or zero
   */
  function numb(num) {
    return parseInt(num) || 0;
  }; // </ numb() >
  
  function rebind() {
    // unbind the old over&out
    $('#message-wrapper')
      .unbind('mouseover', clearTimer)
      .unbind('mouseout', timerFunc)
      .mouseover(function() {
        $(this).stop().animate({top: 0}, 200);
      })
      .mouseout(function(){
        $(this).stop().animate({top: leaveExposed - origBottom}, 400);
      });
  }

});