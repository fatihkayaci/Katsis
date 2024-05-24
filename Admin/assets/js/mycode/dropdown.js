function dropDownn(inputID, dropdownCont) {
    var neredenInput = document.getElementById(inputID);
    var dropdownContent = document.getElementById(dropdownCont);
   
    // NeredenInput'a tıklanınca dropdown'u aç
    neredenInput.addEventListener('click', function() {
        dropdownContent.style.display = 'flex';
    });

    // Harici bir yere tıklanınca dropdown'u kapat
    document.addEventListener('click', function(e) {
        if (!dropdownContent.contains(e.target) && e.target !== neredenInput) {
            dropdownContent.style.display = 'none';
        }
    });

    // Arama fonksiyonu
    document.getElementById('searchInput').addEventListener('input', function() {
        var searchValue = this.value.toLowerCase();
        var buttons = dropdownContent.querySelectorAll('button');
        buttons.forEach(function(button) {
            var buttonText = button.textContent.toLowerCase();
            if (buttonText.includes(searchValue)) {
                button.style.display = 'block';
            } else {
                button.style.display = 'none';
            }
        });
    });

    // Butonlardan birine tıklandığında
    dropdownContent.addEventListener('click', function(e) {
        if (e.target.tagName === 'BUTTON') {
            e.preventDefault(); // Varsayılan form gönderme davranışını engelle
            var buttonText = e.target.textContent;
            id = e.target.getAttribute('data-user-id');
           console.log(id);
           var inputElement = document.getElementById(inputID);

            if (inputElement) {
                inputElement.setAttribute('data-user-id',id );
            }
            neredenInput.value = buttonText.trim();
            dropdownContent.style.display = 'none';
        }
    });

};