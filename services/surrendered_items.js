_ = (el) => document.querySelector(el);
_evt = (el, evt, fn) => el.addEventListener(evt, fn);

_('.nav .surrendered_items_btn').classList.add('active');
