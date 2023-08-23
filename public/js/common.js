/**
 * Only submit form once
 *
 * @param {string} idElement
 * @param {string} idForm
 * 
 * @returns {void}
 */
function submitFormOnce(idElement, idForm) {
    document.getElementById(idElement).removeAttribute('onclick');
    document.getElementById(idElement).disabled=true;
    document.getElementById(idForm).submit();
}