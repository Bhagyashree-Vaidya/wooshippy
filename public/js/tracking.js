(function () {
  var steps = ['Order Confirmed', 'Shipped', 'In Transit', 'Out for Delivery', 'Delivered'];

  function statusKey(status) {
    var value = String(status || '').toLowerCase();
    if (value.indexOf('delivered') !== -1) return 'delivered';
    if (value.indexOf('out') !== -1 && value.indexOf('delivery') !== -1) return 'out_for_delivery';
    if (value.indexOf('exception') !== -1 || value.indexOf('failure') !== -1 || value.indexOf('return') !== -1) return 'exception';
    if (value.indexOf('transit') !== -1 || value.indexOf('shipped') !== -1) return 'in_transit';
    return 'unknown';
  }

  function completedStepCount(status) {
    var key = statusKey(status);
    if (key === 'delivered') return 5;
    if (key === 'out_for_delivery') return 4;
    if (key === 'in_transit') return 3;
    if (key === 'exception') return 2;
    return 1;
  }

  function renderResult(container, data) {
    var events = Array.isArray(data.events) ? data.events : [];
    var key = statusKey(data.status);
    var completed = completedStepCount(data.status);
    var lastUpdate = events.length && events[0].datetime ? events[0].datetime : '';
    var html = '<article class="wooshippy-result wooshippy-result--' + key + '">';

    html += '<div class="wooshippy-result__status">';
    html += '<div><span class="wooshippy-tracking__kicker">Current status</span>';
    html += '<h3>' + escapeHtml(formatStatus(data.status || 'Unknown')) + '</h3>';
    html += '<p>' + escapeHtml(data.tracking_number || '') + '</p></div>';
    html += '<span class="wooshippy-result__badge">' + escapeHtml(formatStatus(key.replace(/_/g, ' '))) + '</span>';
    html += '</div>';

    html += '<ol class="wooshippy-progress" aria-label="Shipment progress">';
    steps.forEach(function (step, index) {
      html += '<li class="' + (index < completed ? 'is-complete' : '') + '"><span></span>' + escapeHtml(step) + '</li>';
    });
    html += '</ol>';

    html += '<dl class="wooshippy-details">';
    html += detail('Carrier', data.carrier || 'Not provided');
    html += detail('Service', data.service || 'Standard shipment');
    html += detail('Destination', data.destination || 'Hidden for privacy');
    html += detail('Last update', lastUpdate || 'Waiting for carrier scan');
    html += '</dl>';

    if (data.public_url) {
      html += '<a class="wooshippy-result__link" href="' + escapeHtml(data.public_url) + '" target="_blank" rel="noopener noreferrer">Open carrier tracking page</a>';
    }

    html += '<div class="wooshippy-timeline"><h4>Shipment timeline</h4>';
    if (events.length) {
      html += '<ol class="wooshippy-timeline__events">';
      events.forEach(function (event) {
        html += '<li><span class="wooshippy-timeline__dot"></span><div>';
        html += '<strong>' + escapeHtml(event.status || event.message || 'Shipment update') + '</strong>';
        html += '<time>' + escapeHtml(event.datetime || '') + '</time>';
        if (event.location) html += '<small>' + escapeHtml(event.location) + '</small>';
        html += '</div></li>';
      });
      html += '</ol>';
    } else {
      html += '<p class="wooshippy-timeline__empty">No carrier events are available yet. Please check again after the next scan.</p>';
    }
    html += '</div></article>';

    container.innerHTML = html;
    container.hidden = false;
  }

  function detail(label, value) {
    return '<div><dt>' + escapeHtml(label) + '</dt><dd>' + escapeHtml(value) + '</dd></div>';
  }

  function formatStatus(value) {
    return String(value || '').replace(/_/g, ' ').replace(/\b\w/g, function (letter) { return letter.toUpperCase(); });
  }

  function escapeHtml(value) {
    return String(value).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;');
  }

  function setMessage(container, message, type) {
    container.textContent = message;
    container.className = 'wooshippy-tracking__message' + (type ? ' is-' + type : '');
    container.hidden = !message;
  }

  document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-wooshippy-tracking]').forEach(function (root) {
      var form = root.querySelector('[data-wooshippy-tracking-form]');
      var message = root.querySelector('[data-wooshippy-tracking-message]');
      var result = root.querySelector('[data-wooshippy-tracking-result]');
      var empty = root.querySelector('[data-wooshippy-empty]');
      var submit = root.querySelector('[data-wooshippy-submit]');

      form.addEventListener('submit', function (event) {
        event.preventDefault();
        var trackingNumber = form.elements.tracking_number.value.trim();
        if (!trackingNumber) {
          setMessage(message, wooshippyTracking.messages.missingTrackingNumber, 'error');
          return;
        }

        submit.disabled = true;
        setMessage(message, wooshippyTracking.messages.loading, 'loading');
        result.hidden = true;
        empty.hidden = true;
        result.innerHTML = '';

        fetch(wooshippyTracking.endpoint, {
          method: 'POST',
          headers: {'Content-Type': 'application/json', 'X-WP-Nonce': wooshippyTracking.nonce},
          body: JSON.stringify({tracking_number: trackingNumber, carrier: form.elements.carrier ? form.elements.carrier.value.trim() : ''})
        }).then(function (response) {
          return response.json().then(function (body) {
            if (!response.ok) throw new Error(body.message || wooshippyTracking.messages.requestFailed);
            return body;
          });
        }).then(function (body) {
          setMessage(message, '', '');
          renderResult(result, body);
        }).catch(function (error) {
          empty.hidden = false;
          setMessage(message, error.message || wooshippyTracking.messages.requestFailed, 'error');
        }).finally(function () {
          submit.disabled = false;
        });
      });
    });
  });
})();
