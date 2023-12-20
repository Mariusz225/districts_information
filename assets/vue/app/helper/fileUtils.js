export function toDataURL(url) {
  return new Promise((resolve, reject) => {
    const xhr = new XMLHttpRequest();
    xhr.onload = function() {
      const reader = new FileReader();
      reader.onloadend = function() {
        resolve(reader.result);
      };
      reader.readAsDataURL(xhr.response);
    };
    xhr.onerror = function() {
      reject(new Error('Nie udało się pobrać danych URL.'));
    };
    xhr.open('GET', url);
    xhr.responseType = 'blob';
    xhr.send();
  });
}
