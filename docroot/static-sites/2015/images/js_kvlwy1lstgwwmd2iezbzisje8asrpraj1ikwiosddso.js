(function ($) {

/**
 * A progressbar object. Initialized with the given id. Must be inserted into
 * the DOM afterwards through progressBar.element.
 *
 * method is the function which will perform the HTTP request to get the
 * progress bar state. Either "GET" or "POST".
 *
 * e.g. pb = new progressBar('myProgressBar');
 *      some_element.appendChild(pb.element);
 */
Drupal.progressBar = function (id, updateCallback, method, errorCallback) {
  var pb = this;
  this.id = id;
  this.method = method || 'GET';
  this.updateCallback = updateCallback;
  this.errorCallback = errorCallback;

  // The WAI-ARIA setting aria-live="polite" will announce changes after users
  // have completed their current activity and not interrupt the screen reader.
  this.element = $('<div class="progress" aria-live="polite"></div>').attr('id', id);
  this.element.html('<div class="bar"><div class="filled"></div></div>' +
                    '<div class="percentage"></div>' +
                    '<div class="message">&nbsp;</div>');
};

/**
 * Set the percentage and status message for the progressbar.
 */
Drupal.progressBar.prototype.setProgress = function (percentage, message) {
  if (percentage >= 0 && percentage <= 100) {
    $('div.filled', this.element).css('width', percentage + '%');
    $('div.percentage', this.element).html(percentage + '%');
  }
  $('div.message', this.element).html(message);
  if (this.updateCallback) {
    this.updateCallback(percentage, message, this);
  }
};

/**
 * Start monitoring progress via Ajax.
 */
Drupal.progressBar.prototype.startMonitoring = function (uri, delay) {
  this.delay = delay;
  this.uri = uri;
  this.sendPing();
};

/**
 * Stop monitoring progress via Ajax.
 */
Drupal.progressBar.prototype.stopMonitoring = function () {
  clearTimeout(this.timer);
  // This allows monitoring to be stopped from within the callback.
  this.uri = null;
};

/**
 * Request progress data from server.
 */
Drupal.progressBar.prototype.sendPing = function () {
  if (this.timer) {
    clearTimeout(this.timer);
  }
  if (this.uri) {
    var pb = this;
    // When doing a post request, you need non-null data. Otherwise a
    // HTTP 411 or HTTP 406 (with Apache mod_security) error may result.
    $.ajax({
      type: this.method,
      url: this.uri,
      data: '',
      dataType: 'json',
      success: function (progress) {
        // Display errors.
        if (progress.status == 0) {
          pb.displayError(progress.data);
          return;
        }
        // Update display.
        pb.setProgress(progress.percentage, progress.message);
        // Schedule next timer.
        pb.timer = setTimeout(function () { pb.sendPing(); }, pb.delay);
      },
      error: function (xmlhttp) {
        pb.displayError(Drupal.ajaxError(xmlhttp, pb.uri));
      }
    });
  }
};

/**
 * Display errors on the page.
 */
Drupal.progressBar.prototype.displayError = function (string) {
  var error = $('<div class="messages error"></div>').html(string);
  $(this.element).before(error).hide();

  if (this.errorCallback) {
    this.errorCallback(this);
  }
};

})(jQuery);
;
(function ($) {
Drupal.settings.views = Drupal.settings.views || {'ajax_path': '/views/ajax'};

Drupal.quicktabs = Drupal.quicktabs || {};

Drupal.quicktabs.getQTName = function (el) {
  return el.id.substring(el.id.indexOf('-') +1);
}

Drupal.behaviors.quicktabs = {
  attach: function (context, settings) {
    $.extend(true, Drupal.settings, settings);
    $('.quicktabs-wrapper', context).once(function(){
      Drupal.quicktabs.prepare(this);
    });
  }
}

// Setting up the inital behaviours
Drupal.quicktabs.prepare = function(el) {
  // el.id format: "quicktabs-$name"
  var qt_name = Drupal.quicktabs.getQTName(el);
  var $ul = $(el).find('ul.quicktabs-tabs:first');
  $ul.find('li a').each(function(i, element){
    element.myTabIndex = i;
    element.qt_name = qt_name;
    var tab = new Drupal.quicktabs.tab(element);
    var parent_li = $(element).parents('li').get(0);
    if ($(parent_li).hasClass('active')) {
      $(element).addClass('quicktabs-loaded');
    }
    $(element).once(function() {$(this).bind('click', {tab: tab}, Drupal.quicktabs.clickHandler);});
  });
}

Drupal.quicktabs.clickHandler = function(event) {
  var tab = event.data.tab;
  var element = this;
  // Set clicked tab to active.
  $(this).parents('li').siblings().removeClass('active');
  $(this).parents('li').addClass('active');

  // Hide all tabpages.
  tab.container.children().addClass('quicktabs-hide');
  
  if (!tab.tabpage.hasClass("quicktabs-tabpage")) {
    tab = new Drupal.quicktabs.tab(element);
  }

  tab.tabpage.removeClass('quicktabs-hide');
  return false;
}

// Constructor for an individual tab
Drupal.quicktabs.tab = function (el) {
  this.element = el;
  this.tabIndex = el.myTabIndex;
  var qtKey = 'qt_' + el.qt_name;
  var i = 0;
  for (var key in Drupal.settings.quicktabs[qtKey].tabs) {
    if (i == this.tabIndex) {
      this.tabObj = Drupal.settings.quicktabs[qtKey].tabs[key];
      this.tabKey = key;
    }
    i++;
  }
  this.tabpage_id = 'quicktabs-tabpage-' + el.qt_name + '-' + this.tabKey;
  this.container = $('#quicktabs-container-' + el.qt_name);
  this.tabpage = this.container.find('#' + this.tabpage_id);
}

if (Drupal.ajax) {
  /**
   * Handle an event that triggers an AJAX response.
   *
   * We unfortunately need to override this function, which originally comes from
   * misc/ajax.js, in order to be able to cache loaded tabs, i.e. once a tab
   * content has loaded it should not need to be loaded again.
   *
   * I have removed all comments that were in the original core function, so that
   * the only comments inside this function relate to the Quicktabs modification
   * of it.
   */
  Drupal.ajax.prototype.eventResponse = function (element, event) {
    var ajax = this;

    if (ajax.ajaxing) {
      return false;
    }
  
    try {
      if (ajax.form) {
        if (ajax.setClick) {
          element.form.clk = element;
        }
  
        ajax.form.ajaxSubmit(ajax.options);
      }
      else {
        // Do not perform an ajax request for already loaded Quicktabs content.
        if (!$(element).hasClass('quicktabs-loaded')) {
          ajax.beforeSerialize(ajax.element, ajax.options);
          $.ajax(ajax.options);
          if ($(element).parents('ul').hasClass('quicktabs-tabs')) {
            $(element).addClass('quicktabs-loaded');
          }
        }
      }
    }
    catch (e) {
      ajax.ajaxing = false;
      alert("An error occurred while attempting to process " + ajax.options.url + ": " + e.message);
    }
    return false;
  };
}


})(jQuery);
;
