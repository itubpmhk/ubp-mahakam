// Admin panel behaviour.
import 'trix';
import 'trix/dist/trix.css';

/* ---------- pictures inside the news text (Trix attachments) ---------- */
const MAX_IMAGE = 5 * 1024 * 1024;
const csrf = document.querySelector('meta[name="csrf-token"]')?.content;

// only accept images up to 5 MB (videos & links go through the "Media" section)
document.addEventListener('trix-file-accept', (e) => {
  const f = e.file;
  if (!f || !/^image\/(jpeg|png|webp|gif)$/.test(f.type)) {
    e.preventDefault();
    alert('Di dalam teks hanya bisa menyisipkan gambar (JPG, PNG, WEBP, GIF). Video dan link tambahkan di bagian Media.');
  } else if (f.size > MAX_IMAGE) {
    e.preventDefault();
    alert('Ukuran gambar maksimal 5 MB.');
  }
});

// upload the picture as soon as it is dropped / pasted / chosen
document.addEventListener('trix-attachment-add', (e) => {
  const att = e.attachment;
  const editor = e.target;
  const url = editor.dataset.uploadUrl;
  if (!att.file || !url) return;

  const form = new FormData();
  form.append('file', att.file);
  const xhr = new XMLHttpRequest();
  xhr.open('POST', url, true);
  xhr.setRequestHeader('X-CSRF-TOKEN', csrf || '');
  xhr.setRequestHeader('Accept', 'application/json');
  xhr.upload.onprogress = (ev) => { if (ev.lengthComputable) att.setUploadProgress((ev.loaded / ev.total) * 100); };
  xhr.onload = () => {
    let data = {};
    try { data = JSON.parse(xhr.responseText); } catch (_) { /* not json */ }
    if (xhr.status >= 200 && xhr.status < 300 && data.url) {
      att.setAttributes({ url: data.url, href: data.url });
    } else {
      att.remove();
      const msg = data.errors?.file?.[0] || data.message || 'Upload gambar gagal.';
      alert(msg);
    }
  };
  xhr.onerror = () => { att.remove(); alert('Upload gambar gagal. Periksa koneksi.'); };
  xhr.send(form);
});

// Ask before deleting
document.addEventListener('submit', (e) => {
  const form = e.target;
  if (form instanceof HTMLFormElement && form.dataset.confirm && !window.confirm(form.dataset.confirm)) {
    e.preventDefault();
  }
});

// Mobile sidebar
document.querySelectorAll('[data-toggle-side]').forEach((btn) =>
  btn.addEventListener('click', () => document.body.classList.toggle('side-open'))
);

// Success messages fade away
document.querySelectorAll('.alert[data-autohide]').forEach((el) =>
  setTimeout(() => el.classList.add('hide'), 4000)
);

// Image preview for cover / thumbnail inputs
document.querySelectorAll('[data-preview-input]').forEach((input) => {
  const box = document.querySelector(`[data-preview="${input.dataset.previewInput}"]`);
  input.addEventListener('change', () => {
    const file = input.files && input.files[0];
    if (!box || !file) return;
    const img = document.createElement('img');
    img.src = URL.createObjectURL(file);
    box.replaceChildren(img);
  });
});

// News media rows: add / remove / switch between file and URL
const list = document.getElementById('new-media');
const tpl = document.getElementById('media-template');
const addBtn = document.querySelector('[data-add-media]');

function syncRow(row) {
  const type = row.querySelector('[data-media-type]').value;
  const file = row.querySelector('[data-media-file]');
  const url = row.querySelector('[data-media-url]');
  const isFile = type === 'image' || type === 'video';
  file.hidden = !isFile;
  url.hidden = isFile;
  file.accept = type === 'video' ? 'video/mp4,video/webm,video/quicktime' : 'image/*';
  url.placeholder = type === 'youtube' ? 'https://www.youtube.com/watch?v=…' : 'https://…';
  if (!isFile) file.value = '';
}

if (list && tpl && addBtn) {
  let next = 0;
  addBtn.addEventListener('click', () => {
    const html = tpl.innerHTML.replaceAll('__i__', String(next++));
    const wrap = document.createElement('div');
    wrap.innerHTML = html.trim();
    const row = wrap.firstElementChild;
    list.appendChild(row);
    syncRow(row);
  });
  list.addEventListener('change', (e) => {
    if (e.target.matches('[data-media-type]')) syncRow(e.target.closest('.media-row'));
  });
  list.addEventListener('click', (e) => {
    if (e.target.closest('[data-remove-row]')) e.target.closest('.media-row').remove();
  });
}
