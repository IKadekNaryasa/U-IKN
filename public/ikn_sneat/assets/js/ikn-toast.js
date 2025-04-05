'use strict';

(function () {
  const toastElement = document.querySelector('#toastIkn');

  if (toastElement) {
    toastElement.classList.add('toast', 'position-fixed', 'top-0', 'end-0', 'm-3', 'show');
    toastElement.style.zIndex = '1055'; 
    toastElement.style.minWidth = '250px';
    toastElement.style.backgroundColor = '#333'; 
    toastElement.style.color = '#fff'; 
    toastElement.style.padding = '10px 20px';
    toastElement.style.borderRadius = '8px';
    toastElement.style.boxShadow = '0px 4px 6px rgba(0, 0, 0, 0.1)';

    const closeButton = document.createElement('button');
    closeButton.innerHTML = '&times;';
    closeButton.style.border = 'none';
    closeButton.style.background = 'transparent';
    closeButton.style.color = '#fff';
    closeButton.style.fontSize = '20px';
    closeButton.style.cursor = 'pointer';
    closeButton.style.position = 'absolute';
    closeButton.style.top = '5px';
    closeButton.style.right = '10px';
    closeButton.onclick = function () {
      toastElement.style.display = 'none';
    };

    toastElement.appendChild(closeButton);
  }

  window.iknToast = function (message, duration = 3000) {
    if (toastElement) {
      toastElement.innerHTML = message;
      toastElement.appendChild(closeButton);
      toastElement.style.display = 'block';

      setTimeout(() => {
        toastElement.style.display = 'none';
      }, duration);
    }
  };
})();
