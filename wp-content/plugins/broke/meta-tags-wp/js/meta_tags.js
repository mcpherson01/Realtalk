jQuery(function($) {
  $(document).ready(function(){
    init();

    // Init events
    $('.mts-js-channel').click(toggleActive);
    $('.mts-js-img').click(setImage);
    $('.mts-js-img-remove').click(removeImage);
    $('.mts-js-title').keyup(setTitle);
    $('.mts-js-description').keyup(setDescription);
    $('.mts-js-fill-title').click(fillTitle);
    $('.mts-js-fill-description').click(fillDescription);

    // Check for Yoast and enable fill description
    var $yoastDesciption = $('#yoast_wpseo_metadesc');
    if ($yoastDesciption.length > 0) $('.mts-js-fill-description')[0].style.display = 'inline';
  });

  function init() {
    var channels = JSON.parse(localStorage.getItem('mtsChannels')) || ["google", "facebook", "twitter"];
    localStorage.setItem("mtsChannels", JSON.stringify(channels));

    channels.forEach(function(channel) {
      $('#' + channel).addClass('is-active');
      $('[data-channel="'+ channel +'"]').addClass('is-active');
    });
  }

  function saveChannels(channel) {
    var channels = JSON.parse(localStorage.getItem('mtsChannels'));
    var index = channels.indexOf(channel);
    if (index > -1) {
      channels.splice(index, 1);
    } else {
      channels.push(channel);
    }
    localStorage.setItem("mtsChannels", JSON.stringify(channels));
  }

  function toggleActive(e) {
    var $this = $(this);
    var channel = $this.data('channel');
    $this.toggleClass('is-active');
    $('#' + channel).toggleClass('is-active');
    saveChannels(channel);
  }

  function setImage(e) {
    if (this.window === undefined) {
      this.window = wp.media({
        title: 'Insert a media',
        library: {type: 'image'},
        multiple: false,
        button: {text: 'Insert'}
      });

      var self = this;
      var first, img;
      this.window.on('select', function(e) {
        var first = self.window.state().get('selection').first().toJSON();

        if (first) {
          setImagePreview(first.url);

          img = new Image();
          img.onload = function () {
            var height = this.height * 360 / this.width;
            var slack = $('.js-slack-image')[0].style.height = height + 'px';
          };
          img.src = first.url;
        }
      });
    }

    this.window.open();
    return false;
  }

  function setImagePreview(url) {
    $('.mts-js-img-input')[0].value = url;
    $('.mts-js-img')[0].style.backgroundImage = 'url("' + url + '")';
    $('.mts-js-p-image').css('background-image', 'url("' + url + '")');
    $('.mts-js-p-img').attr('src', url);
  }

  function removeImage(e) {
    e.preventDefault();
    $('.mts-js-img-input')[0].value = "";
    $('.mts-js-img')[0].style.backgroundImage = 'url("")';
    $('.mts-js-p-image').css('background-image', '');
    $('.mts-js-p-img').attr('src', '');
  }

  function setTitle(e) {
    var value = this.value;
    if (value) {
      $('.mts-js-p-title').text(value);
    } else {
      $('.mts-js-p-title').text('Enter Custom Title');
    }
  }

  function setDescription(e) {
    var value = this.value;
    if (value) {
      $('.mts-js-p-description').text(truncate(value, 160));
    } else {
      $('.mts-js-p-description').text('Enter Custom Description. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.');
    }
  }

  function fillTitle(e) {
    e.preventDefault();
    var value = $('.editor-post-title__input').val();
    $('.mts-js-title').val(value);
    console.log(value);
  }

  function fillDescription(e) {
    e.preventDefault();
    var value = $('#yoast_wpseo_metadesc').val();
    $('.mts-js-description').val(value);
  }

  // --------------------------------------------
  // Helper functions
  // --------------------------------------------
  function truncate(str, limit) {
    var trimmable = '\u0009\u000A\u000B\u000C\u000D\u0020\u00A0\u1680\u180E\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200A\u202F\u205F\u2028\u2029\u3000\uFEFF';
    var reg = new RegExp('(?=[' + trimmable + '])');
    var words = str.split(reg);
    var count = 0;
    var words = words.filter(function(word) {
      count += word.length;
      return count <= limit;
    }).join('');

    if (words.substr(words.length - 1) === ".") {
      return words
    } else if (count >= limit) {
      return words + '...';
    } else {
      return words
    }
  }
});
