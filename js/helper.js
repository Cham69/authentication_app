function spinner(spinnerElement, option){
    if(option === 'on'){
        spinnerElement.classList.add('spinner-border');
    }else{
        spinnerElement.classList.remove('spinner-border');
    }
}

function callToast(message, type, url){
    let toastColor;
    if(type === 'success'){
        toastColor = 'rgba(28, 179, 53, 0.5)';
    }else if(type === 'failed'){
        toastColor = 'rgba(255, 0, 0, 0.5)';
    }
    Toastify({
            text: message,
            duration: 4000,
            gravity: "top",
            position: "right",
            offset: {
                y: 50
            },
            stopOnFocus: true, 
            style: {
                background: toastColor, 
                borderRadius: "10px", 
                color: "#fff",
                padding: "10px 20px",
                fontSize: "14px",
                }
            }).showToast();

            setTimeout(() => {
                window.location.href = url;
            }, 4000);
}
