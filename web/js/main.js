// js/main.js - small helpers for front-end
function postJSON(url, data, cb) {
  fetch(url, { method:'POST', headers:{'Content-Type':'application/json'}, body: JSON.stringify(data) })
    .then(r => r.json()).then(cb).catch(err => { console.error(err); alert('Request failed'); });
}
