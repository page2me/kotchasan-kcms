function defaultSubmit(ds) {
  for (var prop in ds) {
    var val = ds[prop];
    if (prop == 'alert') {
      alert(val);
    }
    if (prop == 'location') {
      window.location = val.replace(/&amp;/g, '&');
    }
    if (prop == 'input') {
      el = $G(val);
      el.invalid();
      el.focus();
    }
  }
}
function doFormSubmit(xhr) {
  var datas = xhr.responseText.toJSON();
  if (datas) {
    defaultSubmit(datas);
  } else if (xhr.responseText != '') {
    alert(xhr.responseText);
  }
}
function send(target, query, callback, wait, c) {
  var req = new GAjax();
  req.initLoading(wait || 'wait', false, c);
  req.send(target, query, function (xhr) {
    callback.call(this, xhr);
  });
}