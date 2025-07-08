// Modal pop-up for Join Us
const joinBtn = document.getElementById('joinBtn');
const joinPopup = document.getElementById('join-popup');
const closePopup = document.getElementById('close-popup');
if (joinBtn && joinPopup && closePopup) {
    joinBtn.onclick = () => joinPopup.style.display = 'flex';
    closePopup.onclick = () => joinPopup.style.display = 'none';
    window.onclick = (e) => {
        if (e.target === joinPopup) joinPopup.style.display = 'none';
    };
}
// Cookie consent
const cookieConsent = document.getElementById('cookie-consent');
const acceptCookies = document.getElementById('accept-cookies');
if (cookieConsent && acceptCookies) {
    if (!localStorage.getItem('cookieAccepted')) {
        cookieConsent.style.display = 'block';
    }
    acceptCookies.onclick = () => {
        localStorage.setItem('cookieAccepted', 'yes');
        cookieConsent.style.display = 'none';
    };
}
// Placeholder for dynamic content (news feed, carousel, etc.)
// ...
