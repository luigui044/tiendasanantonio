const chk = document.querySelector('#chk-credito-fiscal');
const creditoFiscal = document.querySelector('#credito_fiscal');
const dui = document.querySelector('#dui');

const activarCreditoFiscal = () => {
    if (chk.checked) {
        creditoFiscal.disabled = false;
        dui.disabled = true;
    } else {
        creditoFiscal.disabled = true;
        dui.disabled = false;
    } 
}

activarCreditoFiscal();
chk.addEventListener('click', activarCreditoFiscal);
