(function () {
  function renderResult(container, data) {
    var events = Array.isArray(data.events) ? data.events : [];
    var html = '<div class="wooshippy-tracking__card">';

    html += '<h3>' + escapeHtml(data.status || 'Tracking found') + '</h3>';
    html += '<p><strong>Tracking:</strong> ' + escapeHtml(data.tracking_number || '') + '</p>';

    if (data.carrier) {
      html += '<p><strong>Carrier:</strong> ' + escapeHtml(data.carrier) + '</p>';
    }

    if (events.length) {
      html += '<ol class="wooshippy-tracking__events">';
      events.forEach(function (event) {
        html += '<li>';
        html += '<strong>' + escapeHtml(event.status || 'Update') + '</strong>';
        if (event.datetime) {
          html += '<span>' + escapeHtml(event.datetime) + '</span>';
        }
        if (event.location) {
          html += '<small>' + escapeHtml(event.location) + '</small>';
        }
        html += '</li>';
      });
      html += '</ol>';
    }

    html += '</div>';
    container.innerHTML = html;
    container.hidden = false;
  }

  function escapeHtml(value) {
    return String(value)
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;')
      .replace(/'/g, '&#039;');
  }

  function setMessage(container, message) {
    container.textContent = message;
    container.hidden = !message;
  }

  document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-wooshippy-tracking]').forEach(function (root) {
      var form = root.querySelector('[data-wooshippy-tracking-form]');
      var message = root.querySelector('[data-wooshippy-tracking-message]');
      var result = root.querySelector('[data-wooshippy-tracking-result]');

      form.addEventListener('submit', function (event) {
        event.preventDefault();

        var trackingNumber = form.elements.tracking_number.value.trim();
        if (!trackingNumber) {
          setMessage(message, wooshippyTracking.messages.missingTrackingNumber);
          return;
        }

        setMessage(message, 'Loading tracking details...');
        result.hidden = true;
        result.innerHTML = '';

        fetch(wooshippyTracking.endpoint, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-WP-Nonce': wooshippyTracking.nonce
          },
          body: JSON.stringify({
            tracking_number: trackingNumber
          })
        })
          .then(function (response) {
            return response.json().then(function (body) {
              if (!response.ok) {
                throw new Error(body.message || wooshippyTracking.messages.requestFailed);
              }
              return body;
            });
          })
          .then(function (body) {
            setMessage(message, '');
            renderResult(result, body);
          })
          .catch(function (error) {
            setMessage(message, error.message || wooshippyTracking.messages.requestFailed);
          });
      });
    });
  });
})();

