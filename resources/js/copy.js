  function copyURL() {
    $('#secret').addClass('copying');
    var $temp = $('<input>');
    $('body').append($temp);
    $temp.val($('#secret').text()).select();
    document.execCommand("copy");
    $temp.remove();
    $('#secret').removeClass('copying').addClass('copied');
  }
